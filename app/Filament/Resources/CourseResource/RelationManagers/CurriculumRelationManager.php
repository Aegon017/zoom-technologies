<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CurriculumRelationManager extends RelationManager
{
    protected static string $relationship = 'curriculum';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('module_name')->columnSpanFull()->required(),
                RichEditor::make('module_content')->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('module_name')
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('module_name')->searchable(),
                TextColumn::make('module_content')->html(),
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
