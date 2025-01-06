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
                            <a href="javascript:void(0);" class="open-iframe-modal"
                                data-url="{{ $studyMaterial->material_pdf ? asset(Storage::url($studyMaterial->material_pdf)) : $studyMaterial->material_url }}">
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

    <!-- Modal Structure -->
    <div class="modal fade" id="iframeModal" tabindex="-1" role="dialog" aria-labelledby="iframeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="iframeModalLabel">E-Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="iframeContent" src=""
                        style="width: 100%; height: 500px; border: none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Bootstrap JS (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.open-iframe-modal').on('click', function() {
                var url = $(this).data('url');
                $('#iframeContent').attr('src', url);
                $('#iframeModal').modal('show');
            });

            // Clear the iframe source when the modal is closed
            $('#iframeModal').on('hidden.bs.modal', function() {
                $('#iframeContent').attr('src', '');
            });
        });
    </script>
</div>
