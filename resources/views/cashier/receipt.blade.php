<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
        }
        .receipt-container {
            width: 300px; /* Thermal printer width approx */
            padding: 10px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .mb-2 { margin-bottom: 8px; }
        .mb-4 { margin-bottom: 16px; }
        .border-top { border-top: 1px dashed #000; padding-top: 8px; mt-2; }
        .border-bottom { border-bottom: 1px dashed #000; padding-bottom: 8px; mb-2; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 4px 0; vertical-align: top; }
        .item-name { max-width: 150px; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="text-center mb-4">
            <h2 class="font-bold" style="margin:0;">RESTORAN APP</h2>
            <div>Jl. Merdeka No. 123, Jakarta</div>
            <div>Tel: (021) 1234-5678</div>
        </div>

        <div class="border-top mb-2">
            <div>Order: {{ $order->order_number }}</div>
            <div>Date: {{ $order->created_at->format('d/m/Y H:i') }}</div>
            <div>Type: {{ ucfirst($order->order_type) }} {{ $order->table ? '- Table '.$order->table->table_number : '' }}</div>
            <div>Cashier: Admin</div> <!-- Hardcoded for now or fetch auth user if available -->
        </div>

        <table class="border-top border-bottom mb-2">
            @foreach($order->items as $item)
            <tr>
                <td class="item-name">
                    {{ $item->menu->name ?? 'Item' }}
                    @if($item->notes) <br><small><i>{{ $item->notes }}</i></small> @endif
                </td>
                <td class="text-right">{{ $item->quantity }}x</td>
                <td class="text-right">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </table>

        <table class="mb-4">
            <tr class="font-bold">
                <td>TOTAL</td>
                <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            @if($order->payment)
            <tr>
                <td>Payment ({{ strtoupper($order->payment->payment_method) }})</td>
                <td class="text-right">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Change</td>
                <td class="text-right">Rp {{ number_format($order->payment->amount - $order->total_price, 0, ',', '.') }}</td>
            </tr>
            @endif
        </table>

        <div class="text-center border-top">
            <div class="mb-2">Thank you for your visit!</div>
            <button class="no-print" onclick="window.print()" style="padding: 8px 16px; cursor: pointer; border: 1px solid #000; background: #eee;">
                Print Receipt
            </button>
        </div>
    </div>
</body>
</html>
