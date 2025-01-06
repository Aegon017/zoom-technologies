<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use App\Models\Timezone;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                TextInput::make('meeting_url')
                    ->label('Meeting URL')
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
                TimePicker::make('time')->seconds(false)->label('Start time')->seconds(false)->required(),
                TimePicker::make('end_time')->seconds(false)->required(),
                Select::make('timezone_id')
                    ->label('Timezone')
                    ->options(
                        Timezone::selectRaw("id, CONCAT(abbreviation,' - ( ', offset, ' )') as label")
                            ->pluck('label', 'id')
                    )
                    ->searchable()
                    ->required(),
                TextInput::make('duration')->required()
                    ->default(fn($livewire) => $livewire->getOwnerRecord()->duration),
                Select::make('duration_type')
                    ->options(['Month' => 'Month', 'Week' => 'Week', 'Day' => 'Day'])
                    ->default(fn($livewire) => $livewire->getOwnerRecord()->duration_type)
                    ->required(),
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
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('start_date')->searchable()->date(),
                TextColumn::make('time')->time('h:i A'),
                TextColumn::make('end_time')->time('h:i A'),
                TextColumn::make('training_mode'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->visible(fn() => request()->input('components.0.updates.activeTab', 'true') === 'true'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public function getTabs(): array
    {
        return [
            'false' => Tab::make('Past Schedules')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', false)),
            'true' => Tab::make('Upcoming Schedules')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', true)),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'true';
    }
}
