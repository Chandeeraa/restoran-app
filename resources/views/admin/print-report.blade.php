<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - {{ $label }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 12px; color: #111; background: #fff; padding: 24px; }
        .header { text-align: center; padding-bottom: 16px; border-bottom: 2px solid #111; margin-bottom: 20px; }
        .header h1 { font-size: 20px; font-weight: bold; }
        .header p { font-size: 12px; color: #555; margin-top: 4px; }
        .meta { display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 12px; }
        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 24px; }
        .summary-card { border: 1px solid #ddd; border-radius: 8px; padding: 12px; text-align: center; }
        .summary-card .label { font-size: 10px; text-transform: uppercase; color: #666; letter-spacing: 0.5px; }
        .summary-card .value { font-size: 18px; font-weight: bold; margin-top: 4px; }
        .value.green { color: #16a34a; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        thead { background: #f4f4f5; }
        th { padding: 8px 10px; text-align: left; font-weight: 600; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; border-bottom: 2px solid #ddd; }
        td { padding: 8px 10px; border-bottom: 1px solid #eee; vertical-align: top; }
        tr:last-child td { border-bottom: none; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 999px; font-size: 10px; font-weight: 600; }
        .badge-green { background: #dcfce7; color: #15803d; }
        .footer { margin-top: 24px; padding-top: 12px; border-top: 1px solid #ddd; text-align: center; font-size: 10px; color: #888; }
        .filters { display: flex; justify-content: center; gap: 12px; margin-bottom: 20px; }
        .filter-btn { padding: 6px 16px; border: 1px solid #ddd; border-radius: 6px; font-size: 11px; color: #444; text-decoration: none; cursor: pointer; }
        .filter-btn.active { background: #4f46e5; color: white; border-color: #4f46e5; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #eee;">
        <div class="filters">
            <a href="{{ route('admin.report.print', ['period' => 'today']) }}" class="filter-btn {{ $period === 'today' ? 'active' : '' }}">Hari Ini</a>
            <a href="{{ route('admin.report.print', ['period' => 'month']) }}" class="filter-btn {{ $period === 'month' ? 'active' : '' }}">Bulan Ini</a>
            <a href="{{ route('admin.report.print', ['period' => 'all']) }}" class="filter-btn {{ $period === 'all' ? 'active' : '' }}">Semua</a>
        </div>
        <button onclick="window.print()" style="padding: 8px 20px; background: #4f46e5; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
            🖨️ Print Laporan
        </button>
    </div>

    <div class="header">
        <h1>{{ $setting->store_name ?? 'RESTORAN APP' }}</h1>
        @if($setting && $setting->store_address)<p>{{ $setting->store_address }}</p>@endif
        @if($setting && $setting->store_phone)<p>Tel: {{ $setting->store_phone }}</p>@endif
        <p style="margin-top: 8px; font-size: 14px; font-weight: bold;">LAPORAN PENJUALAN</p>
        <p>Periode: {{ $label }}</p>
    </div>

    <div class="meta">
        <span>Dicetak oleh: {{ auth()->user()->name }}</span>
        <span>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</span>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $orders->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Pendapatan</div>
            <div class="value green">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Rata-rata / Order</div>
            <div class="value">Rp {{ $orders->count() > 0 ? number_format($totalRevenue / $orders->count(), 0, ',', '.') : '0' }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Pelanggan</th>
                <th>Waktu</th>
                <th>Tipe</th>
                <th>Items</th>
                <th class="text-right">Subtotal</th>
                <th class="text-right">Diskon</th>
                <th class="text-right">Total</th>
                <th class="text-center">Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $i => $order)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $order->order_number }}</strong></td>
                <td>{{ $order->customer_name ?? '-' }}</td>
                <td>{{ $order->created_at->format('d/m H:i') }}</td>
                <td>{{ $order->order_type === 'dine-in' ? 'Dine-in' : 'Takeaway' }}</td>
                <td>
                    @foreach($order->items as $item)
                        <div>{{ $item->quantity }}x {{ $item->menu->name ?? 'Menu' }}</div>
                    @endforeach
                </td>
                <td class="text-right">{{ number_format($order->subtotal_price ?? $order->total_price, 0, ',', '.') }}</td>
                <td class="text-right">
                    @if($order->discount_amount > 0)
                        <span style="color:#16a34a;">-{{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                    @else -
                    @endif
                </td>
                <td class="text-right"><strong>{{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                <td class="text-center">
                    @if($order->payment)
                        <span class="badge badge-green">{{ strtoupper($order->payment->payment_method) }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center" style="padding: 24px; color: #888;">Tidak ada transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>— Dokumen ini dicetak secara otomatis oleh Sistem POS {{ $setting->store_name ?? 'Restoran App' }} —</p>
    </div>
</body>
</html>
