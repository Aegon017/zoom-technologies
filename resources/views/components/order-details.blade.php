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
                    @if ($order->payment->status == 'success')
                        <a class="text-blue-600" href="{{ asset($order->invoice) }}" target="_blank">View invoice →</a>
                    @endif
                </div>
                <p class="text-gray-600 mb-1"><strong>Order number:</strong> {{ $order->order_number }}</p>
                <p class="text-gray-600 mb-8"><strong>Date & time:</strong>
                    {!! $order->payment->date !!}, {!! $order->payment->time !!}
                </p>
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row mb-6">
                        <div class="mt-4 sm:mt-0 sm:ml-6 w-full sm:w-2/3">
                            <img alt="{{ $order->course->thumbnail_alt ?? $order->package->thumbnail_alt }}"
                                class="w-full object-contain object-top rounded-lg"
                                src="{{ asset(Storage::url($order->course->thumbnail ?? $order->package->thumbnail)) }}" />
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-6 w-full sm:w-2/3">
                            <h2 class="text-xl font-semibold mb-2">
                                {{ $order->course->name ?? $order->package->name }}
                            </h2>
                            <p><strong>Price:</strong> {{ $order->payment->currency }}
                                {{ $order->courseOrPackage_price }}</p>
                            <p><strong>Duration:</strong>{{ $order->course->duration ?? $order->package->duration }}
                                {{ $order->course->duration_type ?? $order->package->duration_type }}</p>
                            <div class="flex flex-col sm:flex-row justify-between my-4">
                                <div class="mb-4 sm:mb-0">
                                    <p class="text-gray-600">
                                        <strong class="mb-4">Course schedule:</strong>
                                        @foreach ($order->schedule as $schedule)
                                            <br><strong>Course name:</strong>{{ $schedule->course->name }} <br>
                                            <strong>Batch:</strong>{{ $schedule->start_date }}
                                            {{ $schedule->time }} <br>
                                            <strong>Training mode:</strong>{{ $schedule->training_mode }}
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
                            <p class="text-gray-600"><strong>Payment Mode</strong>: {{ $order->payment->method }}</p>
                            <p class="text-gray-600"><strong>Payment status</strong>: {{ $order->payment->status }}</p>
                            <p class="text-gray-600"><strong>Payment description</strong>:
                                {{ $order->payment->description }}
                            </p>
                            <p class="text-gray-600"><strong>Payment Id:</strong>
                                {{ $order->payment->payment_id }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-semibold mb-3">Payment information</h3>
                    </div>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>Subtotal</span>
                        <span>{{ $order->payment->currency }} {{ $order->courseOrPackage_price }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>CGST({{ (100 * $order->cgst) / $order->courseOrPackage_price }}%)</span>
                        <span>{{ $order->payment->currency }} {{ $order->cgst }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 mb-2">
                        <span>SGST({{ (100 * $order->sgst) / $order->courseOrPackage_price }}%)</span>
                        <span>{{ $order->payment->currency }} {{ $order->sgst }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-gray-900">
                        <span>Order total</span>
                        <span>{{ $order->payment->currency }} {{ $order->payment->amount }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
