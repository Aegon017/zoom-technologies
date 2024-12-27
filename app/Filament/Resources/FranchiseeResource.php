<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FranchiseeResource\Pages;
use App\Filament\Resources\FranchiseeResource\RelationManagers;
use App\Models\Franchisee;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FranchiseeResource extends Resource
{
    protected static ?string $model = Franchisee::class;
    protected static ?string $navigationGroup = 'Pages';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('page_content')
                    ->schema([
                        TextInput::make('heading')
                            ->label('Heading')
                            ->placeholder('Enter a heading')
                            ->required(),
                        RichEditor::make('content')
                            ->label('Content')
                            ->placeholder('Enter content')
                            ->required(),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Title')->default('Franchisee Page'),
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
            'index' => Pages\ListFranchisees::route('/'),
            'create' => Pages\CreateFranchisee::route('/create'),
            'edit' => Pages\EditFranchisee::route('/{record}/edit'),
        ];
    }
}
