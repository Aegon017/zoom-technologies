<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CorporateTrainingResource\Pages;
use App\Models\CorporateTraining;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CorporateTrainingResource extends Resource
{
    protected static ?string $model = CorporateTraining::class;

    protected static ?string $navigationGroup = 'Home page';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')->columnSpanFull()->required(),
                TextInput::make('image_alt')->required(),
                TextInput::make('redirect_url'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('image_alt'),
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
            'index' => Pages\ListCorporateTrainings::route('/'),
            'create' => Pages\CreateCorporateTraining::route('/create'),
            'edit' => Pages\EditCorporateTraining::route('/{record}/edit'),
        ];
    }
}
