<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FooterSectionResource\Pages;
use App\Filament\Resources\FooterSectionResource\RelationManagers;
use App\Filament\Resources\FooterSectionResource\RelationManagers\FooterOfficeRelationManager;
use App\Models\FooterSection;
use App\Models\SocialLink;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FooterSectionResource extends Resource
{
    protected static ?string $model = FooterSection::class;
    protected static ?string $navigationGroup = 'Home page';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('logo')->columnSpanFull()->required(),
                TextInput::make('logo_alt')->required(),
                Textarea::make('content')->required(),
                Select::make('social_links')->options(SocialLink::pluck('name', 'id'))->multiple()->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo'),
                TextColumn::make('content')->wrap(),
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
            FooterOfficeRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFooterSections::route('/'),
            'create' => Pages\CreateFooterSection::route('/create'),
            'edit' => Pages\EditFooterSection::route('/{record}/edit'),
        ];
    }
}
