<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FreeMaterialSectionResource\Pages;
use App\Models\FreeMaterialSection;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FreeMaterialSectionResource extends Resource
{
    protected static ?string $model = FreeMaterialSection::class;

    protected static ?string $navigationGroup = 'Home page';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('icon')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('content')
                    ->required(),
                TextInput::make('button_name')
                    ->required(),
                TextInput::make('redirect_url')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('content')->wrap(),
                TextColumn::make('redirect_url'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListFreeMaterialSections::route('/'),
            'create' => Pages\CreateFreeMaterialSection::route('/create'),
            'edit' => Pages\EditFreeMaterialSection::route('/{record}/edit'),
        ];
    }
}
