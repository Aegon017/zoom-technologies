<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Models\Schedule;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderScheduleRelationManager extends RelationManager
{
    protected static string $relationship = 'orderSchedule';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('schedule_id')
                    ->label('Schedule')
                    ->options(
                        Schedule::where('course_id', $this->ownerRecord->course_id)
                            ->get()
                            ->mapWithKeys(function ($schedule) {
                                return [
                                    $schedule->id => "{$schedule->course->name} - {$schedule->start_date} - {$schedule->time} ({$schedule->training_mode})",
                                ];
                            })
                    )
                    ->searchable()
                    ->columnSpanFull(),
                FileUpload::make('proof')->columnSpanFull()->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('')
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('schedule.start_date')->date()->label('Batch date'),
                TextColumn::make('schedule.time')->time('h:i A')->label('time'),
                TextColumn::make('schedule.training_mode')->label('training_mode'),
                TextColumn::make('admin_name')->label('changed_by'),
                TextColumn::make('admin_email')->label('Email'),
                TextColumn::make('ip_address')->label('IP Address'),
            ])
            ->filters([
                //
            ])
            ->headerActions([])
            ->actions([
                ActionsAction::make('proof')
                    ->label('download proof')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        return response()->download(storage_path("app/public/{$record->proof}"));
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }
}
