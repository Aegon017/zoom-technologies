<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use App\Models\Curriculum;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubCurriculumRelationManager extends RelationManager
{
    protected static string $relationship = 'subCurriculum';

    public function form(Form $form): Form
    {
        $courseId = $this->ownerRecord->id;

        return $form
            ->schema([
                Select::make('curriculum_id')
                    ->label('Curriculum')
                    ->options(Curriculum::where('course_id', $courseId)->pluck('module_name', 'id'))->required(),
                TextInput::make('name')->required(),
                RichEditor::make('content')->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('curriculum.module_name')->wrap(),
                TextColumn::make('name')->wrap(),
                TextColumn::make('content')->html()->wrap(),
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
