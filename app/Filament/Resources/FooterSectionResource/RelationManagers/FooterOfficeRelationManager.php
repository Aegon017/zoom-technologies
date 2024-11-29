<?php

namespace App\Filament\Resources\FooterSectionResource\RelationManagers;

use App\Models\Email;
use App\Models\MobileNumber;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FooterOfficeRelationManager extends RelationManager
{
    protected static string $relationship = 'footerOffice';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('location')->required(),
                TextInput::make('location_url')->url(),
                Select::make('mobile')->options(MobileNumber::pluck('number', 'id'))->multiple()->searchable()->required(),
                TextInput::make('landline'),
                Select::make('email')->options(Email::pluck('email', 'id'))->multiple()->searchable()->required()->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('location')->wrap(),
                TextColumn::make('mobile')->getStateUsing(fn ($record) => is_array($record->mobile) ? implode(', ', MobileNumber::whereIn('id', $record->mobile)->pluck('number')->toArray()) : '')->wrap(),
                TextColumn::make('email')->getStateUsing(fn ($record) => is_array($record->email) ? implode(', ', Email::whereIn('id', $record->email)->pluck('email')->toArray()) : '')->wrap(),
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
