<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactLocationResource\Pages;
use App\Models\ContactLocation;
use App\Models\Email;
use App\Models\MobileNumber;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactLocationResource extends Resource
{
    protected static ?string $model = ContactLocation::class;

    protected static ?string $navigationGroup = 'Contact Details';

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('location_type')->required(),
                TextInput::make('city')->required(),
                TextInput::make('address')->required(),
                TextInput::make('map_iframe')->prefixIcon('heroicon-o-map')->required(),
                TextInput::make('landline')->prefixIcon('heroicon-o-phone'),
                Select::make('mobile')->prefixIcon('heroicon-o-device-phone-mobile')->options(MobileNumber::pluck('number', 'id'))->multiple()->searchable()->required(),
                Select::make('email')->prefixIcon('heroicon-o-envelope-open')->options(Email::pluck('email', 'id'))->multiple()->searchable()->required()->required(),
                TextInput::make('website')->prefixIcon('heroicon-o-globe-alt')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('location_type'),
                TextColumn::make('city'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactLocations::route('/'),
            'create' => Pages\CreateContactLocation::route('/create'),
            'edit' => Pages\EditContactLocation::route('/{record}/edit'),
        ];
    }
}
