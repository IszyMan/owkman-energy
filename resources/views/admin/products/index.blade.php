@extends('admin.layout')

@section('content')

<div class="card">
    <h1>Products</h1>

    <a href="/admin/products/create">+ Add Product</a>

    <hr>

    @foreach($products as $product)
        <div style="padding:12px; border-bottom:1px solid #ddd; display:flex; align-items:center; justify-content:space-between; gap:15px;">

            {{-- LEFT: IMAGES + INFO --}}
            <div style="display:flex; align-items:center; gap:15px;">

                {{-- IMAGES --}}
                <div style="display:flex; gap:5px;">
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/' . $img->image) }}"
                            width="60"
                            height="60"
                            style="object-fit:cover; border-radius:5px;">
                    @endforeach
                </div>

                {{-- INFO --}}
                <div>
                    <strong>{{ $product->name }}</strong><br>
                    ₦{{ number_format($product->price) }}<br>

                    {{-- STOCK STATUS --}}
                    @if($product->stock > 0)
                        <span style="color:green; font-weight:bold;">In Stock ({{ $product->stock }})</span>
                    @else
                        <span style="color:red; font-weight:bold;">Out of Stock</span>
                    @endif
                </div>

            </div>

            {{-- RIGHT: ACTIONS --}}
            <div style="display:flex; gap:10px;">

                {{-- EDIT --}}
                <a href="/admin/products/{{ $product->id }}/edit"
                style="padding:6px 10px; background:blue; color:white; text-decoration:none; border-radius:4px;">
                    Edit
                </a>

                {{-- DELETE --}}
                <form action="/admin/products/{{ $product->id }}" method="POST" onsubmit="return confirm('Delete this product?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            style="padding:6px 10px; background:red; color:white; border:none; border-radius:4px; cursor:pointer;">
                        Delete
                    </button>
                </form>

            </div>

        </div>
    @endforeach
</div>

@endsection