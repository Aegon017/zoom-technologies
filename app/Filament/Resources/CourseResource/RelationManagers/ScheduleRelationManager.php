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
                        'Classroom' => 'Classroom'
                    ])->required(),
                DatePicker::make('start_date')->native(false)->minDate(now())->required(),
                TimePicker::make('time')->seconds(false)->required(),
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
                    ])->columnSpanFull()->required(),
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
