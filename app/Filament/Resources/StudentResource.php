<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers\OrderScheduleRelationManager;
use App\Models\Order;
use App\Models\Schedule;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

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
            ->columns([
                TextColumn::make('user.name')->searchable(),
                TextColumn::make('user.email')->searchable(),
                TextColumn::make('combined')
                    ->label('Course and Package Name')
                    ->getStateUsing(function ($record) {
                        $course = $record->course->name ?? $record->package->name;

                        return $course;
                    }),
            ])
            ->filters([
                SelectFilter::make('Course')
                    ->relationship('course', 'name')
                    ->preload()
                    ->searchable(),
                SelectFilter::make('Batch date')
                    ->relationship('schedule', 'start_date')
                    ->preload()
                    ->searchable(),
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(2)
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
