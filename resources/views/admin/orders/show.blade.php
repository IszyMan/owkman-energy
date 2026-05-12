@extends('admin.layout')

@section('content')

<h2>Order Details</h2>

<div class="card">

    <p>
        <strong>Order Number:</strong>
        {{ $order->order_number }}
    </p>

    <p>
        <strong>Customer:</strong>
        {{ $order->user->name ?? 'Guest' }}
    </p>

    <p>
        <strong>Phone:</strong>
        {{ $order->phone }}
    </p>

    <p>
        <strong>Delivery Address:</strong>
        {{ $order->delivery_address }}
    </p>

    <p>
        <strong>Total:</strong>
        ₦{{ number_format($order->total) }}
    </p>

    <hr>

    <h3>Products</h3>

    @foreach($order->items as $item)

        <div style="margin-bottom:15px;">

            <strong>{{ $item->product->name }}</strong>

            <br>

            Qty: {{ $item->quantity }}

            <br>

            ₦{{ number_format($item->price) }}

        </div>

    @endforeach

    <hr>

    <h3>Update Status</h3>

    <form method="POST"
          action="/admin/orders/{{ $order->id }}/status">

        @csrf

        <select name="status">

            <option value="pending">Pending</option>

            <option value="paid">Paid</option>

            <option value="processing">Processing</option>

            <option value="shipped">Shipped</option>

            <option value="delivered">Delivered</option>

        </select>

        <button type="submit">
            Update
        </button>

    </form>

</div>

@endsection