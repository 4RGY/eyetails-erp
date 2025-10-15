@extends('layouts.app')

@section('title', 'Checkout | eyetails.co')

@section('content')

<section class="page-header container text-center">
    <h1>CHECKOUT</h1>
</section>

<section class="checkout-page container">
    {{-- Alert Messages --}}
    @if(session('promo_error'))<div class="alert alert-error">{{ session('promo_error') }}</div>@endif
    @if(session('promo_success'))<div class="alert alert-success">{{ session('promo_success') }}</div>@endif
    @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif

    @if ($errors->any())
    <div class="alert alert-error">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('checkout.place') }}" method="POST" class="checkout-form" enctype="multipart/form-data">
        @csrf
        <div class="checkout-layout">
            <main class="checkout-details">
                {{-- Shipping Details --}}
                <div class="detail-block">
                    <h2>1. Alamat Pengiriman</h2>
                    <div class="form-group">
                        <label for="customer_name">Nama Penerima</label>
                        <input type="text" name="customer_name" id="customer_name"
                            value="{{ old('customer_name', $defaultShipping['name']) }}" required>
                        @error('customer_name') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="customer_email">Email Kontak</label>
                            <input type="email" name="customer_email" id="customer_email"
                                value="{{ old('customer_email', $defaultShipping['email']) }}" required>
                            @error('customer_email') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="tel" name="phone" id="phone"
                                value="{{ old('phone', $defaultShipping['phone']) }}" required>
                            @error('phone') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="shipping_address">Alamat Lengkap</label>
                        <textarea name="shipping_address" id="shipping_address" rows="3"
                            required>{{ old('shipping_address', $defaultShipping['address']) }}</textarea>
                        @error('shipping_address') <span class="error-message">{{ $message }}</span> @enderror
                    </div>
                    @auth<small class="form-text">Alamat ini diambil dari profil Anda. Ubah di <a
                            href="{{ route('profile.edit') }}" class="text-link">pengaturan profil</a>.</small>@endauth
                </div>

                {{-- Shipping Method --}}
                <div class="detail-block mt-4">
                    <h2>2. Metode Pengiriman</h2>
                    <div class="shipping-options">
                        @forelse($shippingMethods as $method)
                        <div class="shipping-option-wrapper">
                            <input type="radio" name="shipping_method_id" value="{{ $method->id }}"
                                id="shipping_{{ $method->id }}" data-cost="{{ $method->cost }}" {{ $loop->first ?
                            'checked' : '' }}>
                            <label for="shipping_{{ $method->id }}" class="shipping-option-label">
                                <div class="shipping-info">
                                    <strong>{{ $method->name }}</strong>
                                    <small>{{ $method->description }}</small>
                                </div>
                                <span class="shipping-cost">Rp {{ number_format($method->cost) }}</span>
                            </label>
                        </div>
                        @empty
                        <p>Tidak ada metode pengiriman yang tersedia saat ini.</p>
                        @endforelse
                    </div>
                    @error('shipping_method_id') <span class="error-message">{{ $message }}</span> @enderror
                </div>


                {{-- Loyalty Points --}}
                @if(Auth::check() && $userPoints > 0)
                <div class="detail-block mt-4">
                    <h2>3. Gunakan Poin Loyalitas</h2>
                    <div class="points-redemption">
                        <p>Anda memiliki <strong>{{ number_format($userPoints) }} Poin</strong> (senilai <strong>Rp {{
                                number_format($userPoints * 100) }}</strong>).</p>
                        <div class="form-group">
                            <label for="points_to_use">Gunakan Poin (Opsional)</label>
                            <input type="number" name="points_to_use" id="points_to_use" class="form-control"
                                placeholder="0" min="0" max="{{ $userPoints }}">
                        </div>
                    </div>
                </div>
                @endif

                {{-- Payment Methods --}}
                <div class="detail-block mt-4">
                    <h2>{{ Auth::check() && $userPoints > 0 ? '4' : '3' }}. Metode Pembayaran</h2>
                    <div class="payment-options-dynamic">
                        @forelse($paymentMethods as $method)
                        <div class="payment-option-wrapper">
                            <input type="radio" name="payment_method_id" value="{{ $method->id }}"
                                id="payment_{{ $method->id }}" {{ $loop->first ? 'checked' : '' }} data-code="{{
                            $method->code }}">
                            <label for="payment_{{ $method->id }}" class="payment-option-label">
                                <span>{{ $method->name }}</span>
                            </label>
                        </div>
                        @empty
                        <p>Tidak ada metode pembayaran yang tersedia.</p>
                        @endforelse
                    </div>
                    @error('payment_method_id') <span class="error-message">{{ $message }}</span> @enderror

                    {{-- Konten Detail untuk Setiap Metode Pembayaran --}}
                    <div id="payment_details_container">
                        @foreach($paymentMethods as $method)
                        <div class="payment-detail-content" data-method-code="{{ $method->code }}"
                            style="display: none;">
                            <p>{!! nl2br(e($method->description)) !!}</p>
                        </div>
                        @endforeach

                        {{-- Input untuk upload bukti (dikontrol JS) --}}
                        <div class="form-group mt-4" id="proof-upload-container" style="display: none;">
                            <label for="payment_proof">Lampirkan Bukti Pembayaran</label>
                            <input type="file" name="payment_proof" id="payment_proof" class="form-control"
                                accept="image/*">
                            <small class="form-text">Format: JPG, PNG. Maksimal 2MB.</small>
                            @error('payment_proof') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </main>

            <aside class="cart-summary checkout-summary">
                <div class="promo-form-container">
                    <label for="promo_code">Punya Kode Voucher?</label>
                    <div class="promo-input-group">
                        <input type="text" name="promo_code" id="promo_code" placeholder="Masukkan kode"
                            value="{{ session('promo_code') }}">
                        <button type="submit" class="btn-apply-promo"
                            formaction="{{ route('checkout.applyPromo') }}">Gunakan</button>
                    </div>

                    @if(session('promo_code'))
                    <button type="submit" class="btn-remove-promo" formaction="{{ route('checkout.removePromo') }}"
                        style="margin-top: 10px;">
                        Hapus Voucher: {{ session('promo_code') }} <i class="fas fa-times"></i>
                    </button>
                    @endif
                </div>

                {{-- Order Summary --}}
                <h2>Ringkasan Pesanan</h2>
                <div class="summary-item-list">
                    @foreach($cart as $item)
                    <div class="summary-line item-detail">
                        <span class="summary-item-name">
                            {{ $item['name'] }} (x{{ $item['quantity'] }})
                            @if(isset($item['size']))
                            <small class="summary-item-size">Ukuran: {{ $item['size'] }}</small>
                            @endif
                        </span>
                        <span>Rp {{ number_format($item['price'] * $item['quantity']) }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="summary-line subtotal"><span>Subtotal</span><span id="subtotal-text">Rp {{
                        number_format($subtotal) }}</span></div>
                <div class="summary-line shipping"><span>Biaya Pengiriman</span><span id="shipping-cost-text">Rp {{
                        number_format($shippingCost) }}</span></div>
                <div class="summary-line" id="points-discount-line" style="display: none; color: #198754;"><span>Diskon
                        Poin</span><span id="points-discount-text">- Rp 0</span></div>
                @if(session('promo_discount'))
                <div class="summary-line promo-discount"><span>Diskon Promo</span><span>- Rp {{
                        number_format(session('promo_discount')) }}</span></div>
                @endif
                <div class="summary-line total-price"><span>TOTAL AKHIR</span><span id="total-text">Rp {{
                        number_format($total) }}</span></div>
                <button type="submit" class="btn btn-primary btn-large w-full mt-4">KONFIRMASI PESANAN</button>
            </aside>
        </div>
    </form>
</section>

@push('styles')
<style>
    /* General Form & Layout */
    .form-group {
        margin-bottom: 20px
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: .9rem
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        box-sizing: border-box
    }

    .form-group input:focus,
    .form-group textarea:focus {
        outline: 0;
        border-color: #1a1a1a;
        box-shadow: 0 0 5px rgba(0, 0, 0, .1)
    }

    .form-text {
        font-size: .85rem;
        color: #6c757d;
        margin-top: 5px
    }

    .text-link {
        color: var(--primary-accent, #4f46e5);
        text-decoration: underline;
        font-weight: 500
    }

    .checkout-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        align-items: flex-start
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px
    }

    /* Promo Form */
    .promo-form-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 4px;
        margin-bottom: 25px;
        border: 1px solid #e9ecef
    }

    .promo-form-container label {
        font-weight: 600;
        margin-bottom: 10px;
        display: block
    }

    .promo-input-group {
        display: flex
    }

    .promo-input-group input {
        flex-grow: 1;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 4px 0 0 4px
    }

    .promo-input-group input:focus {
        outline: 0;
        border-color: #1a1a1a
    }

    .btn-apply-promo {
        padding: 10px 15px;
        border: 1px solid #1a1a1a;
        background-color: #1a1a1a;
        color: #fff;
        cursor: pointer;
        border-radius: 0 4px 4px 0;
        font-weight: 600
    }

    .promo-discount {
        color: #198754;
        font-weight: 700
    }

    .btn-remove-promo {
        background-color: #f8d7da;
        color: #721c24;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid #f5c6cb;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        width: 100%;
        text-align: center;
        margin-top: 10px;
    }

    /* Shipping Options */
    .shipping-options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .shipping-option-wrapper input[type=radio] {
        display: none;
    }

    .shipping-option-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        cursor: pointer;
        transition: all .2s ease;
    }

    .shipping-info strong {
        display: block;
    }

    .shipping-info small {
        color: #6c757d;
    }

    .shipping-cost {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .shipping-option-wrapper input[type=radio]:checked+.shipping-option-label {
        border-color: var(--primary-accent, #4f46e5);
        background-color: #f4f3ff;
    }

    /* Payment Options */
    .payment-options-dynamic {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .payment-options-dynamic .payment-option-wrapper input[type=radio] {
        display: none;
    }

    .payment-options-dynamic .payment-option-label {
        display: block;
        padding: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all .2s ease;
    }

    .payment-options-dynamic .payment-option-wrapper input[type=radio]:checked+.payment-option-label {
        border-color: var(--primary-accent, #4f46e5);
        background-color: #f4f3ff;
        color: var(--primary-accent, #4f46e5);
    }

    #payment_details_container {
        margin-top: 20px;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 4px;
        border: 1px solid #e9ecef;
    }
    .summary-item-name {
    display: flex;
    flex-direction: column;
    }
    .summary-item-size {
    font-size: 0.85rem;
    color: #6c757d;
    margin-top: 2px;
    }

    /* Responsive */
    @media (max-width:992px) {
        .checkout-layout {
            grid-template-columns: 1fr;
            gap: 30px
        }

        .checkout-summary {
            margin-top: 30px;
            grid-row-start: 1
        }

        .checkout-details {
            grid-row-start: 2
        }
    }

    @media (max-width:768px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 20px
        }

        .checkout-layout {
            gap: 20px
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Variabel Global untuk Kalkulasi ---
        const subtotal = {{ $subtotal }};
        let shippingCost = parseFloat(document.querySelector('input[name="shipping_method_id"]:checked')?.dataset.cost || 0);
        const promoDiscount = {{ session('promo_discount', 0) }};
        const userPoints = {{ $userPoints ?? 0 }};
        const pointValue = 100;

        // --- Elemen DOM ---
        const pointsInput = document.getElementById('points_to_use');
        const pointsDiscountLine = document.getElementById('points-discount-line');
        const pointsDiscountText = document.getElementById('points-discount-text');
        const totalText = document.getElementById('total-text');
        const shippingCostText = document.getElementById('shipping-cost-text');
        const shippingRadios = document.querySelectorAll('input[name="shipping_method_id"]');

        function recalculateTotal() {
            let pointsToUse = pointsInput ? (parseInt(pointsInput.value) || 0) : 0;
            if (pointsToUse > userPoints) { pointsToUse = userPoints; pointsInput.value = userPoints; }
            if (pointsToUse < 0) { pointsToUse = 0; pointsInput.value = 0; }
            
            let pointsDiscountValue = pointsToUse * pointValue;
            const totalBeforeDiscounts = subtotal + shippingCost;
            
            if ((pointsDiscountValue + promoDiscount) > totalBeforeDiscounts) {
                pointsDiscountValue = totalBeforeDiscounts - promoDiscount;
                pointsToUse = Math.floor(pointsDiscountValue / pointValue);
                if(pointsInput) pointsInput.value = pointsToUse;
            }

            const newTotal = subtotal + shippingCost - pointsDiscountValue - promoDiscount;

            if (pointsDiscountValue > 0) {
                pointsDiscountText.textContent = '- Rp ' + pointsDiscountValue.toLocaleString('id-ID');
                pointsDiscountLine.style.display = 'flex';
            } else {
                pointsDiscountLine.style.display = 'none';
            }

            shippingCostText.textContent = 'Rp ' + shippingCost.toLocaleString('id-ID');
            totalText.textContent = 'Rp ' + newTotal.toLocaleString('id-ID');
        }

        if (pointsInput) {
            pointsInput.addEventListener('input', recalculateTotal);
        }
        
        shippingRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                shippingCost = parseFloat(this.dataset.cost);
                recalculateTotal();
            });
        });

        // --- Logika Metode Pembayaran Dinamis ---
        const paymentRadios = document.querySelectorAll('input[name="payment_method_id"]');
        const paymentDetailsContainer = document.getElementById('payment_details_container');
        const allPaymentDetails = paymentDetailsContainer.querySelectorAll('.payment-detail-content');
        const proofUploadContainer = document.getElementById('proof-upload-container');

        const methodsNeedingProof = ['bca_transfer', 'mandiri_transfer']; 

        function handlePaymentMethodChange() {
            const selectedRadio = document.querySelector('input[name="payment_method_id"]:checked');
            if (!selectedRadio) return;
            
            const selectedCode = selectedRadio.dataset.code;

            allPaymentDetails.forEach(detail => {
                detail.style.display = detail.dataset.methodCode === selectedCode ? 'block' : 'none';
            });

            proofUploadContainer.style.display = methodsNeedingProof.includes(selectedCode) ? 'block' : 'none';
        }

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', handlePaymentMethodChange);
        });
        
        handlePaymentMethodChange();
        recalculateTotal();
    });
</script>
@endpush

@endsection