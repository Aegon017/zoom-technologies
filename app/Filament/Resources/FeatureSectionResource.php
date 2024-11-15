<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeatureSectionResource\Pages;
use App\Filament\Resources\FeatureSectionResource\RelationManagers;
use App\Filament\Resources\FeatureSectionResource\RelationManagers\FeatureCardRelationManager;
use App\Models\FeatureSection;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeatureSectionResource extends Resource
{
    protected static ?string $model = FeatureSection::class;
    protected static ?string $navigationGroup = 'Home page';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),
                TextInput::make('heading')
                    ->columnSpanFull()
                    ->required(),
                RichEditor::make('content')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('heading')
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
            FeatureCardRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeatureSections::route('/'),
            'create' => Pages\CreateFeatureSection::route('/create'),
            'edit' => Pages\EditFeatureSection::route('/{record}/edit'),
        ];
    }
}
