<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\NewsCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;
    protected static ?string $navigationGroup = 'Blogs';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('blog_category_id')
                    ->label('Blog category')
                    ->options(BlogCategory::pluck('name', 'id'))->required(),
                TextInput::make('name')->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))->required(),
                TextInput::make('slug')->required(),
                TextInput::make('source')->required(),
                TextInput::make('source_url')->columnSpanFull(),
                Section::make([
                    Group::make()->schema([
                        FileUpload::make('thumbnail')->disk('public')->directory('thumbnails/blogs')->preserveFilenames()->required(),
                        TextInput::make('thumbnail_alt')->required(),
                    ]),
                    Group::make()->schema([
                        FileUpload::make('image')->disk('public')->directory('images/blogs')->preserveFilenames()->required(),
                        TextInput::make('image_alt')->required(),
                    ]),
                ])->columns(2),
                RichEditor::make('content')->columnSpanFull()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')->rowIndex(),
                ImageColumn::make('thumbnail')->height(91),
                TextColumn::make('name')->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
