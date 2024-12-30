<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudyMaterialPageResource\Pages;
use App\Filament\Resources\StudyMaterialPageResource\RelationManagers;
use App\Models\StudyMaterialPage;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudyMaterialPageResource extends Resource
{
    protected static ?string $model = StudyMaterialPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('page_content')
                    ->schema([
                        TextInput::make('heading')->required(),
                        RichEditor::make('content')->required()
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Page Content')->default('Study material page')
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
            'index' => Pages\ListStudyMaterialPages::route('/'),
            'create' => Pages\CreateStudyMaterialPage::route('/create'),
            'edit' => Pages\EditStudyMaterialPage::route('/{record}/edit'),
        ];
    }
}
