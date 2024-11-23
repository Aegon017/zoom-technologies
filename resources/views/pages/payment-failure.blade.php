<x-frontend-layout>
    <section class="response-section py-5">
        <div class="container">
            <div class="response-card">
                <div class="card alert-danger">
                    <i class="fas fa-times-circle text-center display-4 pt-5"></i>
                    <div class="card-body text-center pb-5 pt-3">
                        <h4>Payment Failed</h4>
                        <p class="pt-3"><strong>{{ $order->payment_desc }}</strong></p>
                        <p><strong>Order No. :</strong> {{ $order->order_number }}</p>
                        <p><strong>Payment Id :</strong> {{ $order->payment_id }}</p>
                        <a href="{{ route('render.myOrders') }}" class="btn btn-primary mt-3">Go to orders</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
