<div class="mb-3">
    <label>Title</label>
    <input type="text"
           name="title"
           value="{{ $news->title ?? old('title') }}"
           class="form-control"
           required>
</div>

<div class="mb-3">
    <label>News Type</label>
    <select name="type"
            id="type"
            class="form-control"
            onchange="toggleFields()">
        <option value="pdf" {{ ($news->type ?? '') == 'pdf' ? 'selected' : '' }}>PDF</option>
        <option value="link" {{ ($news->type ?? '') == 'link' ? 'selected' : '' }}>Other Link</option>
        <option value="page" {{ ($news->type ?? '') == 'page' ? 'selected' : '' }}>Page Required</option>
    </select>
</div>


<!-- LINK -->
<div id="urlField" class="mb-3 d-none">
    <label>URL</label>
    <input type="url"
           name="url"
           value="{{ $news->url ?? '' }}"
           class="form-control"
           placeholder="https://example.com">
</div>


<!-- PAGE CONTENT -->
<div id="pageFields" class="d-none">

    <div class="mb-3">
        <label>Short Description</label>
        <textarea name="short_description"
                  class="form-control"
                  rows="2">{{ $news->short_description ?? '' }}</textarea>
    </div>

    <div class="mb-3">
        <label>Detail Content</label>
        <textarea id="detailEditor"
                  name="detail_content"
                  class="form-control">{!! $news->detail_content ?? '' !!}</textarea>
    </div>

    <div class="mb-3">
        <label>Image</label>
        <input type="file"
               name="image"
               id="imageInput"
               class="form-control">

        @if(!empty($news->image))
            <img src="{{ asset('storage/'.$news->image) }}"
                 width="120"
                 class="mt-2 rounded"
                 id="previewImage">
        @else
            <img id="previewImage"
                 width="120"
                 class="mt-2 rounded"
                 style="display:none;">
        @endif
    </div>

</div>


<!-- PDF -->
<div id="pdfField" class="mb-3">
    <label>Upload PDF</label>
    <input type="file"
           name="file"
           id="pdfInput"
           class="form-control"
           accept="application/pdf">

    @if(!empty($news->file))
        <div class="mt-2">
            <a href="{{ asset('storage/'.$news->file) }}"
               target="_blank"
               class="btn btn-sm btn-outline-primary">
               View Current PDF
            </a>
        </div>
    @endif
</div>


<script src="https://cdn.ckeditor.com/4.16.2/full/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){

    function toggleFields() {
        let type = document.getElementById('type').value;

        document.getElementById('pdfField').classList.toggle('d-none', type !== 'pdf');
        document.getElementById('urlField').classList.toggle('d-none', type !== 'link');
        document.getElementById('pageFields').classList.toggle('d-none', type !== 'page');
    }

    window.toggleFields = toggleFields;
    toggleFields();

    // CKEditor
    if(document.getElementById('detailEditor')){
        CKEDITOR.replace('detailEditor', {
            height: 180,
            toolbar: [
                ['Bold','Italic','BulletedList','Link','Unlink']
            ]
        });
    }

    // image preview
    const imageInput = document.getElementById('imageInput');
    if(imageInput){
        imageInput.addEventListener('change', function(e){
            if(e.target.files.length){
                const preview = document.getElementById('previewImage');
                preview.src = URL.createObjectURL(e.target.files[0]);
                preview.style.display = 'block';
            }
        });
    }

});
</script>
