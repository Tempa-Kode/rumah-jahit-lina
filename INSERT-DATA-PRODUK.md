# Contoh Lengkap Input Data Produk

## 1️⃣ Resleting (Produk dengan Warna DAN Ukuran)

### Informasi Produk Utama
```
Nama Produk: Resleting
Kategori: Aksesoris Jahit
Harga: 5000 (harga dasar)
Jumlah Stok: 0 (kosongkan)
Min Pembelian: 1
```

### Tambah Variasi
Klik tombol **"Tambah Jenis"** beberapa kali untuk membuat kombinasi warna dan ukuran:

**Varian 1:**
```
Nama Jenis: (kosongkan)
Warna: Hitam
Ukuran: 4 Inch
Harga: 5000
Stok: 50
```

**Varian 2:**
```
Nama Jenis: (kosongkan)
Warna: Hitam
Ukuran: 5 Inch
Harga: 6000
Stok: 40
```

**Varian 3:**
```
Nama Jenis: (kosongkan)
Warna: Hitam
Ukuran: 6 Inch
Harga: 7000
Stok: 30
```

**Varian 4:**
```
Nama Jenis: (kosongkan)
Warna: Hitam
Ukuran: 7 Inch
Harga: 8000
Stok: 20
```

**Varian 5:**
```
Nama Jenis: (kosongkan)
Warna: Biru
Ukuran: 4 Inch
Harga: 5000
Stok: 45
```

... dan seterusnya untuk semua kombinasi warna dan ukuran

### Hasil di Database
Sistem akan auto-generate nama menjadi:
- `Hitam - 4 Inch`
- `Hitam - 5 Inch`
- `Hitam - 6 Inch`
- `Hitam - 7 Inch`
- `Biru - 4 Inch`
- dst...

### Tampilan untuk Pelanggan
```
Pilih Warna:
[●Hitam] [ Biru ]

Pilih Ukuran:
[ 4 Inch ] [ 5 Inch ] [ 6 Inch ] [ 7 Inch ]

Harga: Rp 5.000 - Hitam 4 Inch
Sisa Stok: 50
```

---

## 2️⃣ Rader / Tracking Wheel (Produk dengan HANYA Nama Jenis)

### Informasi Produk Utama
```
Nama Produk: Rader / Tracking Wheel / Alat Pola Jahit
Kategori: Aksesoris Jahit
Harga: 15000
Jumlah Stok: 0
Min Pembelian: 1
```

### Tambah Variasi

**Varian 1:**
```
Nama Jenis: Gerigi
Warna: (kosongkan)
Ukuran: (kosongkan)
Harga: 15000
Stok: 30
Gambar: [upload gambar rader gerigi]
```

**Varian 2:**
```
Nama Jenis: Bulat
Warna: (kosongkan)
Ukuran: (kosongkan)
Harga: 17000
Stok: 25
Gambar: [upload gambar rader bulat]
```

### Hasil di Database
Nama jenis akan tetap:
- `Gerigi`
- `Bulat`

### Tampilan untuk Pelanggan
```
Pilih Variasi:
[●Gerigi] [ Bulat ]

Harga: Rp 15.000
Sisa Stok: 30
```

---

## 3️⃣ Kapur Jahit Kijang Chalk (Produk dengan HANYA Warna)

### Informasi Produk Utama
```
Nama Produk: Kapur Jahit Kijang Chalk
Kategori: Aksesoris Jahit
Harga: 3000
Jumlah Stok: 0
Min Pembelian: 1
```

### Tambah Variasi

**Varian 1:**
```
Nama Jenis: (kosongkan)
Warna: Merah
Ukuran: (kosongkan)
Harga: 3000
Stok: 50
```

**Varian 2:**
```
Nama Jenis: (kosongkan)
Warna: Biru
Ukuran: (kosongkan)
Harga: 3000
Stok: 60
```

**Varian 3:**
```
Nama Jenis: (kosongkan)
Warna: Putih
Ukuran: (kosongkan)
Harga: 3000
Stok: 40
```

**Varian 4:**
```
Nama Jenis: (kosongkan)
Warna: Kuning
Ukuran: (kosongkan)
Harga: 3000
Stok: 35
```

### Hasil di Database
Sistem akan auto-generate nama dari warna:
- `Merah`
- `Biru`
- `Putih`
- `Kuning`

### Tampilan untuk Pelanggan
```
Pilih Warna:
[●Merah] [ Biru ] [ Putih ] [ Kuning ]

Harga: Rp 3.000
Sisa Stok: 50
```

---

## 4️⃣ Penggaris Siku (Produk TANPA Varian)

### Informasi Produk Utama
```
Nama Produk: Penggaris Siku / Penggaris Panggul Mini
Kategori: Aksesoris Jahit
Harga: 12000
Jumlah Stok: 45 ← ISI LANGSUNG DI SINI
Min Pembelian: 1
```

### Tambah Variasi
❌ **TIDAK PERLU** tambah variasi apapun!

Langsung klik **Simpan**

### Tampilan untuk Pelanggan
```
Nama Produk: Penggaris Siku / Penggaris Panggul Mini

Harga: Rp 12.000
Sisa Stok: 45

Jumlah: [1] [-] [+]

[Tambah ke Keranjang]
```

---

## 🎯 Tips Penting

### Kapan Mengisi Stok Produk Utama vs Stok Varian?

✅ **ISI STOK PRODUK UTAMA** jika:
- Produk tidak memiliki varian sama sekali
- Contoh: Penggaris Siku, Gunting Standar

✅ **ISI STOK DI VARIAN** jika:
- Produk memiliki variasi (warna, ukuran, jenis)
- Kosongkan stok produk utama (set 0)
- Contoh: Resleting, Kapur Jahit, Rader

### Auto-Generate Nama Jenis

Sistem akan otomatis generate nama jenis dengan format:
- **Warna + Ukuran**: `"Hitam - 4 Inch"`
- **Hanya Warna**: `"Merah"`
- **Hanya Ukuran**: `"4 Inch"`

Anda bisa **override** auto-generate dengan mengisi manual field "Nama Jenis".

### Mengedit Varian yang Sudah Ada

1. Buka halaman edit produk
2. Scroll ke bagian "Jenis/Variasi Produk Saat Ini"
3. Edit field yang diperlukan
4. Untuk mengubah gambar varian, upload di field "Gambar Baru"
5. Klik **Simpan**

### Menghapus Varian

1. Klik tombol **🗑️ Hapus** di pojok kanan varian
2. Konfirmasi penghapusan
3. Varian akan dihapus permanen

### Menambah Varian Baru pada Produk Existing

1. Buka halaman edit produk
2. Scroll ke bagian "Tambah Jenis/Variasi Baru"
3. Klik tombol **"Tambah Jenis"**
4. Isi data varian baru
5. Klik **Simpan**

---

## 📊 Perbandingan Sistem Lama vs Baru

| Aspek | Sistem Lama | Sistem Baru |
|-------|-------------|-------------|
| Input Nama Jenis | Wajib diisi manual | Opsional, auto-generate |
| Produk hanya warna | Sulit implementasi | Mudah, kosongkan ukuran |
| Produk hanya ukuran | Sulit implementasi | Mudah, kosongkan warna |
| Kombinasi fleksibel | Terbatas | Sangat fleksibel |
| Tampilan pelanggan | Bingung | Jelas & user-friendly |

---

## 🚨 Troubleshooting

**Q: Nama jenis tidak ter-generate otomatis?**
A: Pastikan field warna atau ukuran terisi. Jika keduanya kosong, wajib isi nama jenis manual.

**Q: Stok varian tidak bisa diubah?**
A: Stok varian readonly di form edit. Gunakan fitur "Tambah Stok" di halaman detail produk.

**Q: Varian tidak muncul di halaman pelanggan?**
A: Cek apakah stok varian > 0. Varian dengan stok 0 akan muncul tapi tidak bisa dipilih.

**Q: Gambar varian tidak tampil?**
A: Pastikan format gambar JPG/PNG dan ukuran max 2MB. Jika tidak ada gambar varian, akan gunakan gambar produk utama.

**Q: Error saat simpan produk?**
A: Cek apakah minimal ada 1 field terisi (nama jenis, warna, atau ukuran) di setiap varian. Hapus varian yang semua fieldnya kosong.
