<?php

namespace App\Filament\Resources;

use App\Actions\SendCertificate;
use App\Filament\Exports\OrderExporter;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers\OrderScheduleRelationManager;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Order;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $label = 'Enrolled Student';

    protected static ?string $navigationLabel = 'Enrolled Students';

    public static ?string $slug = 'enrolled-students';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Students';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                return $query->whereHas('payment', function ($subQuery) {
                    $subQuery->where('status', 'success');
                });
            })
            ->headerActions([
                ExportAction::make()->exporter(OrderExporter::class),
            ])
            ->columns([
                TextColumn::make('user.name')->label('Username')->searchable(),
                TextColumn::make('user.email')->label('User Email')->searchable(),
                TextColumn::make('combined')
                    ->label('Course and Package Name')
                    ->getStateUsing(function ($record) {
                        $course = $record->course->name ?? $record->package->name;

                        return $course;
                    }),
            ])
            ->filters([
                Filter::make('course')
                    ->form([
                        Group::make()->schema([
                            Select::make('course_id')
                                ->label('Single Course')
                                ->options(Course::whereHas('order')->pluck('name', 'id'))
                                ->live()
                                ->searchable()
                                ->preload(),
                            Select::make('training_mode')
                                ->label('Training mode')
                                ->options(function (Get $get) {
                                    $courseId = $get('course_id');
                                    if (! $courseId) {
                                        return [];
                                    }

                                    return Schedule::whereHas('orderSchedule')
                                        ->where('course_id', $courseId)
                                        ->distinct()
                                        ->get()
                                        ->pluck('training_mode', 'training_mode')
                                        ->toArray();
                                })
                                ->searchable()
                                ->preload()
                                ->disabled(fn(Get $get) => ! $get('course_id')),
                            Select::make('schedule_id')
                                ->label('Batch')
                                ->options(function (Get $get) {
                                    $courseId = $get('course_id');
                                    $trainingMode = $get('training_mode');
                                    if (! $courseId || ! $trainingMode) {
                                        return [];
                                    }

                                    return Schedule::whereHas('orderSchedule')
                                        ->where('course_id', $courseId)
                                        ->where('training_mode', $trainingMode)
                                        ->distinct()
                                        ->get()
                                        ->mapWithKeys(function ($schedule) {
                                            return [$schedule->id => $schedule->formatted_schedule];
                                        })
                                        ->toArray();
                                })->columnSpanFull()
                                ->searchable()
                                ->preload()
                                ->disabled(fn(Get $get) => ! $get('training_mode')),
                        ])->columns(2),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['course_id'] ?? null,
                                fn(Builder $query, $courseId) => $query
                                    ->where(function (Builder $subQuery) use ($courseId) {
                                        $subQuery->whereHas('course', fn(Builder $courseQuery) => $courseQuery->where('id', $courseId))
                                            ->orWhereHas('package', fn(Builder $packageQuery) => $packageQuery->whereJsonContains('courses', (string) $courseId));
                                    })
                            )
                            ->when(
                                $data['training_mode'],
                                fn(Builder $query, $trainingMode) => $query->whereHas(
                                    'schedule',
                                    fn(Builder $scheduleQuery) => $scheduleQuery->where('training_mode', $trainingMode)
                                )
                            )
                            ->when(
                                $data['schedule_id'],
                                fn(Builder $query, $scheduleId): Builder => $query->whereHas('schedule', fn(Builder $query) => $query->where('schedule_id', $scheduleId)),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['course_id'] ?? null) {
                            $indicators[] = Indicator::make('Course: ' . Course::where('id', $data['course_id'])->first()->name)
                                ->removeField('course_id');
                        }

                        if ($data['training_mode'] ?? null) {
                            $indicators[] = Indicator::make('Training Mode: ' . $data['training_mode'])
                                ->removeField('training_mode');
                        }

                        if ($data['schedule_id'] ?? null) {
                            $indicators[] = Indicator::make('Batch: ' . Schedule::where('id', $data['schedule_id'])->first()->formatted_schedule)
                                ->removeField('schedule_id');
                        }

                        return $indicators;
                    })->columnSpan(3),
                Filter::make('order_date_range')
                    ->label('Order Date Range')
                    ->form([
                        Group::make()->schema([
                            DatePicker::make('start_date')->maxDate(today())->label('Start Date')->required(),
                            DatePicker::make('end_date')->label('End Date')->default(today())->required(),
                        ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['start_date'] && $data['end_date'],
                            fn(Builder $query): Builder => $query->whereHas(
                                'payment',
                                fn(Builder $query): Builder => $query->whereBetween(
                                    'payments.date',
                                    [$data['start_date'], $data['end_date']]
                                )
                            )
                        );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['start_date'] && $data['end_date']) {
                            $indicators[] = Indicator::make('From: ' . $data['start_date'] . ' To: ' . $data['end_date'])
                                ->removeField('start_date')
                                ->removeField('end_date');
                        }

                        return $indicators;
                    }),
                Filter::make('package')
                    ->form([
                        Group::make()->schema([
                            Select::make('package_id')
                                ->label('Package Course')
                                ->options(Package::whereHas('order')->pluck('name', 'id'))
                                ->live()
                                ->searchable()
                                ->preload()
                                ->columnSpanFull(),
                        ])->columns(2),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['package_id'] ?? null,
                                fn(Builder $query, $courseId) => $query
                                    ->where(function (Builder $subQuery) use ($courseId) {
                                        $subQuery->whereHas('package', fn(Builder $courseQuery) => $courseQuery->where('id', $courseId));
                                    })
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['package_id'] ?? null) {
                            $indicators[] = Indicator::make('Package Course: ' . Package::where('id', $data['package_id'])->first()->name)
                                ->removeField('package_id');
                        }

                        if ($data['training_mode'] ?? null) {
                            $indicators[] = Indicator::make('Training Mode: ' . $data['training_mode'])
                                ->removeField('training_mode');
                        }

                        if ($data['schedule_id'] ?? null) {
                            $indicators[] = Indicator::make('Batch: ' . Schedule::where('id', $data['schedule_id'])->first()->formatted_schedule)
                                ->removeField('schedule_id');
                        }

                        return $indicators;
                    })->columnSpan(3),
                Filter::make('method')
                    ->form([
                        Select::make('payment_method')
                            ->label('Payment Mode')
                            ->searchable()
                            ->options(Payment::pluck('method', 'method')->unique()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['payment_method'],
                            fn(Builder $query): Builder => $query->whereHas(
                                'payment',
                                fn(Builder $query): Builder => $query->where(
                                    'payments.method',
                                    $data['payment_method']
                                )
                            )
                        );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['payment_method']) {
                            $indicators[] = Indicator::make('Payment Mode: ' . $data['payment_method'])
                                ->removeField('payment_method');
                        }

                        return $indicators;
                    }),
            ], layout: FiltersLayout::AboveContentCollapsible)->filtersFormColumns('4')
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('send_certificate')
                    ->icon('heroicon-o-check-badge')
                    ->label('Send Certificate')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $certificates = $record->user->certificates()->whereIn('schedule_id', $record->schedule->pluck('id'))->get();
                        foreach ($certificates as $certificate) {
                            if (file_exists($certificate->certificate_path)) {
                                unlink($certificate->certificate_path);
                            }
                            $certificate->delete();
                        }
                        $orderSchedules = $record->orderSchedule;
                        (new SendCertificate())->execute($orderSchedules);
                    })
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            OrderScheduleRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
