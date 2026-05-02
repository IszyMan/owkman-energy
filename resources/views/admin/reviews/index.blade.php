@extends('admin.layout')

@section('content')

<div class="card">
    <h1>Reviews Management</h1>

    <hr>

    @foreach($reviews as $review)

        <div style="padding:12px; border-bottom:1px solid #ddd; display:flex; justify-content:space-between; gap:15px; align-items:flex-start;">

            {{-- LEFT SIDE --}}
            <div style="flex:1;">

                <strong>⭐ {{ $review->rating }}/5</strong>

                <p style="margin:5px 0; color:#666;">
                    {{ $review->comment }}
                </p>

                <small style="color:#999;">
                    Product: {{ $review->product->name }} • User: {{ $review->user->name }}
                </small>

                <div style="margin-top:5px;">
                    <span style="
                        padding:3px 8px;
                        border-radius:5px;
                        font-size:12px;
                        background: {{ $review->status == 'approved' ? '#dcfce7' : '#fef9c3' }};
                        color: {{ $review->status == 'approved' ? '#166534' : '#92400e' }};
                    ">
                        {{ ucfirst($review->status) }}
                    </span>
                </div>

            </div>

            {{-- RIGHT SIDE ACTIONS --}}
            <div style="display:flex; gap:10px; align-items:center;">

                @if($review->status !== 'approved')
                <form method="POST" action="/admin/reviews/{{ $review->id }}/approve">
                    @csrf
                    @method('PATCH')
                    <button style="
                        padding:6px 10px;
                        background:green;
                        color:white;
                        border:none;
                        border-radius:4px;
                        cursor:pointer;
                    ">
                        Approve
                    </button>
                </form>
                @endif

                <form method="POST" action="/admin/reviews/{{ $review->id }}">
                    @csrf
                    @method('DELETE')

                    <button style="
                        padding:6px 10px;
                        background:red;
                        color:white;
                        border:none;
                        border-radius:4px;
                        cursor:pointer;
                    ">
                        Delete
                    </button>
                </form>

            </div>

        </div>

    @endforeach
</div>

@endsection