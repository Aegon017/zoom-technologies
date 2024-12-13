<div>
    <form wire:submit="register">
        <div class="form-group">
            <label for="fullName" class="font-weight-semibold">Full Name</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-envelope text-muted"></i>
                    </span>
                </div>
                <input type="text" class="form-control" id="fullName" placeholder="Enter your name"
                    wire:model="fullName">
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
                <input type="email" class="form-control" id="email" placeholder="Enter email" wire:model="email">
            </div>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone" class="font-weight-semibold">Phone Number (Optional)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-phone text-muted"></i>
                    </span>
                </div>
                <input type="tel" class="form-control" id="phone" placeholder="Enter phone number"
                    wire:model="phone">
            </div>
            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" wire:loading.attr="disabled" class="btn btn-dark btn-block">
            <span wire:loading class="loader"></span>Register</button>
    </form>
</div>
