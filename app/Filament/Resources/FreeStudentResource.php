<?php

namespace App\Filament\Resources;

use App\Filament\Exports\UserExporter;
use App\Filament\Resources\FreeStudentResource\Pages;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FreeStudentResource extends Resource
{
    public static function canCreate(): bool
    {
        return false;
    }

    protected static ?string $model = User::class;

    protected static ?string $label = 'Unenrolled Student';

    protected static ?string $navigationLabel = 'Unenrolled Students';

    public static ?string $slug = 'unenrolled-students';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Students';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->where(function (Builder $query) {
                $query->whereDoesntHave('orders')
                    ->orWhere(function (Builder $subQuery) {
                        $subQuery->whereHas('orders.payment', function (Builder $paymentQuery) {
                            $paymentQuery->where('status', 'failure');
                        })->whereDoesntHave('orders.payment', function (Builder $paymentQuery) {
                            $paymentQuery->where('status', 'success');
                        });
                    });
            })->whereHas('roles', function (Builder $roleQuery) {
                $roleQuery->where('name', 'student');
            }))
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone')->searchable(),
            ])
            ->filters([
                Filter::make('registered_date_range')
                    ->label('Registered Date Range')
                    ->form([
                        Group::make()->schema([
                            DatePicker::make('start_date')
                                ->maxDate(today())
                                ->label('Start Date')
                                ->required(),
                            DatePicker::make('end_date')
                                ->label('End Date')
                                ->default(today())
                                ->required(),
                        ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (!empty($data['start_date']) && !empty($data['end_date'])) {
                            return $query->whereBetween('created_at', [$data['start_date'], $data['end_date']]);
                        }
                        return $query;
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if (!empty($data['start_date']) && !empty($data['end_date'])) {
                            $indicators[] = Indicator::make('From: ' . $data['start_date'] . ' To: ' . $data['end_date'])
                                ->removeField('start_date')
                                ->removeField('end_date');
                        }
                        return $indicators;
                    })
            ])
            ->actions([])
            ->bulkActions([
                BulkActionGroup::make([]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(UserExporter::class),
            ])->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListFreeStudents::route('/'),
        ];
    }
}
