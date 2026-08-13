# :rocket: TBooster - Laravel CRUD Generator (Laravel 11 / PHP 8.3 Ready)

TBooster adalah versi *fork* dan perbaikan dari CRUDBooster agar kompatibel penuh dengan **Laravel 11** dan **PHP 8.3**.

## Cara Instalasi dari GitHub

Karena *package* ini belum tersedia atau diperbarui di Packagist, Anda bisa menginstalnya secara langsung melalui repositori GitHub ini menggunakan Composer.

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
composer require crocodicstudio/crudbooster:dev-main
```

### Langkah 3: Publish & Install
Setelah *package* berhasil diinstal, jalankan perintah instalasi CRUDBooster seperti biasa:

```bash
php artisan crudbooster:install
```

Selesai! TBooster sudah siap digunakan di Laravel 11.
