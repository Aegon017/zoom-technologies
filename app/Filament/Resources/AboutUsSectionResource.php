<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutUsSectionResource\Pages;
use App\Filament\Resources\AboutUsSectionResource\RelationManagers;
use App\Models\AboutUsSection;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutUsSectionResource extends Resource
{
    protected static ?string $model = AboutUsSection::class;
    protected static ?string $navigationGroup = 'Home page';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')->columnSpanFull()->required(),
                TextInput::make('image_alt')->required(),
                TextInput::make('video_url')->required(),
                TextInput::make('title')->required(),
                TextInput::make('heading')->required(),
                RichEditor::make('content')->required()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->height(200),
                TextColumn::make('video_url'),
                TextColumn::make('title'),
                TextColumn::make('heading'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
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
            'index' => Pages\ListAboutUsSections::route('/'),
            'create' => Pages\CreateAboutUsSection::route('/create'),
            'edit' => Pages\EditAboutUsSection::route('/{record}/edit'),
        ];
    }
}
