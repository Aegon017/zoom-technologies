<div>
    <style>
        .otp-input input {
            width: 50px;
            height: 50px;
            margin: 0 8px;
            text-align: center;
            font-size: 1.5rem;
            border: 2px solid #6f6f6f;
            border-radius: 12px;
            background-color: #eeeeee;
            color: #1d1d1d;
            transition: all 0.3s ease;
        }

        .otp-input input:focus {
            border-color: #fd5222;
            box-shadow: 0 0 0 1px #fd5222;
            outline: none;
        }

        .otp-input input::-webkit-outer-spin-button,
        .otp-input input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .otp-input input[type=number] {
            -moz-appearance: textfield;
        }

        #timer {
            font-size: 1rem;
            color: #fd5222;
            font-weight: 500;
            margin-left: 10px;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }

        .expired {
            animation: pulse 2s infinite;
            color: #cc3309;
        }

        .resend-text {
            margin-top: 1rem;
            font-size: 0.9rem;
            color: gray;
        }

        .resend-link {
            color: #fd5222;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .resend-link:hover {
            color: #cc3309;
            text-decoration: underline;
        }

        #email {
            color: #fd5222;
            font-weight: 500;
        }
    </style>
    <h4 class="mb-3 text-dark">Verify Your Email</h4>
    <p class="text-muted">Please enter the OTP that was sent to <a href=""
            class="text-underline">{{ Auth::user()->email }}</a></p>
    <form wire:submit="verifyOTP">
        <div class="otp-input">
            <input type="number" wire:model="otp0" min="0" max="9" required>
            <input type="number" wire:model="otp1" min="0" max="9" required>
            <input type="number" wire:model="otp2" min="0" max="9" required>
            <input type="number" wire:model="otp3" min="0" max="9" required>
            <input type="number" wire:model="otp4" min="0" max="9" required>
            <input type="number" wire:model="otp5" min="0" max="9" required>
        </div>
        <button wire:click.prevent='generateOTP' class="btn-orange ml-2 mt-4">Send verification mail</button>
        <button wire:click.prevent="verifyOTP" class="btn-orange ml-2 mt-4">Verify</button>
    </form>
    <div class="resend-text">
        Didn't receive the code?
        <span class="resend-link" wire:click.prevent="resendOTP">Resend Code</span>
        <span id="timer"></span>
    </div>
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
