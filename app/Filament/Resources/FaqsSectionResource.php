<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqsSectionResource\Pages;
use App\Models\FaqsSection;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FaqsSectionResource extends Resource
{
    protected static ?string $model = FaqsSection::class;

    protected static ?string $navigationGroup = 'Home page';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('question')->columnSpanFull()->required(),
                RichEditor::make('answer')->columnSpanFull()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->wrap()->searchable(),
                TextColumn::make('answer')->html()->wrap(),
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
            'index' => Pages\ListFaqsSections::route('/'),
            'create' => Pages\CreateFaqsSection::route('/create'),
            'edit' => Pages\EditFaqsSection::route('/{record}/edit'),
        ];
    }
}
