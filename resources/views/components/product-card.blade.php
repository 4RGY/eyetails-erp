@props(['product'])

<a href="{{ route('catalog.show', $product) }}" class="product-card">
    <div class="product-image-wrapper">
        @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image"
            style="height: 100%; width: 100%; object-fit: cover;">
        @else
        <img src="https://via.placeholder.com/400x500/F0F0F0?text={{ urlencode($product->name) }}"
            alt="{{ $product->name }}" class="product-image">
        @endif

        {{-- ======================================================= --}}
        {{-- PERUBAHAN LOGIKA STOK DARI stock_quantity KE totalStock() --}}
        {{-- ======================================================= --}}
        @if($product->sale_price && $product->sale_price < $product->price)
            <span class="product-tag" style="background-color: #d9534f;">PROMO</span>
            @elseif($product->totalStock() > 0)
            <span class="product-tag">READY</span>
            @else
            <span class="product-tag" style="background-color: #6c757d;">HABIS</span>
            @endif
            {{-- ======================================================= --}}
    </div>
    <div class="product-info">
        <p class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</p>
        <p class="product-name">{{ $product->name }}</p>

        @if($product->sale_price && $product->sale_price < $product->price)
            <div class="product-price-container">
                <p class="sale-price">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</p>
                <p class="original-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
            @else
            <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            @endif
    </div>
</a>