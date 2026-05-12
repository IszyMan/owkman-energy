@extends('admin.layout')

@section('content')

<div class="card">
    <h2>Edit Category</h2>

    <form method="POST" action="/admin/categories/{{ $category->id }}">
        @csrf
        @method('PUT')

        <input type="text" name="name" value="{{ $category->name }}" required>

        <button type="submit">Update</button>
    </form>
</div>

@endsection