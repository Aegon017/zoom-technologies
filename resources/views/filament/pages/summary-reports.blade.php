<x-filament-panels::page>
    <x-filament::card>
        <div x-data="{ selectedRecords: [] }" @if (!$isLoaded) wire:init="loadTable" @endif
            @class(['fi-ta', 'animate-pulse' => !$isLoaded])>
            <x-filament-tables::container>
                <div x-show="selectedRecords.length"
                    class="fi-ta-header-ctn divide-y divide-gray-200 dark:divide-white/10">
                    <x-filament-tables::header :heading="'Summary Reports'" :actions-position="$actionsPosition" :description="'Overview of payments and batches.'" />
                </div>

                <div wire:poll.{{ $pollingInterval }} @class([
                    'fi-ta-content relative divide-y divide-gray-200 overflow-x-auto dark:divide-white/10',
                ])>
                    @if ($records && count($records))
                        <x-filament-tables::table>
                            <x-slot name="header">
                                <x-filament-tables::header-cell>Course Name</x-filament-tables::header-cell>
                                <x-filament-tables::header-cell>Batch Dates and Times</x-filament-tables::header-cell>
                                @php
                                    // Collect unique currencies
                                    $uniqueCurrencies = [];
                                    foreach ($groupedOrders as $order) {
                                        foreach ($order['payments_by_currency'] as $currency => $amount) {
                                            if (!in_array($currency, $uniqueCurrencies)) {
                                                $uniqueCurrencies[] = $currency;
                                            }
                                        }
                                    }
                                @endphp
                                @foreach ($uniqueCurrencies as $currency)
                                    <x-filament-tables::header-cell>{{ $currency }}</x-filament-tables::header-cell>
                                @endforeach
                            </x-slot>

                            @foreach ($groupedOrders as $order)
                                <x-filament-tables::row>
                                    <x-filament-tables::cell>{{ $order['course_name'] }}</x-filament-tables::cell>
                                    <x-filament-tables::cell>{{ $order['batch_dates_and_times'] }}</x-filament-tables::cell>
                                    @foreach ($uniqueCurrencies as $currency)
                                        <x-filament-tables::cell class="text-center">
                                            {{ number_format($order['payments_by_currency'][$currency] ?? 0, 2) }}
                                        </x-filament-tables::cell>
                                    @endforeach
                                </x-filament-tables::row>
                            @endforeach

                            <x-filament-tables::row>
                                <x-filament-tables::cell colspan="2" class="text-right font-bold">Grand
                                    Total:</x-filament-tables::cell>
                                @php
                                    $grandTotals = [];
                                    foreach ($groupedOrders as $order) {
                                        foreach ($order['payments_by_currency'] as $currency => $amount) {
                                            if (!isset($grandTotals[$currency])) {
                                                $grandTotals[$currency] = 0;
                                            }
                                            $grandTotals[$currency] += $amount;
                                        }
                                    }
                                @endphp
                                @foreach ($uniqueCurrencies as $currency)
                                    <x-filament-tables::cell class="text-center font-bold">
                                        {{ number_format($grandTotals[$currency] ?? 0, 2) }}
                                    </x-filament-tables::cell>
                                @endforeach
                            </x-filament-tables::row>
                        </x-filament-tables::table>
                    @else
                        <x-filament-tables::empty-state :heading="'No Records Found'" :description="'There are no summary reports available.'" class="text-center" />
                    @endif
                </div>
            </x-filament-tables::container>
        </div>
    </x-filament::card>
</x-filament-panels::page>
