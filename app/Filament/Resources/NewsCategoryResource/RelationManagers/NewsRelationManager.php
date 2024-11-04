<?php

namespace App\Filament\Resources\NewsCategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class NewsRelationManager extends RelationManager
{
    protected static string $relationship = 'news';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))->required(),
                TextInput::make('slug')->required(),
                TextInput::make('source')->columnSpanFull()->required(),
                Section::make([
                    Group::make()->schema([
                        FileUpload::make('thumbnail')->disk('public')->directory('thumbnails/news')->preserveFilenames()->required(),
                        TextInput::make('thumbnail_alt')->required(),
                    ]),
                    Group::make()->schema([
                        FileUpload::make('image')->disk('public')->directory('images/news')->preserveFilenames()->required(),
                        TextInput::make('image_alt')->required(),
                    ])
                ])->columns(2),
                RichEditor::make('content')->columnSpanFull()->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('#')->rowIndex(),
                ImageColumn::make('thumbnail')->height(91),
                TextColumn::make('name')->wrap(),
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
