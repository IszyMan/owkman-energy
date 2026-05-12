@extends('admin.layout')

@section('content')

<div class="card">
    <h2>Categories</h2>

    <a href="/admin/categories/create">+ Add Category</a>

    <hr>

    @foreach($categories as $category)
        <div style="padding:10px; border-bottom:1px solid #ddd; display:flex; justify-content:space-between; align-items:center;">

            {{-- LEFT: CATEGORY NAME --}}
            <div>
                <strong>{{ $category->name }}</strong>
            </div>

            {{-- RIGHT: ACTIONS --}}
            <div style="display:flex; gap:10px;">

                {{-- EDIT --}}
                <a href="/admin/categories/{{ $category->id }}/edit"
                   style="padding:6px 10px; background:blue; color:white; text-decoration:none; border-radius:4px;">
                    Edit
                </a>

                {{-- DELETE --}}
                <form action="/admin/categories/{{ $category->id }}" method="POST"
                      onsubmit="return confirm('Delete this category?')">

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