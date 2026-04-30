@extends('admin.layout')

@section('content')

<div class="card">
    <h2>Categories</h2>

    <a href="/admin/categories/create">+ Add Category</a>

    <hr>

    @foreach($categories as $category)
        <p>{{ $category->name }}</p>
    @endforeach
</div>

@endsection