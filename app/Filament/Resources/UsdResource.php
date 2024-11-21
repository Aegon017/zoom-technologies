<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UsdResource\Pages;
use App\Filament\Resources\UsdResource\RelationManagers;
use App\Models\Usd;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsdResource extends Resource
{
    protected static ?string $model = Usd::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('value')->prefix('$')->required()->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('value')->prefix("$")->numeric(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListUsds::route('/'),
            'create' => Pages\CreateUsd::route('/create'),
            'edit' => Pages\EditUsd::route('/{record}/edit'),
        ];
    }
}
