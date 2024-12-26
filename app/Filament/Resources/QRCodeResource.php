<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QRCodeResource\Pages;
use App\Models\QRCode;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class QRCodeResource extends Resource
{
    protected static ?string $model = QRCode::class;

    protected static ?string $navigationGroup = 'Payment Settings';

    protected static ?string $navigationLabel = 'QR Codes';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')->disk('public')->directory('qr-codes')->preserveFilenames()->columnSpanFull()->image()->rules(['required', 'image']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('QR Code')->extraImgAttributes(['style' => 'max-width: 100%; height: auto;']),
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
            'index' => Pages\ListQRCodes::route('/'),
            'create' => Pages\CreateQRCode::route('/create'),
            'edit' => Pages\EditQRCode::route('/{record}/edit'),
        ];
    }
}
