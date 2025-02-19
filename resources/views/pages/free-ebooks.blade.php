<x-frontend-layout>
    <style>
        @media (min-width: 992px) {
            .modal-lg {
                max-width: 100% !important;
            }

            .modal {
                overflow: hidden !important;
            }
        }
    </style>
    @if ($metaDetail != null)
        <x-slot:metaTitle>
            {{ $metaDetail->title }}
        </x-slot>
        <x-slot:metaKeywords>
            {{ $metaDetail->keywords }}
        </x-slot>
        <x-slot:metaDescription>
            {{ $metaDetail->description }}
        </x-slot>
    @endif

    <x-slot:localSchema>
        {!! $pageSchema?->local_schema !!}
    </x-slot>
    <x-slot:organizationSchema>
        {!! $pageSchema?->organization_schema !!}
    </x-slot>
    @php
        $pageBackground = 'frontend/assets/img/banner/contact-us-banner.jpg';
        $pageTitle = 'Free Study Materials';
    @endphp
    <x-page-breadcrumb :pageBackground="$pageBackground" :pageTitle="$pageTitle" />
    @if ($pageContent)
        <section class="zt-inner-page-wrapper e-books-page">
            <div class="container">
                @foreach ($pageContent as $data)
                    <div class="e-books-wrapper bg-white d-block w-100 p-4 mb-4">
                        <div class="e-books-content d-block mb-4 position-relative text-center">
                            <h3 class="text-primary text-center mb-4">{{ $data['heading'] }}</h3>
                            {!! $data['content'] !!}
                        </div>
                        @if ($loop->iteration === 1)
                            <div class="zt-ebooks-list d-block w-100 position-relative">
                                <div class="row">
                                    @foreach ($materials as $material)
                                        <div class="col-lg-3 col-md-4 col-sm-2 col-xs-12 mb-4">
                                            <div class="study-material-item">
                                                <a href="javascript:void(0);" class="open-iframe-modal"
                                                    data-url="{{ $material->material_pdf ? asset(Storage::url($material->material_pdf)) : $material->material_url }}">
                                                    <img src="{{ asset(Storage::url($material->image)) }}"
                                                        alt="{{ $material->image_alt }}">
                                                    <div class="study-material-content">
                                                        <h3>{{ $material->name }}</h3>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    <x-related-courses />
    <!-- Modal Structure -->
    <div class="modal fade px-4" id="iframeModal" tabindex="-1" role="dialog" aria-labelledby="iframeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg w-100" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="iframeContent" src=""
                        style="width: 100%; height: 80dvh; border: none;"></iframe>
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
</x-frontend-layout>
