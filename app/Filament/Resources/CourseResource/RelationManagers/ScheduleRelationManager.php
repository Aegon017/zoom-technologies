<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleRelationManager extends RelationManager
{
    protected static string $relationship = 'schedule';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('training_mode')
                    ->options([
                        'Online' => 'Online',
                        'Classroom' => 'Classroom',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        if ($state !== 'Online') {
                            $set('zoom_meeting_url', null);
                            $set('meeting_id', null);
                            $set('meeting_password', null);
                        }
                    }),
                TextInput::make('zoom_meeting_url')
                    ->label('Zoom Meeting URL')
                    ->hidden(fn($get) => $get('training_mode') !== 'Online')
                    ->url()
                    ->required(),
                TextInput::make('meeting_id')
                    ->label('Meeting ID')
                    ->hidden(fn($get) => $get('training_mode') !== 'Online')
                    ->required(),
                TextInput::make('meeting_password')
                    ->label('Meeting Password')
                    ->hidden(fn($get) => $get('training_mode') !== 'Online')
                    ->required(),
                DatePicker::make('start_date')->native(false)->minDate(now())->required(),
                TimePicker::make('time')->label('Start time')->seconds(false)->required(),
                TimePicker::make('end_time')->seconds(false)->required(),
                TextInput::make('duration')->required(),
                Select::make('duration_type')->options(['Month' => 'Month', 'Week' => 'Week', 'Day' => 'Day'])->required(),
                Select::make('day_off')
                    ->multiple()
                    ->options([
                        'Monday' => 'Monday',
                        'Tuesday' => 'Tuesday',
                        'Wednesday' => 'Wednesday',
                        'Thursday' => 'Thursday',
                        'Friday' => 'Friday',
                        'Saturday' => 'Saturday',
                        'Sunday' => 'Sunday',
                    ])->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('start_date')
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('start_date')->searchable()->date(),
                TextColumn::make('time'),
                TextColumn::make('end_time'),
                TextColumn::make('training_mode')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
