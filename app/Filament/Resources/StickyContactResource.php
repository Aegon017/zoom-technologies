<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StickyContactResource\Pages;
use App\Filament\Resources\StickyContactResource\RelationManagers;
use App\Models\Email;
use App\Models\MobileNumber;
use App\Models\StickyContact;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StickyContactResource extends Resource
{
    protected static ?string $model = StickyContact::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('mobile')->options(MobileNumber::pluck('number', 'id'))->multiple()->searchable()->required(),
                Select::make('email')->options(Email::pluck('email', 'id'))->multiple()->searchable()->required()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mobile')->getStateUsing(fn($record) => is_array($record->mobile) ? implode(', ', MobileNumber::whereIn('id', $record->mobile)->pluck('number')->toArray()) : ''),
                TextColumn::make('email')->getStateUsing(fn($record) => is_array($record->email) ? implode(', ', Email::whereIn('id', $record->email)->pluck('email')->toArray()) : ''),
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
            'index' => Pages\ListStickyContacts::route('/'),
            'create' => Pages\CreateStickyContact::route('/create'),
            'edit' => Pages\EditStickyContact::route('/{record}/edit'),
        ];
    }
}
