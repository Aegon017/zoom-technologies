<?php

namespace App\Filament\Resources\FeatureSectionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeatureCardRelationManager extends RelationManager
{
    protected static string $relationship = 'featureCard';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('icon')->label('favicon_icon')->required(),
                TextInput::make('number'),
                TextInput::make('title')->required(),
                TextInput::make('content')->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('number'),
                TextColumn::make('title'),
            TextColumn::make('content')->wrap()
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
