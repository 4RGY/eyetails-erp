<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Midtrans') }}
          </h2>
      </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-medium">Selesaikan Pembayaran Pesanan #{{ $order->id }}</h3>
                    <p class="mb-2">Total yang harus dibayar:</p>
                    <p class="text-3xl font-bold mb-4">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                      </p>

                    <p class="mb-4">Klik tombol di bawah untuk membuka jendela pembayaran dan memilih metode (QRIS, VA,
            dll).</p>

                    <button id="pay-button"            
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Bayar dengan Midtrans
                      </button>
                  </div>
              </div>
          </div>
      </div>

  <!-- ========================================================== -->
  <!-- FIX 1: Gunakan config() BUKAN env() -->
  <!-- Ini membutuhkan file 'config/midtrans.php' -->
  <!-- ========================================================== -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"    
    data-client-key="{{ config('midtrans.client_key') }}"></script>
  <!-- ========================================================== -->

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
      // Nonaktifkan tombol untuk mencegah klik ganda
      this.disabled = true; 

        snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            alert("Pembayaran Berhasil! Status akan segera diperbarui.");
            // ==========================================================
            // REKOMENDASI: Redirect ke detail order ('riwayat.show')
            // Sesuai routes/web.php Anda [cite: uploaded:routes/web.php]
            // ==========================================================
            window.location.href = '{{ route("riwayat.show", $order->id) }}'; 
          },
          onPending: function(result){
            alert("Pembayaran Anda Tertunda. Cek status di Riwayat Pesanan.");
            // REKOMENDASI: Redirect ke detail order ('riwayat.show')
            window.location.href = '{{ route("riwayat.show", $order->id) }}';
          },
          onError: function(result){
            alert("Pembayaran Gagal. Silakan coba lagi.");
            // REKOMENDASI: Redirect ke detail order ('riwayat.show')
            window.location.href = '{{ route("riwayat.show", $order->id) }}';
          },
          onClose: function(){
            alert('Anda menutup popup. Pesanan menunggu pembayaran.');
            // Biarkan di halaman ini agar user bisa klik "Bayar" lagi jika mau
            this.disabled = false; // Aktifkan lagi tombolnya
          }
        });
      };
  
  </script>
</x-app-layout>