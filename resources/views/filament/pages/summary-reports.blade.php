<x-filament-panels::page>
    <x-filament::card class="!rounded-xl">
        <div x-data="{ selectedRecords: [] }" @if (!$isLoaded) wire:init="loadOrders" @endif
            @class(['fi-ta', 'animate-pulse' => !$isLoaded])>

            <!-- Filter Section with Gradient Background -->
            <div class="p-4 bg-gray-50 rounded-lg mb-4">
                <form wire:submit.prevent="loadOrders" class="flex flex-wrap items-end gap-4">
                    <!-- Payment Date -->
                    <div class="flex-1 min-w-[200px]">
                        {{ $this->form->getComponent('paymentDate')->label('Payment Date') }}
                    </div>

                    <!-- Training Mode -->
                    <div class="flex-1 min-w-[200px]">
                        {{ $this->form->getComponent('trainingMode')->label('Training Mode') }}
                    </div>

                    <!-- Enrolled By -->
                    <div class="flex-1 min-w-[200px]">
                        {{ $this->form->getComponent('enrolledBy')->label('Enrolled By') }}
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 flex-none">
                        <x-filament::button type="submit" size="sm" class="h-[42px]">
                            Apply Filters
                        </x-filament::button>
                        <x-filament::button type="button" color="gray" size="sm" wire:click="resetFilters"
                            class="h-[42px]">
                            Reset
                        </x-filament::button>
                    </div>
                </form>
            </div>

            <!-- Table Container with Enhanced Styling -->
            <x-filament-tables::container class="rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                <div class="fi-ta-content relative overflow-x-auto">
                    @if ($records && count($records))
                        <x-filament-tables::table class="divide-y divide-gray-150">
                            <!-- Table Header -->
                            <x-slot name="header" class="bg-blue-50">
                                <x-filament-tables::header-cell class="font-bold text-blue-700 text-lg">
                                    Course Details
                                </x-filament-tables::header-cell>
                                <x-filament-tables::header-cell class="font-bold text-blue-700 text-lg">
                                    Registrations
                                </x-filament-tables::header-cell>
                                @foreach ($this->currencies as $currency)
                                    <x-filament-tables::header-cell class="font-bold text-blue-700 text-lg text-right">
                                        {{ $currency }} Total
                                    </x-filament-tables::header-cell>
                                @endforeach
                            </x-slot>

                            <!-- Table Body -->
                            @foreach ($records as $courseName => $courseData)
                                <!-- Course Group -->
                                <x-filament-tables::row class="bg-blue-50 hover:bg-blue-100 transition-colors">
                                    <x-filament-tables::cell class="font-bold text-blue-800 text-base">
                                        📚 {{ $courseName }}
                                    </x-filament-tables::cell>
                                    <x-filament-tables::cell class="font-semibold text-blue-700">
                                        {{ $courseData['count'] }}
                                    </x-filament-tables::cell>
                                    @foreach ($this->currencies as $currency)
                                        <x-filament-tables::cell class="text-right font-semibold text-blue-700">
                                            {{ $this->formatCurrency($courseData['sums'][$currency] ?? 0, $currency) }}
                                        </x-filament-tables::cell>
                                    @endforeach
                                </x-filament-tables::row>

                                @foreach ($courseData['dates'] as $date => $dateData)
                                    <!-- Date Subgroup -->
                                    <x-filament-tables::row class="bg-gray-50 hover:bg-gray-100">
                                        <x-filament-tables::cell class="pl-8 font-medium text-gray-700">
                                            📅 {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                                        </x-filament-tables::cell>
                                        <x-filament-tables::cell class="text-gray-600">
                                            {{ $dateData['count'] }}
                                        </x-filament-tables::cell>
                                        @foreach ($this->currencies as $currency)
                                            <x-filament-tables::cell class="text-right text-gray-600">
                                                {{ $this->formatCurrency($dateData['sums'][$currency] ?? 0, $currency) }}
                                            </x-filament-tables::cell>
                                        @endforeach
                                    </x-filament-tables::row>

                                    @foreach ($dateData['times'] as $time => $timeData)
                                        <!-- Time Subgroup -->
                                        <x-filament-tables::row class="hover:bg-gray-50">
                                            <x-filament-tables::cell class="pl-16 text-gray-500 text-sm">
                                                ⏰ {{ \Carbon\Carbon::parse($time)->format('h:i A') }}
                                            </x-filament-tables::cell>
                                            <x-filament-tables::cell class="text-gray-500 text-sm">
                                                {{ $timeData['count'] }}
                                            </x-filament-tables::cell>
                                            @foreach ($this->currencies as $currency)
                                                <x-filament-tables::cell class="text-right text-gray-500 text-sm">
                                                    {{ $this->formatCurrency($timeData['sums'][$currency] ?? 0, $currency) }}
                                                </x-filament-tables::cell>
                                            @endforeach
                                        </x-filament-tables::row>
                                    @endforeach
                                @endforeach

                                <!-- Section Divider -->
                                <tr>
                                    <td colspan="{{ count($this->currencies) + 2 }}"
                                        class="h-4 bg-gradient-to-r from-blue-50 to-gray-50"></td>
                                </tr>
                            @endforeach

                            <!-- Grand Total -->
                            @php $grandTotals = $this->getGrandTotals(); @endphp
                            <x-filament-tables::row class="bg-blue-100 border-t-2 border-blue-200">
                                <x-filament-tables::cell class="font-bold text-blue-900 text-lg">
                                    🏆 Grand Total
                                </x-filament-tables::cell>
                                <x-filament-tables::cell class="font-bold text-blue-900 text-lg">
                                    {{ $grandTotals['count'] }}
                                </x-filament-tables::cell>
                                @foreach ($this->currencies as $currency)
                                    <x-filament-tables::cell class="font-bold text-blue-900 text-lg text-right">
                                        {{ $this->formatCurrency($grandTotals['sums'][$currency] ?? 0, $currency) }}
                                    </x-filament-tables::cell>
                                @endforeach
                            </x-filament-tables::row>
                        </x-filament-tables::table>
                    @else
                        <!-- Enhanced Empty State -->
                        <div class="p-8 text-center">
                            <div class="py-12 text-gray-400">
                                <x-heroicon-o-document-magnifying-glass class="w-16 h-16 mx-auto mb-4 text-blue-200" />
                                <p class="text-2xl font-medium text-gray-500">No matching records found</p>
                                <p class="mt-2 text-gray-400">Try adjusting your search filters</p>
                                <x-filament::button wire:click="resetFilters"
                                    class="mt-4 bg-blue-50 hover:bg-blue-100 text-blue-600">
                                    Reset Filters
                                </x-filament::button>
                            </div>
                        </div>
                    @endif
                </div>
            </x-filament-tables::container>
        </div>
    </x-filament::card>
</x-filament-panels::page>
