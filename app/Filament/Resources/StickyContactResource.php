<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StickyContactResource\Pages;
use App\Models\Email;
use App\Models\MobileNumber;
use App\Models\StickyContact;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StickyContactResource extends Resource
{
    protected static ?string $model = StickyContact::class;

    protected static ?string $navigationGroup = 'Home page';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return StickyContact::count() === 0;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('mobile_number_id')->options(MobileNumber::pluck('number', 'id'))->searchable()->required(),
                Select::make('email_id')->options(Email::pluck('email', 'id'))->searchable()->required()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mobileNumber.number'),
                TextColumn::make('email.email'),
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
