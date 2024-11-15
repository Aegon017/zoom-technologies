<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MobileNumberResource\Pages;
use App\Filament\Resources\MobileNumberResource\RelationManagers;
use App\Models\MobileNumber;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MobileNumberResource extends Resource
{
    protected static ?string $model = MobileNumber::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('number')
                    ->afterStateUpdated(fn($state) => str_replace(' ', '', $state)) // This will not update the state
                    ->afterStateUpdated(fn($state) => str_replace(' ', '', $state) ? str_replace(' ', '', $state) : $state) // Apply state update
                    ->prefixIcon('heroicon-o-phone')
                    ->helperText('Enter with area code like(+91)')
                    ->tel()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->searchable(),
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
            'index' => Pages\ListMobileNumbers::route('/'),
            'create' => Pages\CreateMobileNumber::route('/create'),
            'edit' => Pages\EditMobileNumber::route('/{record}/edit'),
        ];
    }
}
