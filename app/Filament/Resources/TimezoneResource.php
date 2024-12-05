<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimezoneResource\Pages;
use App\Models\Timezone;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TimezoneResource extends Resource
{
    protected static ?string $model = Timezone::class;

    protected static ?string $navigationGroup = 'Payment Settings';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('timezone_name')->required(),
                TextInput::make('offset')->required(),
                TextInput::make('abbreviation')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('timezone_name')->searchable(),
                TextColumn::make('offset')->searchable(),
                TextColumn::make('abbreviation')->searchable(),
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
            'index' => Pages\ListTimezones::route('/'),
            'create' => Pages\CreateTimezone::route('/create'),
            'edit' => Pages\EditTimezone::route('/{record}/edit'),
        ];
    }
}
