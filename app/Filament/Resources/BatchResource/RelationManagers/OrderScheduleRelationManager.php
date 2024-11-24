<?php

namespace App\Filament\Resources\BatchResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderScheduleRelationManager extends RelationManager
{
    protected static string $relationship = 'orderSchedule';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.user.name')->label('User name')->searchable(),
                TextColumn::make('order.user.email')->label('User email')->searchable(),
                TextColumn::make('order.user.phone')->label('User phone')->searchable(),
            ])
            ->filters([
                SelectFilter::make('order')
                    ->relationship('order.payment', 'status')
                    ->preload()
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
