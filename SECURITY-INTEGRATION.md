# Keamanan API dan Integrasi

## Tujuan

API dapat diakses publik untuk aplikasi/web, tetapi juga dapat dipanggil oleh sistem lain secara aman tanpa membocorkan secret ke aplikasi desktop.

## Prinsip akses

### Akses publik

- `POST /api/registrations` tetap menggunakan Google reCAPTCHA.
- reCAPTCHA berfungsi untuk mengurangi spam, bukan sebagai autentikasi.
- Endpoint publik diberi rate limit berbasis IP.

### Akses antar-server

- Sistem lain menggunakan endpoint khusus di bawah `/api/integration/v1/...`.
- Autentikasi menggunakan header:

```http
Authorization: Bearer {INTEGRATION_API_KEY}
```

- `INTEGRATION_API_KEY` hanya disimpan di server API dan server sistem lain.
- Secret tidak boleh ditanam di aplikasi desktop atau frontend.

## Token registrasi

ID angka database tetap digunakan sebagai relasi internal, tetapi tidak lagi digunakan pada URL publik.

Setiap registrasi memiliki `public_token` acak 32 karakter. Migration akan:

1. Menambahkan kolom `public_token`.
2. Mengisi token untuk data registrasi lama.
3. Membuat unique index pada token.
4. Menghasilkan token otomatis untuk registrasi baru.

Endpoint jadwal publik:

```http
GET /api/get-schedule/{token}
```

Response registrasi baru mengembalikan `registration.token`, bukan ID angka.

## Endpoint integrasi yang tersedia

```http
GET /api/integration/v1/registrations/{token}/schedule
Authorization: Bearer {INTEGRATION_API_KEY}
```

Endpoint ini mengambil jadwal berdasarkan token registrasi dan hanya dapat digunakan dengan API key integrasi.

Endpoint integrasi lain belum dibuat karena operasi dan format payload-nya belum ditentukan.

## Rate limit

Rate limiter menggunakan throttler bawaan CodeIgniter dan cache file:

| Endpoint | Batas |
|---|---:|
| `POST /api/registrations` | 10 request/menit/IP |
| `GET /api/check-redundancy` | 30 request/menit/IP |
| `GET /api/get-schedule/*` | 30 request/menit/IP |
| Wilayah dan endpoint integrasi | 120 request/menit/IP |

Jika aplikasi dijalankan pada beberapa server, cache rate limit sebaiknya dipindahkan ke Redis agar counter dibagi bersama.

## Konfigurasi

Tambahkan secret di `.env` server:

```dotenv
INTEGRATION_API_KEY=isi-dengan-secret-acak-yang-kuat
```

Kemudian jalankan migration:

```bash
php spark migrate
```

Gunakan HTTPS di production.

## Dampak ke aplikasi desktop

Aplikasi desktop tidak perlu menyimpan `INTEGRATION_API_KEY`.

Jika desktop masih memanggil endpoint lama seperti:

```http
GET /api/get-schedule/123
```

maka desktop perlu diubah agar memakai token:

```http
GET /api/get-schedule/{token}
```

Perubahan ini hanya diperlukan jika desktop memang memakai endpoint jadwal tersebut. Pemanggilan registrasi publik tetap menggunakan mekanisme reCAPTCHA yang sudah ada.

## Catatan keamanan

- Jangan memakai secret reCAPTCHA sebagai API key integrasi.
- API key integrasi perlu dapat di-rotate jika bocor.
- Jangan mengembalikan ID database atau data sensitif yang tidak dibutuhkan.
- Jika secret pernah masuk Git atau dibagikan, lakukan rotasi.
