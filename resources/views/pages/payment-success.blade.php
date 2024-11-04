<x-frontend-layout>
    <section class="response-section py-5">
        <div class="container">
            <div class="response-card">
                <div class="card alert-success">
                    <i class="fas fa-check-circle text-center display-4 pt-5"></i>
                    <div class="card-body text-center pb-5 pt-3">
                        <h4>Payment Success</h4>
                        <p class="pt-3"><strong>Order Id:</strong> {{ $order->order_number }}</p>
                        <p><strong>Transaction Id:</strong> {{ $order->transaction_id }}</p>
                        <p><strong>PayU Id:</strong> {{ $order->payu_id }}</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go to orders</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
