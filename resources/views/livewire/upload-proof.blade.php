<div class="p-5">
    <h3 class="title text-center font-weight-bold mb-4">
        Upload Proof</h3>
    <div class="d-flex justify-content-around {{ $photo || $id_card ? 'border p-3' : '' }}">
        @if ($photo)
            <div>
                <img width="100" src="{{ $photo->temporaryUrl() }}">
                <h6 class="mt-2">Profile Picture</h6>
            </div>
        @endif
        @if ($id_card)
            <div>
                <img width="100" src="{{ $id_card->temporaryUrl() }}">
                <h6 class="mt-2">ID proof</h6>
            </div>
        @endif
    </div>
    <form wire:submit="save">
        <div class="mt-2 mb-3">
            <label for="profile" class="form-label">Profile Picture</label>
            <input class="form-control" wire:model="photo" type="file" id="profile">
            @error('photo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="idProof" class="form-label">ID proof</label>
            <input class="form-control" wire:model="id_card" type="file" id="idProof">
            @error('id_card')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button class="btn d-block ml-auto continue-btn" type="submit">
            Submit
        </button>
    </form>
</div>
