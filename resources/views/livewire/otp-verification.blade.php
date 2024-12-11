<div wire:poll.1s="decrementTimer">
    @if (Auth::user() && Auth::user()->email_verified_at == null && !$otp_expired)
        <div class="popup">
            <div class="email-card">
                {{-- Success Message --}}
                @if ($success_message)
                    <div class="alert alert-success">
                        {{ $success_message }}
                    </div>
                @endif

                {{-- Error Message --}}
                @if ($error_message)
                    <div class="alert alert-danger">
                        {{ $error_message }}
                    </div>
                @endif

                <h1>OTP Verification</h1>
                <p>Enter the OTP you received at <span id="email">{{ Auth::user()->email }}</span></p>

                <div class="otp-input">
                    @foreach ($otp as $index => $digit)
                        <input type="number" min="0" max="9" wire:model.live="otp.{{ $index }}"
                            maxlength="1" wire:keydown.enter="verifyOTP"
                            @if ($index > 0) x-ref="otp{{ $index }}"
                                x-on:input="$refs.otp{{ $index + 1 }}?.focus()" @endif>
                    @endforeach
                </div>

                <button wire:click.prevent="verifyOTP">Verify</button>

                <div class="resend-text">
                    @if ($resend_allowed)
                        Didn't receive the code?
                        <span class="resend-link" wire:click.prevent="sendOtp">Resend Code</span>
                    @endif
                    <span id="timer">{{ $time_left }} seconds</span>
                </div>
            @elseif ($otp_expired)
                <div class="otp-expired">
                    {{-- Error Message --}}
                    @if ($error_message)
                        <div class="alert alert-danger">
                            {{ $error_message }}
                        </div>
                    @endif

                    <p>Your OTP has expired. Please request a new one.</p>
                    <button wire:click.prevent="sendOtp" class="btn btn-primary">Send New OTP</button>
                </div>
            </div>
        </div>
    @endif
    <script>
        const inputs = document.querySelectorAll('.otp-input input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length > 1) {
                    e.target.value = e.target.value.slice(0, 1);
                }
                if (e.target.value.length === 1) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value) {
                    if (index > 0) {
                        inputs[index - 1].focus();
                    }
                }
                if (e.key === 'e') {
                    e.preventDefault();
                }
            });
        });
    </script>
</div>
