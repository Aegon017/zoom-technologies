<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Schedule;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use NumberFormatter;

class SummaryReports extends Page implements HasForms
{
    use HasPageShield, InteractsWithForms;

    public $orders;
    public $groupedOrders;
    public $records;
    public $trainingMode;
    public $currencies = [];
    public $isLoaded = false;
    public $pollingInterval = 100000;

    // Filter properties
    public $paymentDate;
    public $enrolledBy;
    public $enrolledByOptions = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.summary-reports';

    public function mount()
    {
        $this->enrolledByOptions = Order::whereNotNull('enrolled_by')
            ->pluck('enrolled_by')
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        $this->loadOrders();
        $this->isLoaded = true;
    }

    protected function getFormSchema(): array
    {
        $trainingModes = Schedule::distinct()
            ->whereNotNull('training_mode')
            ->pluck('training_mode')
            ->sort()
            ->values()
            ->toArray();

        return [
            Select::make('paymentDate')
                ->label('Payment Date')
                ->options($this->getPaymentDates())
                ->searchable()
                ->placeholder('Select payment date')
                ->reactive(),

            Select::make('enrolledBy')
                ->label('Enrolled By')
                ->options(array_combine($this->enrolledByOptions, $this->enrolledByOptions))
                ->searchable()
                ->placeholder('Select enrollee')
                ->reactive(),

            Select::make('trainingMode')
                ->label('Training Mode')
                ->options(array_combine($trainingModes, $trainingModes))
                ->searchable()
                ->placeholder('All Training Modes')
                ->reactive(),
        ];
    }

    public function loadOrders()
    {

        $query = Order::with('course', 'schedule', 'payment')
            ->whereHas('payment', function ($q) {
                $q->where('status', 'success');
            })
            ->when($this->paymentDate, function ($q) {
                $q->whereHas('payment', function ($q) {
                    $q->whereDate('date', $this->paymentDate);
                });
            })
            ->when($this->enrolledBy, function ($q) {
                $q->where('enrolled_by', $this->enrolledBy);
            })
            ->when($this->trainingMode, function ($q) {
                $q->whereHas('schedule', function ($q) {
                    $q->where('training_mode', $this->trainingMode);
                });
            });

        $this->orders = $query->get();
        $this->currencies = $this->getUniqueCurrencies();
        $this->groupedOrders = $this->processOrders($this->orders);
        $this->records = $this->groupedOrders;
    }

    protected function getUniqueCurrencies()
    {
        return Order::has('payment')
            ->with('payment')
            ->get()
            ->pluck('payment.currency')
            ->unique()
            ->filter()
            ->sort()
            ->values()
            ->toArray();
    }

    protected function processOrders($orders)
    {
        $summary = [];

        foreach ($orders as $order) {
            if (!$order->payment) continue;

            $courseName = $order->course->name ?? '(blank)';
            $currency = $order->payment->currency ?? 'USD';
            $amount = $order->payment->amount ?? 0;

            // Collect dates/times
            $dates = $order->schedule->pluck('start_date')->unique()->sort()->values();
            $times = $order->schedule->pluck('time')->unique()->sort()->values();

            $dateKey = $dates->join(', ');
            $timeKey = $times->join(', ');

            // Initialize course summary
            if (!isset($summary[$courseName])) {
                $summary[$courseName] = [
                    'count' => 0,
                    'sums' => array_fill_keys($this->currencies, 0),
                    'dates' => [],
                ];
            }

            // Update course totals
            $summary[$courseName]['count']++;
            $summary[$courseName]['sums'][$currency] += $amount;

            // Initialize date entry
            if (!isset($summary[$courseName]['dates'][$dateKey])) {
                $summary[$courseName]['dates'][$dateKey] = [
                    'count' => 0,
                    'sums' => array_fill_keys($this->currencies, 0),
                    'times' => [],
                ];
            }

            // Update date totals
            $summary[$courseName]['dates'][$dateKey]['count']++;
            $summary[$courseName]['dates'][$dateKey]['sums'][$currency] += $amount;

            // Initialize time entry
            if (!isset($summary[$courseName]['dates'][$dateKey]['times'][$timeKey])) {
                $summary[$courseName]['dates'][$dateKey]['times'][$timeKey] = [
                    'count' => 0,
                    'sums' => array_fill_keys($this->currencies, 0),
                ];
            }

            // Update time totals
            $summary[$courseName]['dates'][$dateKey]['times'][$timeKey]['count']++;
            $summary[$courseName]['dates'][$dateKey]['times'][$timeKey]['sums'][$currency] += $amount;
        }

        return $summary;
    }

    public function getGrandTotals()
    {
        $grandTotals = [
            'count' => 0,
            'sums' => array_fill_keys($this->currencies, 0),
        ];

        foreach ($this->groupedOrders as $courseData) {
            $grandTotals['count'] += $courseData['count'];
            foreach ($this->currencies as $currency) {
                $grandTotals['sums'][$currency] += $courseData['sums'][$currency] ?? 0;
            }
        }

        return $grandTotals;
    }

    protected function getPaymentDates()
    {
        return Payment::query()
            ->whereNotNull('date')
            ->select('date')
            ->distinct()
            ->orderBy('date', 'desc')
            ->get()
            ->mapWithKeys(function ($payment) {
                $formattedDate = date('Y-m-d', strtotime($payment->date));
                return [$formattedDate => $formattedDate];
            })
            ->toArray();
    }

    protected function formatCurrency($amount, $currency)
    {
        $currencyMap = [
            'RS' => 'INR',
            'USD' => 'USD',
        ];

        $isoCurrency = $currencyMap[strtoupper($currency)] ?? $currency;

        $formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $isoCurrency);
    }

    public function resetFilters()
    {
        $this->paymentDate = null;
        $this->enrolledBy = null;
        $this->trainingMode = null;
        $this->loadOrders();
    }
}
