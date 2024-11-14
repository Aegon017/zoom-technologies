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
                        <a class="text-blue-600" href="{{ asset($order->invoice) }}" target="_blank">View invoice →</a>
                    @endif
                </div>
                <p class="text-gray-600 mb-1"><strong>Order number:</strong> {{ $order->order_number }}</p>
                <p class="text-gray-600 mb-8"><strong>Date & time:</strong>
                    {!! \Carbon\Carbon::parse($order->payment_time)->format('F j, Y, g:i A') !!}
                </p>
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row mb-6">
                        <img alt="{{ $order->course_thumbnail_alt }}" class="w-full object-cover sm:w-1/2 rounded-lg"
                            src="{{ asset(Storage::url($order->course_thumbnail)) }}" />
                        <div class="mt-4 sm:mt-0 sm:ml-6 w-full sm:w-2/3">
                            <h2 class="text-xl font-semibold mb-2">
                                {{ $order->course_name }}
                            </h2>
                            <p><strong>Price:</strong> Rs. {{ $order->course_price }}/-</p>
                            <p><strong>Duration:</strong>{{ $order->course_duration }}
                                {{ $order->course_duration_type }}</p>
                            <div class="flex flex-col sm:flex-row justify-between my-4">
                                <div class="mb-4 sm:mb-0">
                                    <p class="text-gray-600">
                                        <strong class="mb-4">Course schedule:</strong>
                                        @foreach ($order->orderSchedule as $schedules)
                                            <br><strong>Course name:</strong>{{ $schedules->course_name }} <br>
                                            <strong>Batch:</strong>{{ $schedules->start_date->format('d M Y') }}
                                            {{ $schedules->time->format('h:i A') }} <br>
                                            <strong>Training mode:</strong>{{ $schedules->training_mode }}
                                            <p></p>
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg">
                    <div class="flex flex-col sm:flex-row justify-between mb-4">
                        <div class="mb-4 sm:mb-0">
                            <h3 class="font-semibold mb-2">Customer details</h3>
                            <p class="text-gray-600">
                                <strong>Name</strong>: {{ $order->user->name }}
                            </p>
                            <p class="text-gray-600">
                                <strong>Email</strong>: {{ $order->user->email }}
                            </p>
                            <p class="text-gray-600">
                                <strong>Phone</strong>: {{ $order->user->phone }}
                            </p>
                        </div>
                        <div class="mb-4 sm:mb-0">
                            <h3 class="font-semibold mb-2">Order Summary</h3>
                            <p class="text-gray-600"><strong>Payment status</strong>: {{ $order->status }}</p>
                            <p class="text-gray-600"><strong>Transaction Status</strong>: {{ $order->payment_desc }}
                            </p>
                            <p class="text-gray-600"><strong>Transaction Id:</strong>
                                {{ $order->transaction_id }}
                            </p>
                            <p class="text-gray-600"><strong>Payu Id:</strong>
                                {{ $order->payu_id }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-3">Payment information</h3>
                    </div>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>Subtotal</span>
                        <span>Rs. {{ $order->course_price }}/-</span>
                    </div>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>C.GST({{ (100 * $order->cgst) / $order->course_price }}%)</span>
                        <span>Rs. {{ $order->cgst }}/-</span>
                    </div>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>S.GST({{ (100 * $order->sgst) / $order->course_price }}%)</span>
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
