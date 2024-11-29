<?php

namespace App\Filament\Resources\PackageResource\RelationManagers;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OverviewRelationManager extends RelationManager
{
    protected static string $relationship = 'overview';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Overview')->schema([
                    RichEditor::make('content')->columnSpanFull()->label('')->required(),
                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make('U.S. Council')->schema([
                        Radio::make('uscouncil_certified')->label('U.S. Council Certified')->boolean()->inline()
                            ->inlineLabel(false)->required(),
                    ]),
                ]),
            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('content')
            ->columns([
                TextColumn::make('title')->wrap(),
                TextColumn::make('keywords')->wrap(),
                TextColumn::make('description')->wrap(),
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
