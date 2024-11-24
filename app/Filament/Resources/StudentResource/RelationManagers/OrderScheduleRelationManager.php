<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderScheduleRelationManager extends RelationManager
{
    protected static string $relationship = 'orderSchedule';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('schedule_id')
                    ->options(
                        Schedule::all()->mapWithKeys(function ($schedule) {
                            return [
                                $schedule->id => "{$schedule->start_date} - {$schedule->time} ({$schedule->training_mode})"
                            ];
                        })
                    )
                    ->searchable()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('schedule.start_date')->date()->label('Batch date'),
                TextColumn::make('schedule.time')->time('H i:A')->label('time'),
                TextColumn::make('schedule.training_mode')->label('training_mode')
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }
}
