<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageMetaDetailsResource\Pages;
use App\Models\PageMetaDetails;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageMetaDetailsResource extends Resource
{
    protected static ?string $model = PageMetaDetails::class;

    protected static ?string $navigationGroup = 'SEO Settings';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('page_name')->options([
                    'Home' => 'Home',
                    'Blog list' => 'Blog list',
                    'Course list' => 'Course list',
                    'Upcoming schedule' => 'Upcoming schedule',
                    'Contact' => 'Contact',
                    'Franchisee' => 'Franchisee',
                    'Memorable moments' => 'Memorable moments',
                    'Testimonials' => 'Testimonials',
                    'Study material' => 'Study material',
                ])->required(),
                TextInput::make('title')->required(),
                Textarea::make('keywords')->rows(7)->required(),
                Textarea::make('description')->rows(7)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page_name')->searchable(),
                TextColumn::make('title')->wrap()->lineClamp(4),
                TextColumn::make('keywords')->wrap()->lineClamp(4),
                TextColumn::make('description')->wrap()->lineClamp(4),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListPageMetaDetails::route('/'),
            'create' => Pages\CreatePageMetaDetails::route('/create'),
            'edit' => Pages\EditPageMetaDetails::route('/{record}/edit'),
        ];
    }
}
