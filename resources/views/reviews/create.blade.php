@extends('layouts.app')

@section('title', 'Tulis Ulasan | eyetails.co')

@section('content')

<section class="container">
    <div class="review-form-card">
        <div class="product-info-header">
            <img src="https://via.placeholder.com/100x120/F0F0F0?text=Produk" alt="{{ $item->product_name }}">
            <div>
                <p class="text-gray-600">Anda sedang mengulas:</p>
                <h2>{{ $item->product_name }}</h2>
            </div>
        </div>

        <form action="{{ route('reviews.store') }}" method="POST" class="auth-form">
            @csrf
            <input type="hidden" name="order_item_id" value="{{ $item->id }}">

            <div class="form-group">
                <label for="rating">Rating Anda</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" required /><label for="star5"
                        title="5 stars">★</label>
                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4"
                        title="4 stars">★</label>
                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3"
                        title="3 stars">★</label>
                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2"
                        title="2 stars">★</label>
                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star">★</label>
                </div>
                @error('rating') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mt-4">
                <label for="content">Ulasan Anda</label>
                <textarea id="content" name="content" rows="5" class="form-input"
                    placeholder="Bagaimana pendapat Anda tentang produk ini?" required>{{ old('content') }}</textarea>
                @error('content') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary w-full mt-4">KIRIM ULASAN</button>
        </form>
    </div>
</section>

@endsection