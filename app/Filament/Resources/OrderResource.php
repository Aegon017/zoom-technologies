<?php

namespace App\Filament\Resources;

use App\Filament\Exports\OrderExporter;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Order;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Schedule;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use ZipArchive;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
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
                    TextEntry::make('combined')
                        ->label(function ($record) {
                            return $record->course ? 'Course Name' : 'Package Course Name';
                        })
                        ->getStateUsing(function ($record) {
                            return $record->course->name ?? $record->package->name ?? 'No Name Available';
                        }),
                    TextEntry::make('courseOrPackage_price')
                        ->label(function ($record) {
                            return $record->course ? 'Course Price' : 'Package Course Price';
                        })
                        ->formatStateUsing(fn($state, $record) => $record->payment->currency . ' ' . $state),
                ]),
                Fieldset::make('Batches')->schema([
                    TextEntry::make('orderSchedule')
                        ->label('')
                        ->listWithLineBreaks()
                        ->getStateUsing(
                            fn($record) => $record->orderSchedule->isEmpty()
                                ? ['🚫 No Schedules Available']
                                : $record->orderSchedule
                                ->map(function ($os) {
                                    $s = $os->schedule;

                                    return $s ? [
                                        '📚 Course: ' . ($s->course?->name ?? 'N/A'),
                                        '📅 Date: ' . (
                                            $s->start_date
                                            ? \Carbon\Carbon::parse($s->start_date)->format('d M Y')
                                            : 'Unscheduled'
                                        ),
                                        '⏰ Time: ' . (
                                            $s->time
                                            ? \Carbon\Carbon::parse($s->time)->format('h:i A')
                                            : 'TBD'
                                        ),
                                        '🌐 Mode: ' . ($s->training_mode ?? 'Unspecified'),
                                    ] : ['⚠️ Invalid Schedule'];
                                })
                                ->flatten()
                                ->filter()
                                ->toArray()
                        )
                        ->placeholder('No schedule information'),
                ]),
                Fieldset::make('Payment Details')->schema([
                    TextEntry::make('order_number'),
                    TextEntry::make('payment.payment_id')->label('Payment ID'),
                    TextEntry::make('payment.method')->label('Mode'),
                    TextEntry::make('payment.mode')->label('Method')->default('N/A'),
                    TextEntry::make('enrolled_by'),
                    TextEntry::make('payment.date')->label('Date')->date(),
                    TextEntry::make('payment.time')->label('Time')->time('h:i A'),
                    TextEntry::make('payment.description')->label('Description'),
                    TextEntry::make('cgst')
                        ->formatStateUsing(fn($state, $record) => $record->payment->currency . ' ' . $state)
                        ->label('CGST'),
                    TextEntry::make('sgst')
                        ->formatStateUsing(fn($state, $record) => $record->payment->currency . ' ' . $state)
                        ->label('SGST'),
                    TextEntry::make('payment.amount')
                        ->formatStateUsing(fn($state, $record) => $record->payment->currency . ' ' . $state)
                        ->label('Order Amount'),
                    TextEntry::make('payment.status'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')->rowIndex(),
                TextColumn::make('order_number')->searchable(),
                TextColumn::make('enrolled_by')->searchable(),
                TextColumn::make('user.name')->searchable(),
                TextColumn::make('combined')
                    ->label('Course and Package Name')
                    ->getStateUsing(function ($record) {
                        $course = $record->course->name ?? $record->package->name;

                        return $course;
                    }),
                TextColumn::make('payment.amount')
                    ->label('Order Amount')
                    ->formatStateUsing(fn($state, $record) => $record->payment->currency . ' ' . $state),
                TextColumn::make('payment.date')->label('Payment date'),
                TextColumn::make('payment.time')->label('Payment time'),
                TextColumn::make('payment.status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'success' => 'success',
                        'failure' => 'danger',
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
                                fn(Builder $query, $courseId) => $query->whereHas('course', fn(Builder $courseQuery) => $courseQuery->where('id', $courseId))
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
                Filter::make('mode')
                    ->form([
                        Select::make('payment_mode')
                            ->columnSpan(2)
                            ->label('Payment Method')
                            ->searchable()
                            ->options(Payment::pluck('mode', 'mode')->filter()->unique()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['payment_mode'],
                            fn(Builder $query): Builder => $query->whereHas(
                                'payment',
                                fn(Builder $query): Builder => $query->where(
                                    'payments.mode',
                                    $data['payment_mode']
                                )
                            )
                        );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['payment_mode']) {
                            $indicators[] = Indicator::make('Payment Method: ' . $data['payment_mode'])
                                ->removeField('payment_mode');
                        }

                        return $indicators;
                    }),
                SelectFilter::make('enrolled_by')
                    ->options(Order::pluck('enrolled_by', 'enrolled_by'))
                    ->searchable()
                    ->columnSpan(2),
                Filter::make('promocode')
                    ->form([
                        Select::make('coupon_id')
                            ->label('Promo code')
                            ->options(Coupon::whereIn('id', Payment::pluck('coupon_id'))->pluck('code', 'id'))
                            ->searchable()
                            ->preload(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['coupon_id'] ?? null,
                                fn(Builder $query, $couponId) => $query
                                    ->whereHas('payment', fn(Builder $subQuery) => $subQuery->where('coupon_id', $couponId))
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['coupon_id'] ?? null) {
                            $coupon = Coupon::find($data['coupon_id']);
                            if ($coupon) {
                                $indicators[] = Indicator::make('Promo Code: ' . $coupon->code)
                                    ->removeField('coupon_id');
                            }
                        }
                        return $indicators;
                    })


            ], layout: FiltersLayout::AboveContentCollapsible)->filtersFormColumns('4')
            ->actions([
                ActionsAction::make('invoice')
                    ->label('Download Invoice')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        return response()->download(public_path($record->invoice));
                    })
                    ->visible(fn($record) => ! is_null($record->invoice)),
                ViewAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('invoice')
                    ->label('Download Invoices')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($records) {
                        $zip = new ZipArchive;
                        $zipFileName = storage_path('app/public/invoices.zip');
                        if (file_exists($zipFileName)) {
                            unlink($zipFileName);
                        }
                        if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
                            foreach ($records as $record) {
                                $filePath = public_path($record->invoice);
                                if (file_exists($filePath) && is_file($filePath)) {
                                    $zip->addFile($filePath, basename($filePath));
                                }
                            }
                            $zip->close();

                            return response()->download($zipFileName)->deleteFileAfterSend(true);
                        } else {
                            return back()->with('error', 'Unable to create the ZIP file.');
                        }
                    }),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(OrderExporter::class),
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
            'index' => Pages\ListOrders::route('/'),
        ];
    }
}
