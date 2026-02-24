@props([
    'name',
    'value' => '',
    'height' => 200,
])

<textarea
    name="{{ $name }}"
    class="form-control summernote"
>{!! $value !!}</textarea>

@once
    @push('styles')
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.summernote').forEach(el => {
                    if (!el.dataset.initialized) {
                        $(el).summernote({
                            height: {{ $height }},
                            toolbar: [
                                ['style', ['style']],
                                ['font', ['bold', 'italic', 'underline', 'clear']],
                                ['fontname', ['fontname','fontsize','fontsizeunit']],
                                ['color', ['color','forecolor','backcolor']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['height', ['height']],
                                ['insert', ['link', 'picture', 'video','table','hr']],
                                ['view', ['fullscreen', 'codeview','undo','redo', 'help']]
                            ]
                        });
                        el.dataset.initialized = true;
                    }
                });
            });
        </script>
    @endpush
@endonce
