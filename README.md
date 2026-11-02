# REST Client Berita Indonesia (PHP cURL)

Aplikasi client sederhana berbasis PHP native yang mengonsumsi Public API dari NewsAPI.org menggunakan library cURL untuk menampilkan headline berita terkini di Indonesia.

## Fitur
- Request HTTP GET menggunakan PHP cURL
- JSON parsing ke associative array
- UI responsif menggunakan Bootstrap 4
- Error handling & fallback image handling

## Kebutuhan Sistem
- Web Server (Apache/PHP 7.4+)
- Ekstensi `php-curl` aktif
- Koneksi Internet

## Cara Menjalankan
1. Clone atau tempatkan repository ini di folder web server (`htdocs`).
2. Jalankan Apache di XAMPP.
3. Akses via browser di: `http://localhost/rest-client-newsapi`