<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactLocationResource\Pages;
use App\Filament\Resources\ContactLocationResource\RelationManagers;
use App\Models\ContactLocation;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                TextInput::make('mobile')->prefixIcon('heroicon-o-device-phone-mobile')->required(),
                TextInput::make('email')->prefixIcon('heroicon-o-envelope-open')->required(),
                TextInput::make('website')->prefixIcon('heroicon-o-globe-alt')->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('location_type'),
                TextColumn::make('city')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
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
