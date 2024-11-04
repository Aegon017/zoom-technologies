<div class="col-lg-4 col-md-4 col-6 mb-2">
    <div class="study-material-item">
        <a href="{{ $material->material_url }}">
            <img src="{{ asset(Storage::url($material->image)) }}" alt="{{ $material->image_alt }}">
            <div class="study-material-content">
                <h3>{{ $material->name }}</h3>
            </div>
        </a>
    </div>
</div>
