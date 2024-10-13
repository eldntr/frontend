<!DOCTYPE html>
<html>
<head>
    <title>Your Transactions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Your Transactions</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>${{ $order->total }}</td>
                        <td>{{ $order->status }}</td>
                        <td>
                            @if($order->status === 'pending')
                                <!-- Tombol "Pay Now" -->
                                <form action="{{ route('payment.process', $order->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Pay Now</button>
                                </form>
                            @else
                                <span class="text-success">Paid</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>You have no transactions yet.</p>
    @endif
</div>
</body>
</html>
