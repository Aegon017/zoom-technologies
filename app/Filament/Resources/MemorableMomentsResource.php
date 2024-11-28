<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemorableMomentsResource\Pages;
use App\Models\MemorableMoments;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MemorableMomentsResource extends Resource
{
    protected static ?string $model = MemorableMoments::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static ?string $navigationGroup = 'Pages';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')->disk('public')->directory('memorable_moments')->columnSpanFull()->required(),
                Textarea::make('image_alt')->required(),
                Textarea::make('content')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')->rowIndex(),
                ImageColumn::make('image'),
                TextColumn::make('content')->wrap()
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMemorableMoments::route('/'),
            'create' => Pages\CreateMemorableMoments::route('/create'),
            'edit' => Pages\EditMemorableMoments::route('/{record}/edit'),
        ];
    }
}
