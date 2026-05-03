@extends('admin.layout')

@section('content')

<div class="card">
    <h2>Featured Products</h2>

    {{-- ADD FEATURED --}}
    <form method="POST" action="/admin/featured">
        @csrf

        <div class="feature-select">

            <!-- PRODUCT DROPDOWN -->
            <select name="product_id" class="feature-select__select" required>
                <option value="">Choose product</option>

                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>

        </div>

        <br>

        <button type="submit">Add Featured</button>
    </form>

    <hr><br>

    {{-- LIST FEATURED --}}
    @foreach($featureds as $item)
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">

            <div style="display:flex; align-items:center; gap:10px;">
                
                <img 
                    src="{{ $item->product->images->first() ? asset('storage/'.$item->product->images->first()->image) : asset('images/default.png') }}"
                    style="width:50px;height:50px;object-fit:cover;border-radius:6px;"
                >

                <span>{{ $item->product->name }}</span>
            </div>

            <form method="POST" action="/admin/featured/{{ $item->id }}">
                @csrf
                @method('DELETE')

                <button style="background:red;color:white;border:none;padding:5px 10px;border-radius:5px;">
                    Remove
                </button>
            </form>

        </div>
    @endforeach

</div>



@endsection