<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialSectionResource\Pages;
use App\Filament\Resources\TestimonialSectionResource\RelationManagers;
use App\Filament\Resources\TestimonialSectionResource\RelationManagers\TestimonialRelationManager;
use App\Models\TestimonialSection;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonialSectionResource extends Resource
{
    protected static ?string $model = TestimonialSection::class;
    protected static ?string $navigationGroup = 'Home page';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),
                TextInput::make('heading')
                    ->required(),
                FileUpload::make('image')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->height(120)->width(300),
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
            TestimonialRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonialSections::route('/'),
            'create' => Pages\CreateTestimonialSection::route('/create'),
            'edit' => Pages\EditTestimonialSection::route('/{record}/edit'),
        ];
    }
}
