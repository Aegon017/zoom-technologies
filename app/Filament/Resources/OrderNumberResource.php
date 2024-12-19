<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderNumberResource\Pages;
use App\Models\OrderNumber;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderNumberResource extends Resource
{
    protected static ?string $model = OrderNumber::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Payment Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('prefix')->maxLength(5)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('prefix'),
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
            'index' => Pages\ListOrderNumbers::route('/'),
            'create' => Pages\CreateOrderNumber::route('/create'),
            'edit' => Pages\EditOrderNumber::route('/{record}/edit'),
        ];
    }
}
