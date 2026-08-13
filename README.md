# :rocket: TBooster - Laravel CRUD Generator (Laravel 11+ / PHP 8.2+ Ready)

TBooster adalah versi *fork* dan perbaikan dari [crocodicstudio/crudbooster](https://github.com/crocodicstudio/crudbooster) agar kompatibel penuh dengan versi modern Laravel (diuji sukses hingga **Laravel 13**) dan **PHP 8.2+**.
Kami mempertahankan struktur dan kemudahan penggunaan dari CRUDBooster asli, dengan menambahkan pembaruan dependensi yang sangat modern.

## Cara Instalasi dari GitHub

Karena *package* ini belum tersedia di Packagist, Anda bisa menginstalnya secara langsung melalui repositori GitHub ini menggunakan Composer.

### Langkah 1: Tambahkan Repositori ke `composer.json`
Buka file `composer.json` di *root* proyek Laravel Anda, lalu tambahkan konfigurasi repositori berikut:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/tokalink/tbooster"
    }
],
```

### Langkah 2: Lakukan _Require_ Package
Jalankan perintah berikut di terminal Anda untuk mengunduh versi terbaru dari `main` branch:

```bash
composer require tokalink/tbooster:dev-main
```

### Langkah 3: Publish & Install
Setelah *package* berhasil diinstal, jalankan perintah instalasi CRUDBooster seperti biasa:

```bash
php artisan crudbooster:install
```

Selesai! TBooster sudah siap digunakan di Laravel 11.
