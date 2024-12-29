<?php

namespace App\Filament\Resources;

use App\Filament\Exports\OrderExporter;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers\OrderScheduleRelationManager;
use App\Models\Course;
use App\Models\Order;
use App\Models\Package;
use App\Models\Schedule;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $label = 'Students';

    protected static ?string $navigationLabel = 'Students';

    public static ?string $slug = 'students';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()->exporter(OrderExporter::class),
            ])
            ->columns([
                TextColumn::make('user.name')->label('Username')->searchable(),
                TextColumn::make('user.email')->label('User Email')->searchable(),
                TextColumn::make('combined')
                    ->label('Course and Package Name')
                    ->getStateUsing(function ($record) {
                        $course = $record->course->name ?? $record->package->name;

                        return $course;
                    }),
            ])
            ->filters([
                SelectFilter::make('package_id')
                    ->label('Package Course')
                    ->options(
                        Package::whereHas('order')->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->columnSpan(2),
                SelectFilter::make('course_id')
                    ->label('Single course')
                    ->options(
                        Course::whereHas('order')->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->query(function (Builder $query, $data) {
                        $query->when($data['value'] ?? null, function ($query, $value) {
                            $query->where(function ($query) use ($value) {
                                $query->where('course_id', $value)
                                    ->orWhereHas('package', function ($query) use ($value) {
                                        $query->whereJsonContains('courses', $value);
                                    });
                            });
                        });
                    })
                    ->columnSpan(2),
                SelectFilter::make('training_mode')
                    ->label('Training mode')
                    ->options(
                        Schedule::distinct()->pluck('training_mode', 'training_mode')->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->query(fn (Builder $query, $data) => $query->when($data['value'] ?? null, fn (Builder $query, $value) => $query->whereHas('schedule', fn ($query) => $query->where('training_mode', $value)))),
                SelectFilter::make('start_date')
                    ->label('Batch Date')
                    ->options(
                        Schedule::distinct()->pluck('start_date', 'start_date')->toArray()
                    )
                    ->searchable()
                    ->query(fn (Builder $query, $data) => $query->when($data['value'] ?? null, fn (Builder $query, $value) => $query->whereHas('schedule', fn ($query) => $query->where('start_date', $value))))
                    ->columnSpan(2),
                SelectFilter::make('batch_time')
                    ->label('Batch Time')
                    ->options(
                        Schedule::distinct()->pluck('time', 'time')->toArray()
                    )
                    ->searchable()
                    ->query(fn (Builder $query, $data) => $query->when($data['value'] ?? null, fn (Builder $query, $value) => $query->whereHas('schedule', fn ($query) => $query->where('time', $value))))
                    ->preload(),
            ], layout: FiltersLayout::AboveContentCollapsible)->filtersFormColumns(4)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            OrderScheduleRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
