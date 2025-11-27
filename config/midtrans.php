<?php

/*
|--------------------------------------------------------------------------
| Konfigurasi Midtrans
|--------------------------------------------------------------------------
|
| File ini memuat semua kredensial Midtrans Anda dari file .env.
| Ini adalah cara yang aman dan direkomendasikan untuk menghindari 
| error 500 saat config di-cache.
|
*/

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    
    // URL ini adalah standar Sandbox
    'snap_url' => env('MIDTRANS_SNAP_URL', 'https://app.sandbox.midtrans.com/snap/v1/transactions'),
    
    // Path notifikasi (sesuai routes/api.php Anda)
    'notification_url' => env('MIDTRANS_URL_NOTIFICATION', '/api/midtrans-webhook'),
];