@csrf

<div class="row g-4">

    {{-- Name --}}
    <div class="col-md-6">
        <h6 class="fw-semibold mb-3">Name</h6>
        <input type="text" name="name"
               value="{{ old('name', $examType->name ?? '') }}"
               class="form-control" required>
    </div>

    {{-- Price --}}
    <div class="col-md-6">
        <h6 class="fw-semibold mb-3">Price</h6>
        <input type="number" step="0.01" name="price"
               value="{{ old('price', $examType->price ?? '') }}"
               class="form-control" required>
    </div>

    {{-- Result Page URL --}}
    <div class="col-md-12">
        <h6 class="fw-semibold mb-3">Result Page URL</h6>
        <input type="url"
               name="result_page_url"
               value="{{ old('result_page_url', $examType->result_page_url ?? '') }}"
               class="form-control"
               placeholder="https://example.com">
    </div>

    {{-- Logo --}}
    <div class="col-md-4">
        <h6 class="fw-semibold mb-3">Logo</h6>

        <input type="file"
               name="logo"
               class="form-control image-input"
               data-preview="logoPreview">

        <div class="mt-2">
            <img id="logoPreview"
                 src="{{ $examType->logo_url ?? '' }}"
                 class="img-fluid rounded border {{ isset($examType) && $examType->logo ? '' : 'd-none' }}"
                 style="max-height:100px;">
        </div>
    </div>

    {{-- Cover Image --}}
    <div class="col-md-4">
        <h6 class="fw-semibold mb-3">Cover Image</h6>

        <input type="file"
               name="cover_image"
               class="form-control image-input"
               data-preview="coverPreview">

        <div class="mt-2">
            <img id="coverPreview"
                 src="{{ $examType->cover_url ?? '' }}"
                 class="img-fluid rounded border {{ isset($examType) && $examType->cover_image ? '' : 'd-none' }}"
                 style="max-height:100px;">
        </div>
    </div>

    {{-- PIN Background --}}
    <div class="col-md-4">
        <h6 class="fw-semibold mb-3">PIN Background</h6>
        <input type="file"
               name="pin_background_image"
               class="form-control image-input"
               data-preview="bgPreview">

        <div class="mt-2">
            <img id="bgPreview"
                 src="{{ $examType->cardbg_url ?? '' }}"
                 class="img-fluid rounded border {{ isset($examType) && $examType->pin_background_image ? '' : 'd-none' }}"
                 style="max-height:100px;">
        </div>
    </div>

    {{-- About Content --}}
    <div class="col-md-12">
        <h6 class="fw-semibold mb-3">About Content</h6>
        <x-summernote
            name="about_content"
            :value="old('about_content', $examType->about_content ?? '')"
            height="220"
        />

    </div>

    {{-- How To Buy --}}
    <div class="col-md-12">
        <h6 class="fw-semibold mb-3">How To Buy Content</h6>
        <x-summernote
            name="how_to_buy_content"
            :value="old('how_to_buy_content', $examType->how_to_buy_content ?? '')"
            height="220"
        />
    </div>

    {{-- How To Check --}}
    <div class="col-md-12">
        <h6 class="fw-semibold mb-3">How To Check Content</h6>
        <x-summernote
            name="how_to_check_content"
            :value="old('how_to_check_content', $examType->how_to_check_content ?? '')"
            height="220"
        />
    </div>

    {{-- Active --}}
    <div class="col-md-12">
        <div class="form-check mt-3">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   class="form-check-input"
                {{ old('is_active', $examType->is_active ?? true) ? 'checked' : '' }}>
            <h6 class="form-check-h6">
                Active
            </h6>
        </div>
    </div>

</div>

<div class="mt-4">
    <button class="btn btn-primary">
        <i class="bx bx-save me-1"></i>
        Save
    </button>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('.image-input').forEach(input => {

                input.addEventListener('change', function (e) {

                    const previewId = this.dataset.preview;
                    const preview = document.getElementById(previewId);

                    if (!this.files || !this.files[0]) return;

                    const reader = new FileReader();

                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                    };

                    reader.readAsDataURL(this.files[0]);
                });

            });

        });
    </script>
@endpush
