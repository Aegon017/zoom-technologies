<?php

namespace App\Filament\Resources;

use App\Filament\Exports\OrderExporter;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers\OrderScheduleRelationManager;
use App\Models\Course;
use App\Models\Order;
use App\Models\Schedule;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
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
                Filter::make('course')
                    ->form([
                        Group::make()->schema([
                            Select::make('course_id')
                                ->label('Course')
                                ->options(Course::whereHas('order')->pluck('name', 'id'))
                                ->live()
                                ->searchable()
                                ->preload(),
                            Select::make('training_mode')
                                ->label('Training mode')
                                ->options(function (Get $get) {
                                    $courseId = $get('course_id');
                                    if (! $courseId) {
                                        return [];
                                    }

                                    return Schedule::whereHas('orderSchedule')
                                        ->where('course_id', $courseId)
                                        ->distinct()
                                        ->get()
                                        ->pluck('training_mode', 'training_mode')
                                        ->toArray();
                                })
                                ->searchable()
                                ->preload()
                                ->disabled(fn (Get $get) => ! $get('course_id')),
                            Select::make('schedule_id')
                                ->label('Batch')
                                ->options(function (Get $get) {
                                    $courseId = $get('course_id');
                                    $trainingMode = $get('training_mode');
                                    if (! $courseId || ! $trainingMode) {
                                        return [];
                                    }

                                    return Schedule::whereHas('orderSchedule')
                                        ->where('course_id', $courseId)
                                        ->where('training_mode', $trainingMode)
                                        ->distinct()
                                        ->get()
                                        ->mapWithKeys(function ($schedule) {
                                            return [$schedule->id => $schedule->formatted_schedule];
                                        })
                                        ->toArray();
                                })->columnSpanFull()
                                ->searchable()
                                ->preload()
                                ->disabled(fn (Get $get) => ! $get('training_mode')),
                        ])->columns(2),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['course_id'] ?? null,
                                fn (Builder $query, $courseId) => $query
                                    ->where(function (Builder $subQuery) use ($courseId) {
                                        $subQuery->whereHas('course', fn (Builder $courseQuery) => $courseQuery->where('id', $courseId))
                                            ->orWhereHas('package', fn (Builder $packageQuery) => $packageQuery->whereJsonContains('courses', (string) $courseId));
                                    })
                            )
                            ->when(
                                $data['training_mode'],
                                fn (Builder $query, $trainingMode) => $query->whereHas(
                                    'schedule',
                                    fn (Builder $scheduleQuery) => $scheduleQuery->where('training_mode', $trainingMode)
                                )
                            )
                            ->when(
                                $data['schedule_id'],
                                fn (Builder $query, $scheduleId): Builder => $query->whereHas('schedule', fn (Builder $query) => $query->where('schedule_id', $scheduleId)),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['course_id'] ?? null) {
                            $indicators[] = Indicator::make('Course: '.Course::where('id', $data['course_id'])->first()->name)
                                ->removeField('course_id');
                        }

                        if ($data['training_mode'] ?? null) {
                            $indicators[] = Indicator::make('Training Mode: '.$data['training_mode'])
                                ->removeField('training_mode');
                        }

                        if ($data['schedule_id'] ?? null) {
                            $indicators[] = Indicator::make('Batch: '.Schedule::where('id', $data['schedule_id'])->first()->formatted_schedule)
                                ->removeField('schedule_id');
                        }

                        return $indicators;
                    })->columnSpanFull(),
            ], layout: FiltersLayout::AboveContentCollapsible)->filtersFormColumns('4')
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
