<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
                <th scope="col" class="px-16 py-3">
                    <span class="sr-only">Image</span>
                </th>
                <th scope="col" class="px-6 py-3">
                    Course
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr class="bg-white border-b border-gray-700 hover:bg-gray-50">
                    <td class="p-4">
                        <img src="{{ asset(Storage::url($order->course->thumbnail)) }}"
                            alt="{{ $order->course->thumbnail_alt }}"
                            class="w-16 md:w-44 max-w-full max-h-full rounded-lg">
                    </td>
                    <td class="py-4 font-semibold text-gray-900">
                        {{ $order->course->name }}
                    </td>
                    <td class="px-6 py-4">
                        Rs. {{ $order->courseOrPackage_price }}/-
                    </td>
                    <td class="px-6 py-4 font-semibold">
                        {!! \Carbon\Carbon::parse($order->payment_time)->format('F j, Y, g:i A') !!}
                    </td>
                    <td class="px-6 py-4">
                        {{ $order->payment->status }}
                    </td>
                    <td class="px-6 py-4">
                        <a class="font-bold hover:text-orange-500 px-2 py-2 rounded"
                            href="{{ route('order-details', $order->id) }}">
                            View
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
