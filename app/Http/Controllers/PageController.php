<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Menampilkan halaman Kontak Kami.
     * Route: /kontak-kami
     */
    public function contact()
    {
        // Pastikan Anda telah membuat resources/views/contact.blade.php
        return view('contact');
    }

    /**
     * Menampilkan halaman Tentang Kami (Visi & Misi).
     * Route: /tentang-kami
     */
    public function about()
    {
        // Pastikan Anda telah membuat resources/views/about.blade.php
        return view('about');
    }

    /**
     * Menampilkan halaman FAQ.
     * Route: /faq
     */
    public function faq()
    {
        // Pastikan Anda telah membuat resources/views/faq.blade.php
        return view('faq');
    }
    /**
     * Menampilkan halaman Syarat dan Ketentuan.
     * Route: /syarat-dan-ketentuan
     */
    public function terms()
    {
        return view('terms');
    }

    /**
     * Menampilkan halaman Kebijakan Privasi.
     * Route: /kebijakan-privasi
     */
    public function privacy()
    {
        return view('privacy');
    }

    public function loyaltyTerms()
    {
        // Ini hanya akan mengembalikan file view yang akan kita buat di Langkah 4
        return view('loyalty-terms');
    }
}
