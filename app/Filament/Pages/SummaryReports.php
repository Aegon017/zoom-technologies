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
        $this->orders = Order::with('course', 'schedule')->get();
        $this->groupedOrders = $this->processOrders($this->orders);
        $this->records = $this->groupedOrders;
        $this->isLoaded = true;
    }

    protected function processOrders($orders)
    {
        $grouped = $orders->groupBy(function ($order) {
            return $order->course->name;
        });

        $result = [];
        foreach ($grouped as $courseName => $courseOrders) {
            $totalPayment = $courseOrders->sum(function ($order) {
                return $order->payment ? $order->payment->amount : 0;
            });

            $batches = [];

            foreach ($courseOrders as $order) {
                foreach ($order->schedule as $schedule) {
                    $dateKey = $schedule->start_date;
                    if (!isset($batches[$dateKey])) {
                        $batches[$dateKey] = [
                            'times' => [],
                            'payment_count' => 0,
                        ];
                    }
                    $batches[$dateKey]['times'][] = $schedule->start_time;
                    $batches[$dateKey]['payment_count']++;
                }
            }
            $batchDetails = [];
            foreach ($batches as $date => $data) {
                $uniqueTimes = array_unique($data['times']);
                $timeCount = count($uniqueTimes);
                $paymentCount = $data['payment_count'];
                $timeString = implode(', ', $uniqueTimes);

                $batchDetails[] = "$date ($paymentCount payment" . ($paymentCount > 1 ? 's' : '') . ": $timeCount time" . ($timeCount > 1 ? 's' : '') . ": $timeString)";
            }

            $result[] = [
                'course_name' => $courseName,
                'total_payment' => $totalPayment,
                'number_of_batches' => count($batches),
                'batch_dates_and_times' => implode('; ', $batchDetails),
            ];
        }

        return $result;
    }
}
