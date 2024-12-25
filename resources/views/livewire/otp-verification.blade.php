<div>
    <h4 class="mb-3 text-dark">Verify Your Email</h4>
    <div x-data="{ otpInput: false, addressBtnContinue: false }" x-on:verification-success.window="addressBtnContinue=true">
        <button class="btn btn-dark" x-on:click="$dispatch('send-otp'); otpInput = !otpInput" x-show="! otpInput">Send
            Verification
            Mail</button>
        <div x-show="otpInput">
            <p class="text-muted">Please enter the OTP that was sent to <a href=""
                    class="text-underline">{{ Auth::user()?->email }}</a></p>
            <form wire:submit="verifyOTP">
                <div class="otp-input">
                    <input type="number" wire:model="otp0" name="otp_0" min="0" max="9" required>
                    <input type="number" wire:model="otp1" name="otp_1" min="0" max="9" required>
                    <input type="number" wire:model="otp2" name="otp_2" min="0" max="9" required>
                    <input type="number" wire:model="otp3" name="otp_3" min="0" max="9" required>
                    <input type="number" wire:model="otp4" name="otp_4" min="0" max="9" required>
                    <input type="number" wire:model="otp5" name="otp_5" min="0" max="9" required>
                </div>
                <div class="d-flex justify-content-between ml-2 mt-4">
                    <button wire:click.prevent="verifyOTP" class="btn btn-dark">Verify</button>
                    <button class="btn btn-orange" x-show="addressBtnContinue"
                        x-on:click.prevent="otpInput=false; verification=false; billingAddress=true; $dispatch('check-address')">Continue</button>
                </div>
            </form>
            <div class="resend-text">
                Didn't receive the code?
                <span class="resend-link" wire:click.prevent="resendOTP">Resend Code</span><span id="timer"></span>
                <span id="timer"></span>
            </div>
        </div>
    </div>
</div>
