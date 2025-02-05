<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudyMaterialRelationManager extends RelationManager
{
    protected static string $relationship = 'studyMaterial';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('material_url'),
                FileUpload::make('material_pdf')->acceptedFileTypes(['application/pdf'])->disk('public')->directory('ebooks/courses')->preserveFilenames()->columnSpanFull(),
                Select::make('subscription')->options([
                    'Direct Access' => 'Direct Access',
                    'Free' => 'Free',
                    'Paid' => 'Paid',
                ])->required(),
                TextInput::make('image_alt')->required(),
                FileUpload::make('image')->disk('public')->directory('study_materials/courses')->preserveFilenames()->columnSpanFull()->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('name')->searchable(),
                ImageColumn::make('image')->height(210),
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
            ])
            ->defaultSort('created_at', 'desc');
    }
}
