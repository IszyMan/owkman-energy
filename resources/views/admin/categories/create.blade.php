@extends('admin.layout')

@section('content')

<div class="card">
    <h2>Add Category</h2>

    <form method="POST" action="/admin/categories">
        @csrf

        <input type="text" name="name" placeholder="Category Name"><br><br>

        <textarea name="description" placeholder="Description (optional)"></textarea><br><br>

        <button type="submit">Save</button>
    </form>
</div>

@endsection