<div>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/css/intlTelInput.css">
        <style>
            .iti {
                width: 100%;
            }

            .iti__selected-country-primary {
                border-right: 1px solid #ced4da;
            }
        </style>
    @endpush

    <form wire:submit.prevent="register" id="register-form">
        @if (session()->has('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="form-group">
            <label for="fullName" class="font-weight-semibold">Full Name</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-user text-muted"></i>
                    </span>
                </div>
                <input type="text" class="form-control @error('fullName') is-invalid @enderror" id="fullName"
                    placeholder="Enter your name" wire:model="fullName" required>
            </div>
            @error('fullName')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="font-weight-semibold">Email Address</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-envelope text-muted"></i>
                    </span>
                </div>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    placeholder="Enter email" wire:model="email" required>
            </div>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone" class="font-weight-semibold">Phone Number</label>
            <div class="input-group" wire:ignore>
                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                    placeholder="Enter phone number" wire:model="phone" required>
            </div>
            @if ($errors->has('phone'))
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            @else
                @error('valid')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            @endif
        </div>

        <input type="hidden" wire:model="valid" value="{{ $valid }}">

        <button type="submit" wire:loading.attr="disabled" class="btn btn-dark btn-block">
            <span wire:loading class="loader"></span>Register
        </button>
    </form>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/intlTelInput.min.js"></script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                const input = document.querySelector("#phone");
                const form = document.querySelector("#register-form");
                const iti = window.intlTelInput(input, {
                    loadUtils: () => import(
                        "https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/utils.js"),
                    strictMode: true,
                    separateDialCode: false,
                    initialCountry: "IN",
                });

                form.addEventListener("submit", (e) => {
                    if (!iti.isValidNumber()) {
                        @this.set("valid", false);
                        e.preventDefault();
                        return;
                    }

                    @this.set("valid", true);
                    const number = iti.getNumber();
                    @this.set("phone", number);
                });
            });
        </script>
    @endpush
</div>
