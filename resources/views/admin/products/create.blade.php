@extends('admin.layout')

@section('content')

<div class="card">
    <h2>Add Product</h2>

    <form method="POST" action="/admin/products" enctype="multipart/form-data">
        @csrf

        <input type="text" name="name" placeholder="Product Name"><br><br>

        <input type="number" name="price" placeholder="Price"><br><br>

        <input type="number" name="stock" placeholder="Stock Quantity"><br><br>

        <!-- CATEGORY DROPDOWN -->
        <select name="category_id">
            <option value="">Select Category</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <br><br>

        <textarea name="description" placeholder="Description"></textarea><br><br>

        <div id="image-wrapper">
            <div class="image-input">
                <input type="file" name="images[]">
                <button type="button" class="remove-btn" onclick="removeImage(this)">Remove</button>
            </div>
        </div>

        <br>

        <button type="button" onclick="addImage()">+ Add another image</button><br><br>

        <button type="submit">Save Product</button>
    </form>
</div>


<script>
function addImage() {
    const wrapper = document.getElementById('image-wrapper');

    const div = document.createElement('div');
    div.classList.add('image-input');

    div.innerHTML = `
        <input type="file" name="images[]">
        <button type="button" class="remove-btn" onclick="removeImage(this)">Remove</button>
    `;

    wrapper.appendChild(div);
}

function removeImage(button) {
    button.parentElement.remove();
}
</script>

@endsection