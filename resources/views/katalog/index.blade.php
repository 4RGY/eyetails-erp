@extends('layouts.app')

@section('title', 'Katalog Produk | eyetails.co')

@section('content')

<section class="page-header container text-center">
    <h1>KATALOG KOLEKSI</h1>
    <p>Temukan produk terbaik kami, filter berdasarkan kategori, dan nikmati pengalaman berbelanja yang mudah.</p>
</section>

<section class="catalog-page container">
    <aside class="sidebar-filter">
        <div class="filter-widget">
            <h3 class="widget-title">Kategori</h3>
            <ul class="category-list">
                <li>
                    <a href="{{ route('catalog.index', array_merge(request()->except('category', 'page'), ['category' => 'all'])) }}"
                        class="{{ $currentCategory == 'all' ? 'active' : '' }}">
                        Semua Produk
                    </a>
                </li>
                @foreach ($categories as $category)
                <li>
                    <a href="{{ route('catalog.index', array_merge(request()->except('category', 'page'), ['category' => $category->slug])) }}"
                        class="{{ $currentCategory == $category->slug ? 'active' : '' }}">
                        {{ $category->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="filter-widget">
            <h3 class="widget-title">Urutkan</h3>
            {{-- Form untuk sorting agar lebih aksesibel --}}
            <form action="{{ route('catalog.index') }}" method="GET">
                @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <select name="sort" class="sort-select" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort', 'latest' )=='latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Harga Terendah
                    </option>
                    <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Harga Tertinggi
                    </option>
                </select>
            </form>
        </div>
    </aside>

    <main class="product-listing">
        <header class="listing-header">
            <p class="product-count">{{ $products->total() }} Produk Ditemukan</p>
        </header>

        @if ($products->count())
        <div class="product-grid catalog-grid">
            @foreach ($products as $product)
            <x-product-card :product="$product" />
            @endforeach
        </div>

        @if($products->hasPages())
        <div class="pagination-area">
            {{ $products->links() }}
        </div>
        @endif

        @else
        <div class="no-results-container">
            <h3>Produk Tidak Ditemukan</h3>
            <p>Maaf, tidak ada produk yang cocok dengan filter Anda saat ini.</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">Lihat Semua Produk</a>
        </div>
        @endif
    </main>
</section>

@endsection

@push('styles')
<style>
    .catalog-page {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 2.5rem;
        align-items: flex-start;
    }

    .sidebar-filter {
        position: sticky;
        top: 100px;
    }

    .filter-widget {
        margin-bottom: 2.5rem;
    }

    .widget-title {
        font-size: 1.1rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #eee;
    }

    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-list li a {
        display: block;
        padding: 0.75rem 0.5rem;
        text-decoration: none;
        color: #333;
        font-weight: 500;
        border-radius: 6px;
        transition: background-color 0.2s, color 0.2s;
    }

    .category-list li a:hover {
        background-color: #f8f9fa;
        color: #000;
    }

    .category-list li a.active {
        background-color: var(--primary-accent, #4f46e5);
        color: #fff;
        font-weight: 600;
    }

    .listing-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
    }

    .product-count {
        margin: 0;
        color: #6c757d;
    }

    .sort-select {
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        cursor: pointer;
    }

    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .catalog-grid .product-card {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
    }

    .catalog-grid .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .pagination-area {
        margin-top: 3rem;
    }

    .no-results-container {
        text-align: center;
        padding: 3rem 0;
    }

    @media (max-width: 1200px) {
        .catalog-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .catalog-page {
            grid-template-columns: 1fr;
        }

        .sidebar-filter {
            position: static;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }
    }

    @media (max-width: 576px) {
        .catalog-grid {
            grid-template-columns: 1fr;
        }

        .sidebar-filter {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush