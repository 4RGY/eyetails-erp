<x-mail::message>
    # Status Pesanan #{{ $order->id }} Telah Diperbarui

    Halo {{ $order->customer_name }},

    Kami ingin memberitahukan bahwa status pesanan Anda telah diperbarui menjadi:

    <div class="status-box status-{{ Str::slug($order->order_status) }}">
        {{ $order->order_status }}
    </div>

    @if($order->order_status == 'Shipped' && $order->tracking_number)
    Gunakan nomor resi di bawah ini untuk melacak pengiriman Anda:
    <x-mail::panel>
        <strong>Nomor Resi: {{ $order->tracking_number }}</strong>
    </x-mail::panel>
    @endif

    @if($order->order_status == 'Completed')
    Pesanan Anda telah selesai. Kami harap Anda menyukai produknya! Jangan ragu untuk memberikan ulasan.
    @endif

    @if($order->order_status == 'Cancelled')
    Pesanan Anda telah dibatalkan. Jika Anda merasa ini adalah sebuah kesalahan, silakan hubungi layanan pelanggan kami.
    @endif

    ---

    ### Ringkasan Pesanan

    <x-mail::table>
        | Produk | Jumlah | Harga |
        |:-------------|:------:|:--------------|
        @foreach($order->items as $item)
        | {{ $item->product_name }} @if($item->size) (Ukuran: {{ $item->size }}) @endif | {{ $item->quantity }} | Rp {{
        number_format($item->price, 0, ',', '.') }} |
        @endforeach
    </x-mail::table>

    <x-mail::button :url="route('order.tracking', $order)">
        Lihat Detail Pesanan
    </x-mail::button>

    Terima kasih telah berbelanja di **eyetails.co**.

    Salam,<br>
    Tim {{ config('app.name') }}
</x-mail::message>

{{-- Tambahkan CSS ini untuk mempercantik tampilan status --}}
<style>
    .status-box {
        padding: 10px 15px;
        border-radius: 6px;
        font-weight: bold;
        text-align: center;
        margin: 15px 0;
        color: #fff;
    }

    .status-pending {
        background-color: #ffc107;
        color: #333;
    }

    .status-processing {
        background-color: #0d6efd;
    }

    .status-shipped {
        background-color: #6f42c1;
    }

    .status-completed {
        background-color: #198754;
    }

    .status-cancelled {
        background-color: #dc3545;
    }
</style>