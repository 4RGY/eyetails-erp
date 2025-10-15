@extends('layouts.app')

@section('title', $post->title . ' | Blog eyetails.co')

@section('content')

<article class="blog-post-container container">
    {{-- Header Artikel --}}
    <header class="post-header">
        <a href="{{ route('blog.index') }}" class="back-link">← Kembali ke Blog</a>
        <h1 class="post-title">{{ $post->title }}</h1>
        <p class="post-meta">
            Dipublikasikan pada {{ $post->published_at->format('d F Y') }}
        </p>
    </header>

    {{-- Gambar Utama --}}
    @if($post->image)
    <figure class="post-image-figure">
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="post-main-image">
    </figure>
    @endif

    {{-- Isi Konten Artikel --}}
    <div class="post-body">
        {!! nl2br(e($post->body)) !!}
    </div>
</article>

@endsection