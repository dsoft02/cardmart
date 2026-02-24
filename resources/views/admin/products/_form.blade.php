@csrf

<div class="row g-4">

    {{-- LEFT: COVER IMAGE --}}
    <div class="col-md-4">

        <label class="form-label">Product Cover</label>

        <div
            class="border rounded d-flex align-items-center justify-content-center position-relative"
            style="aspect-ratio:1/1; cursor:pointer; background:#f8f9fa;"
            onclick="document.getElementById('cover-image-input').click()"
        >
            <img
                id="cover-image-preview"
                src="{{ !empty($product?->cover_image)
                        ? asset('storage/'.$product->cover_image)
                        : asset('assets/img/placeholders/product-cover.jpg') }}"
                class="img-fluid rounded"
                style="object-fit:cover; width:100%; height:100%;"
            >

            <div class="position-absolute bottom-0 w-100 text-center bg-dark bg-opacity-50 text-white py-1 small">
                Click to change
            </div>
        </div>

        <input
            type="file"
            name="cover_image"
            id="cover-image-input"
            class="d-none"
            accept="image/png,image/jpeg,image/webp"
        >

        <small class="text-muted d-block mt-2">
            Square image, <strong>600 × 600px</strong>. Max 2MB.
        </small>

        {{-- GALLERY DROPZONE --}}
        <div class="col-12 mt-4">

            <h6 class="fw-semibold mb-3">Product Gallery</h6>

            <div id="gallery-dropzone"
                 class="border rounded p-4 text-center position-relative"
                 style="border-style:dashed; cursor:pointer; background:#fafafa;">

                <div class="text-muted">
                    Drag & drop images here<br>
                    or <span class="text-primary fw-semibold">click to upload</span>
                </div>

                <input type="file"
                       id="gallery-input"
                       name="gallery[]"
                       multiple
                       accept="image/png,image/jpeg,image/webp"
                       class="d-none">
            </div>

            <small class="text-muted d-block mt-2">
                Max 10 images. 4MB each. Auto-optimized & converted to WebP.
            </small>

            {{-- Preview Grid --}}
            <div id="gallery-preview" class="row g-3 mt-3"></div>

            {{-- Existing Images --}}
            @if(!empty($product?->images) && $product->images->count())
                <div class="row g-3 mt-4" id="existing-image-div">
                    @foreach($product->images as $image)
                        <div class="col-md-3">
                            <div class="position-relative">
                                <img src="{{ asset('storage/'.$image->image_path) }}"
                                     class="img-fluid rounded"
                                     style="aspect-ratio:1/1; object-fit:cover;">

                                <button type="button"
                                        class="gallery-delete-btn position-absolute top-0 end-0 m-1"
                                        data-url="{{ route('admin.product-images.destroy', $image) }}">
                                    &times;
                                </button>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </div>

    {{-- RIGHT: DETAILS --}}
    <div class="col-md-8">

        {{-- BASIC INFO --}}
        <div class="mb-4">
            <h6 class="fw-semibold mb-3">Basic Information</h6>

            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    placeholder="e.g. 30-Day Self-Care Planner"
                    value="{{ old('name', $product->name ?? '') }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input
                    type="text"
                    name="slug"
                    class="form-control"
                    placeholder="auto-generated if left empty"
                    value="{{ old('slug', $product->slug ?? '') }}"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Short Description</label>
                <textarea
                    name="short_description"
                    class="form-control"
                    rows="2"
                    placeholder="Brief summary shown on product cards"
                >{{ old('short_description', $product->short_description ?? '') }}</textarea>
            </div>
        </div>

        {{-- DESCRIPTION --}}
        <div class="mb-4">
            <h6 class="fw-semibold mb-3">Full Description</h6>

            <x-summernote
                name="description"
                :value="old('description', $product->description ?? '')"
                height="220"
            />
        </div>

        {{-- PRICING --}}
        <div class="mb-4">
            <h6 class="fw-semibold mb-3">Pricing</h6>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        @foreach (['ebook', 'toolkit', 'planner', 'other'] as $type)
                            <option value="{{ $type }}"
                                @selected(old('type', $product->type ?? '') === $type)>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Price (₦)</label>
                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        class="form-control"
                        placeholder="0.00"
                        value="{{ old('price', $product->price ?? '') }}"
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sale Price</label>
                    <input
                        type="number"
                        step="0.01"
                        name="sale_price"
                        class="form-control"
                        placeholder="Optional"
                        value="{{ old('sale_price', $product->sale_price ?? '') }}"
                    >
                </div>
            </div>

            <div class="form-check mt-3">
                <input type="hidden" name="on_sale" value="0">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="on_sale"
                    id="on_sale"
                    value="1"
                    @checked(old('on_sale', $product->on_sale ?? false))
                >
                <label class="form-check-label" for="on_sale">
                    Product is on sale
                </label>
            </div>
        </div>

        {{-- DELIVERY --}}
        <div class="mb-4">
            <h6 class="fw-semibold mb-3">Delivery Options</h6>

            <div class="mb-3">
                <label class="form-label">External Purchase URL</label>
                <input
                    type="url"
                    name="external_url"
                    class="form-control"
                    placeholder="https://amazon.com/... or https://etsy.com/..."
                    value="{{ old('external_url', $product->external_url ?? '') }}"
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Local Download File</label>
                <input
                    type="file"
                    name="download_file"
                    class="form-control"
                    accept=".pdf,.zip,.rar,.7z,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.epub,.mobi,.txt,.md,.png,.jpg,.jpeg,.gif,.webp,.mp3,.wav,.mp4"
                >
                <small class="text-muted">
                    Supported formats: PDF, ZIP, Word, Excel, EPUB, images, audio, video
                </small>

                @if (!empty($product?->download_path))
                    <small class="text-danger d-block mt-1">
                        A file is already attached to this product.
                    </small>
                @endif
            </div>
        </div>

        {{-- STATUS --}}
        <div class="mb-2">
            <h6 class="fw-semibold mb-3">Status</h6>

            <div class="form-check">
                <input type="hidden" name="is_active" value="0">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="is_active"
                    id="is_active"
                    value="1"
                    @checked(old('is_active', $product->is_active ?? true))
                >
                <label class="form-check-label" for="is_active">
                    Active & visible on site
                </label>
            </div>
        </div>

        <div class="form-check mt-2">
            <input type="hidden" name="is_featured" value="0">
            <input
                class="form-check-input"
                type="checkbox"
                name="is_featured"
                id="is_featured"
                value="1"
                @checked(old('is_featured', $product->is_featured ?? false))
            >
            <label class="form-check-label" for="is_featured">
                Featured product (highlight on homepage & listings)
            </label>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        /* =========================
           CONFIG
        ========================= */
        const MAX_GALLERY_IMAGES = 10;
        const MAX_FILE_SIZE = 4 * 1024 * 1024; // 4MB

        /* =========================
           COVER IMAGE PREVIEW
        ========================= */
        const coverInput = document.getElementById('cover-image-input');
        const coverPreview = document.getElementById('cover-image-preview');

        if (coverInput) {
            coverInput.addEventListener('change', () => {
                const file = coverInput.files[0];
                if (!file) return;

                if (file.size > 2097152) {
                    Swal.fire('Too Large', 'Cover image must not exceed 2MB.', 'error');
                    coverInput.value = '';
                    return;
                }

                const img = new Image();
                img.onload = () => {
                    if (img.width < 600 || img.height < 600) {
                        Swal.fire('Invalid Size', 'Cover image must be at least 600 × 600 pixels.', 'error');
                        coverInput.value = '';
                        return;
                    }
                    coverPreview.src = img.src;
                };
                img.src = URL.createObjectURL(file);
            });
        }

        /* =========================
           GALLERY DROPZONE
        ========================= */
        const dropzone = document.getElementById('gallery-dropzone');
        const galleryInput = document.getElementById('gallery-input');
        const previewContainer = document.getElementById('gallery-preview');

        let selectedFiles = [];

        if (dropzone && galleryInput) {

            dropzone.addEventListener('click', () => galleryInput.click());

            dropzone.addEventListener('dragover', e => {
                e.preventDefault();
                dropzone.classList.add('bg-light');
            });

            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('bg-light');
            });

            dropzone.addEventListener('drop', e => {
                e.preventDefault();
                dropzone.classList.remove('bg-light');
                handleFiles(e.dataTransfer.files);
            });

            galleryInput.addEventListener('change', () => {
                handleFiles(galleryInput.files);
            });
        }

        function handleFiles(files) {

            for (let file of files) {

                if (!file.type.startsWith('image/')) continue;

                if (file.size > MAX_FILE_SIZE) {
                    Swal.fire('Too Large', file.name + ' exceeds 4MB limit.', 'error');
                    continue;
                }

                if (selectedFiles.length >= MAX_GALLERY_IMAGES) {
                    Swal.fire('Limit Reached', 'Maximum 10 images allowed.', 'warning');
                    break;
                }

                selectedFiles.push(file);
            }

            syncFileInput();
            renderPreview();
        }

        function renderPreview() {

            previewContainer.innerHTML = '';

            selectedFiles.forEach((file, index) => {

                const col = document.createElement('div');
                col.className = 'col-md-3';

                const wrapper = document.createElement('div');
                wrapper.className = 'position-relative';

                const img = document.createElement('img');
                img.className = 'img-fluid rounded';
                img.style.aspectRatio = '1/1';
                img.style.objectFit = 'cover';
                img.src = URL.createObjectURL(file);

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                //removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 m-1';
                removeBtn.className = 'gallery-delete-btn position-absolute top-0 end-0 m-1';
                removeBtn.innerHTML = '&times;';
                removeBtn.onclick = () => removeImage(index);

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                col.appendChild(wrapper);
                previewContainer.appendChild(col);
            });
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1);
            syncFileInput();
            renderPreview();
        }

        function syncFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            galleryInput.files = dataTransfer.files;
        }

        /* =========================
   EXISTING IMAGE DELETE (Dynamic Form)
========================= */
        document.addEventListener('click', function (e) {

            const btn = e.target.closest('.gallery-delete-btn');
            if (!btn) return;

            const url = btn.dataset.url;

            Swal.fire({
                title: 'Delete image?',
                text: 'This cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete'
            }).then(result => {

                if (!result.isConfirmed) return;

                // Create form dynamically
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';

                // CSRF
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                // Method spoof
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);

                document.body.appendChild(form);
                form.submit();
            });
        });
    </script>
@endpush
