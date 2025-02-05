<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageSchemaResource\Pages;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Course;
use App\Models\Package;
use App\Models\PageSchema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PageSchemaResource extends Resource
{
    protected static ?string $model = PageSchema::class;

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'SEO Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('page_name')->options(
                    array_merge(
                        [
                            'Home' => 'Home',
                            'Blog list' => 'Blog list',
                            'Course list' => 'Course list',
                            'Upcoming schedule' => 'Upcoming schedule',
                            'Contact' => 'Contact',
                            'Franchisee' => 'Franchisee',
                            'Memorable moments' => 'Memorable moments',
                            'Testimonials' => 'Testimonials',
                            'Study material' => 'Study material',
                        ],
                        Course::pluck('name', 'name')->mapWithKeys(function ($item, $key) {
                            return [$key => 'Course - ' . $item];
                        })->toArray(),
                        Package::pluck('name', 'name')->mapWithKeys(function ($item, $key) {
                            return [$key => 'Package - ' . $item];
                        })->toArray(),
                        Blog::pluck('name', 'name')->mapWithKeys(function ($item, $key) {
                            return [$key => 'Blog - ' . $item];
                        })->toArray(),
                        BlogCategory::pluck('name', 'name')->mapWithKeys(function ($item, $key) {
                            return [$key => 'Blog category - ' . $item];
                        })->toArray()
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
            'index' => Pages\ListPageSchemas::route('/'),
            'create' => Pages\CreatePageSchema::route('/create'),
            'edit' => Pages\EditPageSchema::route('/{record}/edit'),
        ];
    }
}
