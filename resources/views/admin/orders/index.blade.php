@extends('admin.layout')

@section('content')

<h2>Orders</h2>

<div class="card">

<table width="100%" cellpadding="10">

    <tr>
        <th>Order No</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($orders as $order)

    <tr>
        <td>{{ $order->order_number }}</td>

        <td>{{ $order->user->name ?? 'Guest' }}</td>

        <td>₦{{ number_format($order->total) }}</td>

        <td>{{ ucfirst($order->status) }}</td>

        <td>
            <a href="/admin/orders/{{ $order->id }}">
                View
            </a>
        </td>
    </tr>

    @endforeach

</table>

</div>

@endsection