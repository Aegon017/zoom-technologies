<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OtherStudyMaterialResource\Pages;
use App\Filament\Resources\OtherStudyMaterialResource\RelationManagers;
use App\Models\OtherStudyMaterial;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OtherStudyMaterialResource extends Resource
{
    protected static ?string $model = OtherStudyMaterial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('name')->searchable(),
                ImageColumn::make('image')->height(210),
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
            'index' => Pages\ListOtherStudyMaterials::route('/'),
            'create' => Pages\CreateOtherStudyMaterial::route('/create'),
            'edit' => Pages\EditOtherStudyMaterial::route('/{record}/edit'),
        ];
    }
}
