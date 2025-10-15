@props(['promotions'])

<div class="promo-modal-content">
    <header class="promo-modal-header">
        <h2><i class="fas fa-tags"></i> Event & Promo Spesial</h2>
        <p>Gunakan kode voucher di bawah ini saat checkout!</p>
    </header>

    <div class="promo-list">
        @forelse ($promotions as $promo)
            <div class="promo-item">
                <div class="promo-info">
                    <h3>{{ $promo->name }}</h3>
                    <p>
                        Diskon {{ $promo->type == 'percentage' ? $promo->value . '%' : 'Rp ' . number_format($promo->value, 0, ',', '.') }}
                        @if ($promo->end_date)
                            <br><small>Berlaku hingga: {{ $promo->end_date->format('d F Y') }}</small>
                        @endif
                    </p>
                </div>
                @if ($promo->code)
                    <div class="promo-code">
                        <span>KODE:</span>
                        <strong>{{ $promo->code }}</strong>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-center">Saat ini belum ada promo spesial yang tersedia.</p>
        @endforelse
    </div>
</div>