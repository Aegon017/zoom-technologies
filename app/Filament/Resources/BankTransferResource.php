<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankTransferResource\Pages;
use App\Models\BankTransfer;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BankTransferResource extends Resource
{
    protected static ?string $model = BankTransfer::class;

    protected static ?string $navigationGroup = 'Payment Settings';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('bank_name')->required(),
                TextInput::make('ifsc_code')->label('IFSC code')->required(),
                TextInput::make('account_name')->required(),
                TextInput::make('account_number')->required(),
                TextInput::make('branch_name')->required(),
                TextInput::make('branch_code')->required(),
                Textarea::make('address')->columnSpanFull()->required(),
                Repeater::make('notes')
                    ->schema([
                        Textarea::make('content'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bank_name'),
                TextColumn::make('ifsc_code')->label('IFSC code'),
                TextColumn::make('account_name'),
                TextColumn::make('account_number'),
                TextColumn::make('branch_name'),
                TextColumn::make('branch_code'),
                TextColumn::make('address'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([]),
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
            'index' => Pages\ListBankTransfers::route('/'),
            'create' => Pages\CreateBankTransfer::route('/create'),
            'edit' => Pages\EditBankTransfer::route('/{record}/edit'),
        ];
    }
}
