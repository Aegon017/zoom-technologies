<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto bg-white p-4 sm:p-8 rounded-lg shadow">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold">Order Details</h1>
                    @if ($order->status == 'success')
                        <a class="text-blue-600" href="{{ asset($order->invoice) }}">View invoice →</a>
                    @endif
                </div>
                <p class="text-gray-600 mb-8">Order number: {{ $order->order_number }}, {{ $order->payment_time }}</p>
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row mb-6">
                        <img alt="{{ $order->course_thumbnail_alt }}" class="w-full object-cover sm:w-1/2 rounded-lg"
                            src="{{ asset(Storage::url($order->course_thumbnail)) }}" />
                        <div class="mt-4 sm:mt-0 sm:ml-6 w-full sm:w-2/3">
                            <h2 class="text-xl font-semibold mb-2">
                                {{ $order->course_name }}
                            </h2>
                            <p class="text-gray-600 mb-4">Rs. {{ $order->course_price }}/-</p>
                            <div class="flex flex-col sm:flex-row justify-between my-4">
                                <div class="mb-4 sm:mb-0">
                                    <p class="text-gray-600">
                                        <strong>Batch:</strong>
                                        @php
                                            $courseSchedulesJson = html_entity_decode($order->course_schedule);
                                            $courseSchedulesArray = json_decode($courseSchedulesJson, true);
                                        @endphp
                                        @if ($courseSchedulesArray)
                                            @foreach ($courseSchedulesArray as $item)
                                                @php
                                                    [$course_name, $course_time] = array_map(
                                                        'trim',
                                                        explode(',', $item),
                                                    );
                                                    [$date, $time, $mode] = array_map(
                                                        'trim',
                                                        explode(' ', $course_time),
                                                    ) + ['Not specified'];

                                                    $dateTimeObject = new DateTime("$date $time");
                                                @endphp
                                                <br>{{ $course_name }}:
                                                {{ $dateTimeObject->format('d M Y h:i A') }}
                                                {{ $mode }}
                                            @endforeach
                                        @else
                                            @php
                                                [$course_name, $course_time] = array_map(
                                                    'trim',
                                                    explode(',', $order->course_schedule),
                                                );
                                                [$date, $time, $mode] = array_map(
                                                    'trim',
                                                    explode(' ', $course_time),
                                                ) + ['Not specified'];

                                                $dateTimeObject = new DateTime("$date $time");
                                            @endphp
                                            {{ $dateTimeObject->format('d M Y h:i A') }} <br>
                                            Training Mode: {{ $mode }}
                                        @endif
                                        <br /> <strong>Course duration:</strong>
                                        {{ $order->course_duration }}
                                        {{ $order->course_duration_type }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg">
                    <div class="flex flex-col sm:flex-row justify-between mb-4">
                        <div class="mb-4 sm:mb-0">
                            <h3 class="font-semibold">Customer details</h3>
                            <p class="text-gray-600">
                                Name: {{ $order->user->name }}<br />
                                Email: {{ $order->user->email }}<br />
                                Phone: {{ $order->user->phone }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold">Payment information</h3>
                    </div>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>Subtotal</span>
                        <span>Rs. {{ $order->course_price }}/-</span>
                    </div>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>C.GST(9%)</span>
                        <span>Rs. {{ $order->cgst }}/-</span>
                    </div>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>S.GST(9%)</span>
                        <span>Rs. {{ $order->sgst }}/-</span>
                    </div>
                    <div class="flex justify-between font-semibold text-gray-900">
                        <span>Order total</span>
                        <span>Rs. {{ $order->amount }}/-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
