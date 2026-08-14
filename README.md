# 🚀 TBooster - Laravel CRUD Generator (AdminLTE 4 & Bootstrap 5 Version)

TBooster (branch `dev-adminlte4`) adalah versi modern dari [crocodicstudio/crudbooster](https://github.com/crocodicstudio/crudbooster) yang telah diperbarui total menggunakan tampilan **AdminLTE 4** dan **Bootstrap 5**, serta kompatibel penuh dengan **Laravel 11+** dan **PHP 8.2+**.

## Cara Instalasi dari GitHub

Gunakan branch `dev-adminlte4` untuk mendapatkan tampilan AdminLTE 4 yang baru.

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

Jalankan perintah berikut di terminal Anda untuk mengunduh branch `dev-adminlte4`:

```bash
composer require tokalink/tbooster:dev-dev-adminlte4
```

### Langkah 3: Publish & Install

Setelah *package* berhasil diinstal, jalankan perintah instalasi CRUDBooster seperti biasa:

```bash
php artisan crudbooster:install
```

Selesai! TBooster sudah siap digunakan di Laravel 11+.
