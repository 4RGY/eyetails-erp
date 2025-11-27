# EYETAILS.CO

**EYETAILS.CO** adalah platform e-commerce berbasis Laravel yang menyediakan pengalaman belanja lengkap — dari katalog produk, keranjang, checkout, hingga manajemen pesanan dan admin panel yang kuat.

---

## Table of Contents

* [About the Project](#about-the-project)
* [Features](#features)
* [Built With](#built-with)
* [Getting Started](#getting-started)

  * [Prerequisites](#prerequisites)
  * [Installation](#installation)
* [Usage](#usage)
* [Admin Access](#admin-access)
* [Contributing](#contributing)
* [License](#license)
* [Contact](#contact)

---

## About the Project

EYETAILS.CO dikembangkan untuk memberikan solusi toko online yang fleksibel, modern, dan mudah diatur. Proyek ini mencakup sistem frontend untuk pelanggan serta backend untuk pengelolaan toko oleh admin.

---

## Features

### 🛍️ User Side

* **Authentication** (Register, Login, Google OAuth)
* **Product Catalog** with category filters and detail pages
* **Shopping Cart** with session-based management
* **Smooth Checkout** flow with shipping & payment options
* **Order History** and live order tracking
* **Wishlist & Product Reviews**
* **Return Requests**
* **Live Chat Support**
* **Blog/Articles Page**

### ⚙️ Admin Panel

* **Dashboard Analytics** with sales overview
* **Product Management** (CRUD, multi-image upload, variants)
* **Order Management** (status updates, tracking number)
* **User Management**
* **Category & Promotion Management**
* **Blog/Content Management**
* **Shipping & Payment Settings**
* **Sales Reports & Email Campaigns**
* **Global Settings Configuration**

---

## Built With

* [Laravel 10](https://laravel.com/)
* [Blade Template Engine](https://laravel.com/docs/10.x/blade)
* [Alpine.js](https://alpinejs.dev/)
* [MySQL](https://www.mysql.com/)
* [Swiper.js](https://swiperjs.com/)
* [Laravel Socialite](https://laravel.com/docs/10.x/socialite)

---

## Getting Started

### Prerequisites

Pastikan Anda memiliki:

* PHP ≥ 8.1
* Composer
* Node.js & NPM
* Database server (MySQL/MariaDB)

### Installation

1. **Clone repository**

   ```bash
   git clone [URL_REPOSITORY_ANDA]
   cd eyetails_erp
   ```

2. **Install dependencies**

   ```bash
   composer install
   npm install
   ```

3. **Set environment**

   ```bash
   cp .env.example .env
   ```

   Sesuaikan pengaturan database Anda:

   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=eyetails_erp
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate application key**

   ```bash
   php artisan key:generate
   ```

5. **Run migrations and seeders**

   ```bash
   php artisan migrate --seed
   ```

6. **Create storage symlink**

   ```bash
   php artisan storage:link
   ```

7. **Compile assets**

   ```bash
   npm run dev
   ```

8. **Start local server**

   ```bash
   php artisan serve
   ```

Akses aplikasi di:
👉 `http://127.0.0.1:8000`

---

## Usage

Setelah instalasi berhasil:

* Pengguna dapat menjelajahi katalog produk, menambahkan ke keranjang, checkout, dan memantau status pesanan.
* Admin dapat login ke `/admin/dashboard` untuk mengelola produk, pesanan, pengguna, promosi, dan konten lainnya.

---

## Admin Access

Akun admin default (setelah `php artisan migrate --seed`):

```
Email: admin@eyetails.co
Password: password
```

---

## Contributing

Kontribusi selalu terbuka!
Untuk berkontribusi:

1. Fork repository ini.
2. Buat branch baru: `git checkout -b feature/AmazingFeature`.
3. Commit perubahan Anda: `git commit -m 'Add some AmazingFeature'`.
4. Push ke branch: `git push origin feature/AmazingFeature`.
5. Buat **Pull Request**.

---

## License

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

## Contact

**EYETAILS.CO**
Website: [https://eyetails.co](https://eyetails.co)
Email: [admin@eyetails.co](mailto:admin@eyetails.co) 

Project Link: [https://github.com/yourusername/eyetails_erp](https://github.com/4RGY/eyetails_erp)
