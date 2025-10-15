@extends('layouts.app')
@section('title', 'Blog & Berita | eyetails.co')

@section('content')
<section class="page-header container text-center">
    <h1>BLOG & BERITA</h1>
    <p>Informasi terbaru seputar fashion, koleksi, dan gaya hidup urban.</p>
</section>

<section class="blog-list-section container">
    @if($posts->count())
    {{-- Featured Post (Artikel Terbaru) --}}
    @php
    $featuredPost = $posts->first();
    @endphp
    <div class="featured-post">
        <a href="{{ route('blog.show', $featuredPost) }}" class="featured-post-link">
            <img src="{{ asset('storage/' . $featuredPost->image) }}" alt="{{ $featuredPost->title }}"
                class="featured-post-image">
            <div class="featured-post-overlay">
                <div class="featured-post-info">
                    <span class="featured-post-date">{{ $featuredPost->published_at->format('d F Y') }}</span>
                    <h2 class="featured-post-title">{{ $featuredPost->title }}</h2>
                    <p class="featured-post-excerpt">{{ $featuredPost->excerpt }}</p>
                </div>
            </div>
        </a>
    </div>

    {{-- Grid untuk Artikel Lainnya --}}
    @if($posts->count() > 1)
    <div class="post-grid">
        {{-- Loop dimulai dari artikel kedua --}}
        @foreach ($posts->skip(1) as $post)
        <div class="post-card">
            <a href="{{ route('blog.show', $post) }}">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="post-image">
            </a>
            <div class="post-info">
                <span class="post-date">{{ $post->published_at->format('d M Y') }}</span>
                <h3><a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a></h3>
                <p>{{ $post->excerpt }}</p>
                <a href="{{ route('blog.show', $post) }}" class="read-more">Baca Selengkapnya &rarr;</a>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="pagination-area">
        {{ $posts->links() }}
    </div>

    @else
    <p class="text-center no-results">Belum ada berita yang dipublikasikan.</p>
    @endif
</section>
@endsection