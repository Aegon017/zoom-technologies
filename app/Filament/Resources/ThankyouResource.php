<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ThankyouResource\Pages;
use App\Models\Email;
use App\Models\MobileNumber;
use App\Models\Thankyou;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ThankyouResource extends Resource
{
    protected static ?string $model = Thankyou::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Pages';

    protected static ?string $navigationLabel = 'Thankyou';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->columnSpanFull(),
                RichEditor::make('content')->required()->columnSpanFull(),
                TextInput::make('heading')->required(),
                TextInput::make('sub_heading')->required(),
                Select::make('email')->options(Email::all()->pluck('email', 'id'))->multiple()->required()->searchable(),
                Select::make('mobile')->options(MobileNumber::all()->pluck('number', 'id'))->multiple()->required()->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('content'),
                TextColumn::make('heading'),
                TextColumn::make('sub_heading'),
                TextColumn::make('email')->getStateUsing(fn ($record) => is_array($record->email) ? implode(', ', Email::whereIn('id', $record->email)->pluck('email')->toArray()) : ''),
                TextColumn::make('mobile')->getStateUsing(fn ($record) => is_array($record->mobile) ? implode(', ', MobileNumber::whereIn('id', $record->mobile)->pluck('number')->toArray()) : ''),
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
            'index' => Pages\ListThankyous::route('/'),
            'create' => Pages\CreateThankyou::route('/create'),
            'edit' => Pages\EditThankyou::route('/{record}/edit'),
        ];
    }
}
