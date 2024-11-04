<?php

namespace App\Filament\Resources;

use App\Filament\Exports\OrderExporter;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?int $navigationSort = 2;
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Fieldset::make('User Details')->schema([
                    TextEntry::make('user.name'),
                    TextEntry::make('user.email')->label('Email'),
                    TextEntry::make('user.phone')->label('Phone'),
                ]),
                Fieldset::make('Course Details')->schema([
                    TextEntry::make('course_name'),
                    TextEntry::make('course_price')->prefix('Rs. ')->suffix('/-'),
                ]),
                Fieldset::make('Payment Details')->schema([
                    TextEntry::make('order_number'),
                    TextEntry::make('transaction_id'),
                    TextEntry::make('payu_id'),
                    TextEntry::make('sgst')->label('S.GST')->prefix('Rs. ')->suffix('/-'),
                    TextEntry::make('cgst')->label('C.GST')->prefix('Rs. ')->suffix('/-'),
                    TextEntry::make('amount')->label('Order Amount')->prefix('Rs. ')->suffix('/-'),
                    TextEntry::make('status'),
                    TextEntry::make('payment_desc'),
                    TextEntry::make('payment_mode')->default('-'),
                ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()->exporter(OrderExporter::class)
            ])
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('order_number')->searchable(),
                TextColumn::make('user.name')->searchable(),
                TextColumn::make('course_name'),
                TextColumn::make('amount')->label('Order Amount')->prefix('Rs. ')->suffix('/-'),
                TextColumn::make('status')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                ExportAction::make()->exporter(OrderExporter::class)
            ])
            ->bulkActions([
                ExportBulkAction::make(OrderExporter::class)
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
            'index' => Pages\ListOrders::route('/'),
        ];
    }
}
