# testmfumroh

Soal 1: Merapikan Data Pendaftar Jemaah

Cara Menjalankan

1. Setup Database

php artisan migrate:fresh --seed



 2. Generate Data User ke CSV (Opsional)

php artisan generate:users 1000

File CSV akan tersimpan di `storage/app/users_[timestamp].csv` dengan format:
- Nama (Bahasa Indonesia)
- Email
- Nomor Telepon

 3. Test API Store Subscriber do terminal

curl -X POST http://localhost:8000/subscribers \
  -H "Content-Type: application/json" \
  -d '{
    "nama": "  ahmad suryanto  ",
    "email": "  AHMAD@EXAMPLE.COM  ",
    "no_hp": "(+62) 812-3456-7890"
  }'
```

**Response** (berhasil):
```json
{
  "message": "Subscriber berhasil ditambahkan",
  "data": {
    "id": 1,
    "nama": "Ahmad Suryanto",
    "email": "ahmad@example.com",
    "no_hp": "+62 812-3456-7890",
    "created_at": "2026-07-10T03:05:00Z",
    "updated_at": "2026-07-10T03:05:00Z"
  }
}
```
soal 2

di terminal jalankan php artisan serve
lalu, akses halaman 
http://127.0.0.1:8000/kalkulator

Soal 3: Analisis Data Keberangkatan (CLI Tool)

Program CLI untuk menganalisis data keberangkatan guna membantu divisi marketing (penjualan) dan operasional (logistik) dalam pengambilan keputusan cepat.

Cara Menjalankan di terminal:

    php artisan app:analyze-departures



    1.  Menyaring keberangkatan terdekat yang tingkat keterisiannya (okupansi) masih rendah agar tim marketing dapat segera menerapkan strategi promosi atau diskon harga khusus.
    2.  Menyaring keberangkatan berstatus confirmed yang waktunya sudah dekat agar tim operasional memprioritaskan pemesanan visa, tiket pesawat, dan hotel jemaah.

Soal 4. Bug overbooking

1. Pada sistem web dengan banyak pengguna (concurrent), beberapa request bisa masuk pada milidetik yang hampir bersamaan.

2.Cara Menjalankannya

node test-concurrency.js di terminal

Hasil Keluaran Eksekusi
Saat dijalankan, terminal akan langsung menunjukkan perbedaan nyata sebelum dan sesudah perbaikan

