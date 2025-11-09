@extends("template")
@section("title", "Konfirmasi Pesanan - Aksesoris Ria")

@section("body")
    <!-- Breakcrumbs -->
    <div class="tf-sp-3 pb-0">
        <div class="container">
            <ul class="breakcrumbs">
                <li><a href="{{ route("home") }}" class="body-small link">Home</a></li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li><span class="body-small">Konfirmasi Pesanan</span></li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <!-- Order Confirmation -->
    <section class="tf-sp-2">
        <div class="container">
            <!-- Success/Error Messages -->
            @if (session("success"))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="icon-check"></i> {{ session("success") }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session("error"))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="icon-close"></i> {{ session("error") }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="checkout-status tf-sp-2 pt-0">
                <div class="checkout-wrap">
                    <span class="checkout-bar complete"></span>
                    <div class="step-payment">
                        <span class="icon">
                            <i class="icon-shop-cart-1"></i>
                        </span>
                        <span class="link body-text-3">Keranjang Belanja</span>
                    </div>
                    <div class="step-payment">
                        <span class="icon">
                            <i class="icon-shop-cart-2"></i>
                        </span>
                        <span class="link body-text-3">Checkout</span>
                    </div>
                    <div class="step-payment active">
                        <span class="icon">
                            <i class="icon-shop-cart-3"></i>
                        </span>
                        <span class="text-secondary body-text-3">Konfirmasi</span>
                    </div>
                </div>
            </div>

            <div class="tf-order-detail">
                <!-- Success Message -->
                <div class="text-center mb-5">
                    <div class="success-icon mb-3">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="40" cy="40" r="40" fill="#28a745" opacity="0.1" />
                            <path d="M25 40L35 50L55 30" stroke="#28a745" stroke-width="4" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="fw-semibold mb-2">Pesanan Berhasil Dibuat!</h3>
                    <p class="text-secondary">Terima kasih atas pesanan Anda</p>
                    <div class="alert alert-success d-inline-block mt-3">
                        <strong>Kode Invoice:</strong> {{ $invoice->kode_invoice }}
                    </div>
                </div>

                <!-- Order Info -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Informasi Pengiriman</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="120"><strong>Nama:</strong></td>
                                        <td>{{ $invoice->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. HP:</strong></td>
                                        <td>{{ $invoice->no_hp }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat:</strong></td>
                                        <td>{{ $invoice->alamat }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Status Pesanan</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Tanggal:</strong></td>
                                        <td>{{ $invoice->tanggal->format("d M Y") }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status Pembayaran:</strong></td>
                                        <td>
                                            @if ($invoice->status_pembayaran == "pending")
                                                <span class="badge bg-warning text-dark">Menunggu Konfirmasi     Pembayaran</span>
                                            @elseif($invoice->status_pembayaran == "terima")
                                                <span class="badge bg-success">Terbayar</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status Pengiriman:</strong></td>
                                        <td>
                                            @if ($invoice->status_pengiriman)
                                                <span class="badge bg-success">Dikirim</span>
                                                @if ($invoice->resi)
                                                    <br><small>Resi: {{ $invoice->resi }}</small>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Belum Dikirim</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Detail Pesanan</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($item->produk->gambarProduk->first())
                                                        <img src="{{ asset($item->produk->gambarProduk->first()->path_gambar) }}"
                                                            alt="{{ $item->produk->nama }}"
                                                            style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                                    @endif
                                                    <div>
                                                        <strong>{{ $item->produk->nama }}</strong>
                                                        @if ($item->jenisProduk)
                                                            <br><small
                                                                class="text-secondary">{{ $item->jenisProduk->nama }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $item->jumlah }}</td>
                                            <td class="text-end">Rp. {{ number_format($item->produk->harga, 0, ",", ".") }}
                                            </td>
                                            <td class="text-end">Rp. {{ number_format($item->subtotal, 0, ",", ".") }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td class="text-end">
                                            <strong class="text-primary fs-5">
                                                Rp. {{ number_format($invoice->total_bayar, 0, ",", ".") }}
                                            </strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions -->
                @if ($invoice->status_pembayaran == "pending")
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Pembayaran</h5>

                            <!-- Upload Payment Proof -->
                            @if (!$invoice->bukti_pembayaran)
                                <h6 class="mt-4 mb-3">Upload Bukti Pembayaran</h6>
                                <form action="{{ route("order.payment.proof", $invoice->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="file" name="bukti_pembayaran" class="form-control"
                                            accept="image/*" required>
                                        <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                                    </div>
                                    <button type="submit" class="tf-btn">
                                        <span class="text-white">Upload Bukti Transfer</span>
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-success mt-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="icon-check me-2"></i>
                                        <strong>Bukti pembayaran sudah diunggah. Menunggu verifikasi admin.</strong>
                                    </div>
                                    <div class="mt-3">
                                        <p class="mb-2"><strong>Preview Bukti Transfer:</strong></p>
                                        <img src="{{ asset($invoice->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                                            class="img-thumbnail" style="max-width: 300px; cursor: pointer;"
                                            onclick="window.open('{{ asset($invoice->bukti_pembayaran) }}', '_blank')">
                                        <p class="small text-muted mt-2">Klik gambar untuk melihat ukuran penuh</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="text-center">
                    <a href="{{ route("home") }}" class="tf-btn btn-gray me-2">
                        <span class="text-white">Kembali ke Beranda</span>
                    </a>
                    @auth
                        <a href="{{ route("akun.pesanan") }}" class="tf-btn">
                            <span class="text-white">Lihat Pesanan Saya</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
    <!-- /Order Confirmation -->
@endsection
