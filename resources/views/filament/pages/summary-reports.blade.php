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
                    @if ($records !== null && count($records))
                        <x-filament-tables::table>
                            <x-slot name="header">
                                <x-filament-tables::header-cell>Course Name</x-filament-tables::header-cell>
                                <x-filament-tables::header-cell>Batch Dates and Times</x-filament-tables::header-cell>
                                <x-filament-tables::header-cell>Total Payment Amount</x-filament-tables::header-cell>
                            </x-slot>

                            @foreach ($groupedOrders as $order)
                                <x-filament-tables::row>
                                    <x-filament-tables::cell>{{ $order['course_name'] }}</x-filament-tables::cell>
                                    <x-filament-tables::cell>{{ $order['batch_dates_and_times'] }}</x-filament-tables::cell>
                                    <x-filament-tables::cell
                                        class="text-center">{{ number_format($order['total_payment'], 2) }}</x-filament-tables::cell>
                                </x-filament-tables::row>
                            @endforeach
                        </x-filament-tables::table>
                    @else
                        <x-filament-tables::empty-state :heading="'No Records Found'" :description="'There are no summary reports available.'" />
                    @endif
                </div>
            </x-filament-tables::container>
        </div>
    </x-filament::card>
</x-filament-panels::page>
