<div>
    <div class="e-books-wrapper bg-white d-block w-100 p-4 mb-4">
        <div class="e-books-content d-block mb-4 position-relative text-center">
            <h3 class="text-primary text-center mb-4">{{ $courseName }}</h3>
        </div>
        <div class="zt-ebooks-list d-block w-100 position-relative">
            <div class="row">
                @foreach ($studyMaterials as $studyMaterial)
                    <div class="col-lg-3 col-md-4 col-sm-2 col-xs-12 mb-4">
                        <div class="study-material-item">
                            <a href="{{ $studyMaterial->material_pdf ? asset(Storage::url($studyMaterial->material_pdf)) : $studyMaterial->material_url }}"
                                target="_blank" rel="noopener noreferrer">
                                <img src="{{ asset(Storage::url($studyMaterial->image)) }}"
                                    alt="{{ $studyMaterial->image_alt }}">
                                <div class="study-material-content">
                                    <h3>{{ $studyMaterial->name }}</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
