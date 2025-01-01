<div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/intlTelInput.min.js"></script>
    <form wire:submit.prevent="register" id="register-form">
        <div class="form-group">
            <label for="fullName" class="font-weight-semibold">Full Name</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-user text-muted"></i>
                    </span>
                </div>
                <input type="text" class="form-control" id="fullName" placeholder="Enter your name"
                    wire:model="fullName" required>
            </div>
            @error('name')
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
                <input type="email" class="form-control" id="email" placeholder="Enter email" wire:model="email"
                    required>
            </div>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone" class="font-weight-semibold">Phone Number</label>
            <div class="input-group">
                <input type="tel" class="form-control" id="phone" placeholder="Enter phone number"
                    wire:model="phone" required>
            </div>
            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled" class="btn btn-dark btn-block">
            <span wire:loading class="loader"></span>Register</button>
    </form>
    <script>
        const input = document.querySelector("#phone");
        const form = document.querySelector("#register-form");
        const iti = window.intlTelInput(input, {
            loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.2.1/build/js/utils.js"),
            strictMode: true,
        });
        form.addEventListener("submit", () => {
            if (!iti.isValidNumber()) {
                alert("Invalid phone number");
                return;
            }
            const number = iti.getNumber();
            @this.set("phone", number);
        });
    </script>
</div>
