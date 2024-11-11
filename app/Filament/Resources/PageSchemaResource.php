<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageSchemaResource\Pages;
use App\Filament\Resources\PageSchemaResource\RelationManagers;
use App\Models\Course;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Package;
use App\Models\PageSchema;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageSchemaResource extends Resource
{
    protected static ?string $model = PageSchema::class;
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('page_name')->options(
                    array_merge(
                        Course::pluck('name', 'name')->toArray(),
                        Package::pluck('name', 'name')->toArray(),
                        NewsCategory::pluck('name', 'name')->toArray(),
                        News::pluck('name', 'name')->toArray(),
                        [
                            'Home' => 'Home',
                            'News list' => 'News list',
                            'Course list' => 'Course list',
                            'Upcoming schedule' => 'Upcoming schedule',
                            'Contact' => 'Contact',
                            'Franchisee' => 'Franchisee',
                            'Memorable moments' => 'Memorable moments',
                            'Testimonials' => 'Testimonials',
                            'Study material' => 'Study material',
                        ]
                    )
                )->searchable()->required()->columnSpanFull(),
                Textarea::make('local_schema')->rows(10)->columnSpanFull(),
                Textarea::make('organization_schema')->rows(10)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('page_name')->searchable(),
                TextColumn::make('local_schema')->html()->wrap()->lineClamp(3),
                TextColumn::make('organization_schema')->html()->wrap()->lineClamp(3),
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
            'index' => Pages\ListPageSchemas::route('/'),
            'create' => Pages\CreatePageSchema::route('/create'),
            'edit' => Pages\EditPageSchema::route('/{record}/edit'),
        ];
    }
}
