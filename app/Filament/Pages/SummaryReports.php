<?php

namespace App\Filament\Pages;

use App\Models\Order;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;

class SummaryReports extends Page
{
    use HasPageShield;

    public $orders;
    public $groupedOrders;
    public $records;
    public $isLoaded = false;
    public $actionsPosition = 'before';
    public $pollingInterval = 100000;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.summary-reports';

    public function mount()
    {
        $this->loadOrders();
        $this->isLoaded = true;
    }

    protected function loadOrders()
    {
        $this->orders = Order::with('course', 'schedule', 'payment')->get();
        $this->groupedOrders = $this->processOrders($this->orders);
        $this->records = $this->groupedOrders;
    }

    protected function processOrders($orders)
    {
        return $orders->groupBy(fn($order) => $order->course->name)
            ->map(fn($courseOrders, $courseName) => $this->getCourseSummary($courseOrders, $courseName))
            ->values()
            ->toArray();
    }

    protected function getCourseSummary($courseOrders, $courseName)
    {
        $paymentsByCurrency = [];
        $batches = $this->getBatches($courseOrders);

        foreach ($courseOrders as $order) {
            $amount = $order->payment->amount ?? 0;
            $currency = $order->payment->currency ?? 'USD'; // Default to USD if no currency is set

            if (!isset($paymentsByCurrency[$currency])) {
                $paymentsByCurrency[$currency] = 0;
            }
            $paymentsByCurrency[$currency] += $amount;
        }

        return [
            'course_name' => $courseName,
            'payments_by_currency' => $paymentsByCurrency,
            'number_of_batches' => count($batches),
            'batch_dates_and_times' => $this->formatBatchDetails($batches),
        ];
    }

    protected function getBatches($courseOrders)
    {
        $batches = [];

        foreach ($courseOrders as $order) {
            foreach ($order->schedule as $schedule) {
                $dateKey = $schedule->start_date;
                $batches[$dateKey]['times'][] = $schedule->start_time;
                $batches[$dateKey]['payment_count'] = ($batches[$dateKey]['payment_count'] ?? 0) + 1;
            }
        }

        return $batches;
    }

    protected function formatBatchDetails($batches)
    {
        return collect($batches)->map(function ($data, $date) {
            $uniqueTimes = array_unique($data['times']);
            $timeCount = count($uniqueTimes);
            $paymentCount = $data['payment_count'];
            $timeString = implode(', ', $uniqueTimes);

            return "$date ($paymentCount payment" . ($paymentCount > 1 ? 's' : '') . ": $timeCount time" . ($timeCount > 1 ? 's' : '') . ": $timeString)";
        })->implode('; ');
    }
}
