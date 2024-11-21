<div class="col-lg-4 col-md-4 col-6 mb-2">
    <div class="study-material-item">
        <a href="{{ $studyMaterial->material_url }}">
            <img src="{{ asset(Storage::url($studyMaterial->image)) }}" alt="{{ $studyMaterial->image_alt }}">
            <div class="study-material-content">
                <h3>{{ $studyMaterial->name }}</h3>
            </div>
        </a>
    </div>
</div>
