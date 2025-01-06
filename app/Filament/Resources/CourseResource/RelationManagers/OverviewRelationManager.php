<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
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
                        Radio::make('uscouncil_certified')->label('U.S. Council Certified')->boolean()->inline()->reactive()
                            ->inlineLabel(false)->required(),
                        TextInput::make('note')->label('Note')->hidden(fn(Get $get): bool => ! $get('uscouncil_certified')),
                        TextInput::make('voucher_value')->prefix('$')->hidden(fn(Get $get): bool => ! $get('uscouncil_certified')),
                    ]),
                ]),
            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('content')->html()->wrap()->lineClamp(3),
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
