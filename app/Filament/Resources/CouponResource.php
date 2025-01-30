<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use MichaelRubel\Couponables\Models\Contracts\CouponContract;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Code')
                    ->required()
                    ->unique('coupons', 'code', ignoreRecord: true)
                    ->default(
                        fn () => Str::upper(Str::random(10))
                    ),

                Select::make('type')
                    ->label('Type')
                    ->options([
                        CouponContract::TYPE_PERCENTAGE => CouponContract::TYPE_PERCENTAGE,
                        CouponContract::TYPE_SUBTRACTION => CouponContract::TYPE_SUBTRACTION,
                    ])
                    ->required(),

                TextInput::make('value')
                    ->label('Value')
                    ->required(),

                TextInput::make('quantity')
                    ->label('Quantity')
                    ->required(),
                DateTimePicker::make('expires_at')
                    ->label('Expires At'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code'),
                TextColumn::make('type'),
                TextColumn::make('value'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
