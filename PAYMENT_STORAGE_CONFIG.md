# 📁 Konfigurasi Penyimpanan Bukti Pembayaran

## Lokasi Penyimpanan

Bukti pembayaran akan disimpan di: `public/uploads/payments/`

## Struktur Folder

```
public/
  └── uploads/
      └── payments/
          ├── payment-INV-20251103-ABC123-1699012345.jpg
          ├── payment-INV-20251103-XYZ789-1699012346.png
          └── ...
```

## Format Nama File

```
payment-{kode_invoice}-{timestamp}.{extension}
```

Contoh: `payment-INV-20251103-ABC123-1699012345.jpg`

## Spesifikasi File

-   **Format**: JPG, JPEG, PNG
-   **Ukuran Maksimal**: 2MB
-   **Akses**: Public (dapat diakses langsung via URL)

## Cara Akses File

File dapat diakses langsung melalui URL:

```
https://domain.com/uploads/payments/payment-INV-20251103-ABC123-1699012345.jpg
```

## Fitur yang Ditambahkan

### 1. Auto-Create Directory

Folder `public/uploads/payments/` akan otomatis dibuat jika belum ada dengan permission `0777`.

### 2. Preview Bukti Pembayaran

Setelah upload, customer dapat melihat preview bukti pembayaran di halaman konfirmasi pesanan.

### 3. Validasi Upload

-   Hanya menerima file gambar (JPEG, PNG, JPG)
-   Maksimal ukuran 2MB
-   File akan disimpan dengan nama unik untuk menghindari duplikasi

## Cara Menggunakan

### Upload Bukti Pembayaran

1. Customer membuat pesanan
2. Redirect ke halaman konfirmasi pesanan
3. Klik tombol "Upload Bukti Transfer"
4. Pilih file gambar (JPG/PNG, maks 2MB)
5. Klik submit
6. File tersimpan di `public/uploads/payments/`
7. Preview muncul di halaman konfirmasi

### Akses dari Blade Template

```blade
@if($invoice->bukti_pembayaran)
    <img src="{{ asset($invoice->bukti_pembayaran) }}" alt="Bukti Pembayaran">
@endif
```

### Akses dari Controller

```php
$invoice = Invoice::find($id);
$buktiPath = public_path($invoice->bukti_pembayaran);

// Check if file exists
if (file_exists($buktiPath)) {
    // File exists
}
```

## Database

Path yang disimpan di database adalah relative path:

```
uploads/payments/payment-INV-20251103-ABC123-1699012345.jpg
```

## Keamanan

-   ✅ Validasi tipe file (hanya gambar)
-   ✅ Validasi ukuran file (maks 2MB)
-   ✅ Nama file unik (menggunakan timestamp)
-   ✅ Extension validation
-   ⚠️ File bersifat public (dapat diakses siapa saja yang punya URL)

## Backup & Maintenance

Pastikan folder `public/uploads/payments/` termasuk dalam backup reguler.

## Troubleshooting

### Permission Denied

Jika error permission denied, jalankan:

```bash
chmod -R 777 public/uploads
```

### File Not Found

Pastikan path di database sudah benar (relative path dari public folder).

### Large File Upload

Jika file terlalu besar, cek konfigurasi PHP:

```ini
upload_max_filesize = 2M
post_max_size = 2M
```

## Admin View

Admin dapat melihat bukti pembayaran di dashboard admin untuk verifikasi pembayaran.
