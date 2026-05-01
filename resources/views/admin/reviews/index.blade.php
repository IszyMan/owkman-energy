<h2>Reviews Management</h2>

@foreach($reviews as $review)
    <div style="padding:10px; background:#fff; margin-bottom:10px;">
        
        <p><b>Product:</b> {{ $review->product->name }}</p>
        <p><b>User:</b> {{ $review->user->name }}</p>
        <p>{{ $review->comment }}</p>
        <p>Rating: {{ $review->rating }}</p>
        <p>Status: {{ $review->status }}</p>

        @if($review->status !== 'approved')
        <form method="POST" action="/admin/reviews/{{ $review->id }}/approve">
            @csrf
            @method('PATCH')
            <button>Approve</button>
        </form>
        @endif

        <form method="POST" action="/admin/reviews/{{ $review->id }}">
            @csrf
            @method('DELETE')
            <button style="background:red;color:white;">Delete</button>
        </form>

    </div>
@endforeach