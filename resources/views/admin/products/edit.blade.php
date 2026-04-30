@extends('admin.layout')

@section('content')

<div class="card">
    <h2>Edit Product</h2>

    <form method="POST" action="/admin/products/{{ $product->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $product->name }}" placeholder="Product Name"><br><br>

        <input type="number" name="price" value="{{ $product->price }}" placeholder="Price"><br><br>

        <input type="number" name="stock" value="{{ $product->stock }}" placeholder="Stock Quantity"><br><br>

        <textarea name="description">{{ $product->description }}</textarea><br><br>

        {{-- EXISTING IMAGES (REPLACE MODE) --}}
        @if($product->images->count() > 0)

            <h4>Product Images (Click to Replace)</h4>

            <div style="display:flex; gap:10px; flex-wrap:wrap;">

                @foreach($product->images as $img)
                    <div style="text-align:center;">

                        <img 
                            src="{{ asset('storage/' . $img->image) }}"
                            width="100"
                            height="100"
                            style="object-fit:cover; border-radius:5px; cursor:pointer;"
                            onclick="document.getElementById('file-{{ $img->id }}').click()"
                            id="preview-{{ $img->id }}"
                        >

                        <input 
                            type="file"
                            name="replace_images[{{ $img->id }}]"
                            id="file-{{ $img->id }}"
                            style="display:none;"
                            onchange="previewReplace(event, {{ $img->id }})"
                        >

                    </div>
                @endforeach

            </div>

            <br><br>

        @else

            <p><b>No images for this product yet.</b></p>

        @endif

        <br><br>

       <h4>Add New Images</h4>

        <div id="edit-image-wrapper">
            <div class="image-input">
                <input type="file" name="new_images[]">
                <button type="button" class="remove-btn" onclick="removeEditImage(this)">Remove</button>
            </div>
        </div>

        <br>

        <button type="button" onclick="addEditImage()">+ Add another image</button>

        <br><br>
        <button type="submit">Update Product</button>
    </form>
</div>


<script>
function previewReplace(event, id) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('preview-' + id).src = e.target.result;
        }

        reader.readAsDataURL(file);
    }
}
</script>


<script>
function previewReplace(event, id) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('preview-' + id).src = e.target.result;
        }

        reader.readAsDataURL(file);
    }
}

/* ADD NEW IMAGE FIELD */
function addEditImage() {
    const wrapper = document.getElementById('edit-image-wrapper');

    const div = document.createElement('div');
    div.classList.add('image-input');

    div.innerHTML = `
        <input type="file" name="new_images[]">
        <button type="button" class="remove-btn" onclick="removeEditImage(this)">Remove</button>
    `;

    wrapper.appendChild(div);
}

function removeEditImage(button) {
    button.parentElement.remove();
}
</script>

@endsection