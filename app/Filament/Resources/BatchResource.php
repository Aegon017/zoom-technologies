<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BatchResource\Pages;
use App\Filament\Resources\BatchResource\RelationManagers;
use App\Filament\Resources\BatchResource\RelationManagers\OrderScheduleRelationManager;
use App\Models\Batch;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Components\Tab;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BatchResource extends Resource
{
    protected static ?string $model = Schedule::class;
    protected static ?string $label = 'Batches';
    protected static ?string $navigationLabel = 'Batches';
    public static ?string $slug = 'batches';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('start_date')
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('course.name'),
                TextColumn::make('start_date')->searchable()->date(),
                TextColumn::make('time')->time('H i:A'),
                TextColumn::make('end_time')->time('H i:A'),
                TextColumn::make('training_mode')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            OrderScheduleRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBatches::route('/'),
            'create' => Pages\CreateBatch::route('/create'),
            'view' => Pages\ViewStudents::route('/{record}/view'),
        ];
    }
}
