<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction as ActionsExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->required()->unique(ignoreRecord: true),
                PhoneInput::make('phone'),
                TextInput::make('password')->required(),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('phone'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
