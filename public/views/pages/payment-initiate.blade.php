<form id="payment-form" action="{{ config('services.payu.payu_url') }}/_payment" method="POST">
    @csrf
    @foreach ($data as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
</form>

<script>
    window.onload = function() {
        document.getElementById('payment-form').submit();
    };
</script>