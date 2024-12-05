<div id="new-user-form" class="card mb-4 border-radius-md" wire:poll.5s="checkVerificationStatus">
    @if ($status !== true)
        <div class="card-header py-3 px-5 bg-orange text-white">
            <h5 class="mb-0 text-orange">User Details</h5>
        </div>
        <div class="card-body px-5 my-3">
            <form wire:submit="register">
                @if ($errorMessage)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{{ $errorMessage }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input wire:model="fullName" type="text" class="form-control billing-fields" id="name"
                        name="name" required {{ $status !== true ? '' : 'readonly' }}>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="email">Email</label>
                        <input wire:model="email" type="email" class="form-control billing-fields" id="email"
                            name="email" required {{ $status !== true ? '' : 'readonly' }}>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="phone">Phone Number</label>
                        <input wire:model="phone" type="tel" class="form-control billing-fields" id="phone"
                            name="phone" required {{ $status !== true ? '' : 'readonly' }}>
                    </div>
                </div>
                @if ($status !== true)
                    <button type="submit" class="btn btn-primary btn-block continue-btn border-0">
                        <div class="d-flex justify-content-center"><span>Register</span>
                        </div>
                    </button>
                @endif
            </form>
        </div>
    @endif
    @if (Auth::user() && $status == null)
        <div class="popup">
            <div class="email-card">
                <i class="fas fa-lock display-3 text-danger mb-3"></i>
                <h3>Verification needed</h3>
                <p class="content">Check your email and please verify it to continue using the application.</p>
                <button wire:click='resendMail' class="btn continue-btn px-4">Resend</button>
                <p class="text-success mt-3">{{ $successMessage }}</p>
            </div>
        </div>
    @endif
</div>
