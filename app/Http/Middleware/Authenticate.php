<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // TAMBAHKAN BARIS INI
            session()->flash('error', 'Anda harus login terlebih dahulu untuk menambahkan barang ke keranjang.');
            return route('login');
        }
        return null;   
    }
}
