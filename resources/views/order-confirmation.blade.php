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
                    <p class="text-primary">Terima kasih atas pesanan Anda</p>
                    <div class="alert alert-success d-inline-block mt-3">
                        <strong>Kode Invoice:</strong> {{ $invoice->kode_invoice }}
                    </div>
                </div>

                <!-- Order Info -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="add-comment-wrap">
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
                                        <tr>
                                            <td><strong>Layanan Kurir:</strong></td>
                                            <td>{{ $invoice->kurir }}</td>
                                        </tr>
                                    </table>
                                </div>
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
                                                <span class="badge bg-warning text-dark">Belum Bayar</span>
                                            @elseif($invoice->status_pembayaran == "terima")
                                                <span class="badge bg-success">Lunas</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status Pengiriman:</strong></td>
                                        <td>
                                            @if ($invoice->status_pengiriman == "dikirim")
                                                <span class="badge bg-info">Dikirim</span>
                                                @if ($invoice->resi)
                                                    <br><small>Resi: {{ $invoice->resi }}</small>
                                                @endif
                                            @elseif ($invoice->status_pengiriman == "diterima")
                                                <span class="badge bg-success">Diterima</span>
                                                @if ($invoice->resi)
                                                    <br><small>Resi: {{ $invoice->resi }}</small>
                                                @endif
                                            @elseif ($invoice->status_pengiriman == "dibatalkan")
                                                <span class="badge bg-danger">Dibatalkan</span>
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
                        <h5 class="card-title mb-3" id="detail">Detail Pesanan</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                        @if ($invoice->status_pengiriman == "diterima")
                                            <th class="text-center">Aksi</th>
                                        @endif
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
                                                            <br>
                                                            <small class="text-muted fst-italic">
                                                                {{ $item->jenisProduk->nama }}
                                                                @if ($item->jenisProduk->warna)
                                                                    - {{ $item->jenisProduk->warna }}
                                                                @endif
                                                                @if ($item->jenisProduk->ukuran)
                                                                    - {{ $item->jenisProduk->ukuran }}
                                                                @endif
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $item->jumlah }}</td>
                                            <td class="text-end">Rp. {{ number_format($item->produk->harga, 0, ",", ".") }}
                                            </td>
                                            <td class="text-end">Rp. {{ number_format($item->subtotal, 0, ",", ".") }}</td>
                                            @if ($invoice->status_pengiriman == "diterima")
                                                <td class="text-center">
                                                    @php
                                                        $userReview = $userReviews[$item->produk_id] ?? null;
                                                    @endphp
                                                    @if ($userReview)
                                                        <div class="d-flex flex-column gap-1">
                                                            <span class="badge bg-success mb-1">Sudah Dinilai</span>
                                                            <div class="mb-1">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <i class="icon-star {{ $i <= $userReview->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 0.8rem;"></i>
                                                                @endfor
                                                            </div>
                                                            <a href="{{ route('ulasan.form', $item->produk->id_produk) }}" class="btn btn-sm btn-outline-primary">
                                                                Edit Ulasan
                                                            </a>
                                                        </div>
                                                    @else
                                                        <a href="{{ route('ulasan.form', $item->produk->id_produk) }}" class="btn btn-info text-white btn-sm">
                                                            Nilai Produk
                                                        </a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Ongkir:</strong></td>
                                        <td class="text-end">
                                            Rp. {{ number_format($invoice->ongkir, 0, ",", ".") }}
                                        </td>
                                    </tr>
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
{{--                @if ($invoice->status_pembayaran == "pending")--}}
{{--                    <div class="card mb-4">--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title mb-3">Pembayaran</h5>--}}

{{--                            <!-- Upload Payment Proof -->--}}
{{--                            @if (!$invoice->bukti_pembayaran)--}}
{{--                                <h6 class="mt-4 mb-3">Upload Bukti Pembayaran</h6>--}}
{{--                                <form action="{{ route("order.payment.proof", $invoice->id) }}" method="POST"--}}
{{--                                    enctype="multipart/form-data">--}}
{{--                                    @csrf--}}
{{--                                    <div class="mb-3">--}}
{{--                                        <input type="file" name="bukti_pembayaran" class="form-control"--}}
{{--                                            accept="image/*" required>--}}
{{--                                        <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>--}}
{{--                                    </div>--}}
{{--                                    <button type="submit" class="tf-btn">--}}
{{--                                        <span class="text-white">Upload Bukti Transfer</span>--}}
{{--                                    </button>--}}
{{--                                </form>--}}
{{--                            @else--}}
{{--                                <div class="alert alert-success mt-3">--}}
{{--                                    <div class="d-flex align-items-center mb-2">--}}
{{--                                        <i class="icon-check me-2"></i>--}}
{{--                                        <strong>Bukti pembayaran sudah diunggah. Menunggu verifikasi admin.</strong>--}}
{{--                                    </div>--}}
{{--                                    <div class="mt-3">--}}
{{--                                        <p class="mb-2"><strong>Preview Bukti Transfer:</strong></p>--}}
{{--                                        <img src="{{ asset($invoice->bukti_pembayaran) }}" alt="Bukti Pembayaran"--}}
{{--                                            class="img-thumbnail" style="max-width: 300px; cursor: pointer;"--}}
{{--                                            onclick="window.open('{{ asset($invoice->bukti_pembayaran) }}', '_blank')">--}}
{{--                                        <p class="small text-muted mt-2">Klik gambar untuk melihat ukuran penuh</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}

                <!-- Action Buttons -->
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route("home") }}" class="tf-btn btn-gray w-25">
                        <span class="text-white">Kembali ke Beranda</span>
                    </a>
                    @if ($invoice->status_pembayaran == "pending")
                        <button
                            class="btn btn-success"
                            id="bayar"
                            data-id-invoice="{{ $invoice->id_invoice }}"
                            data-total-bayar="{{ $invoice->total_bayar }}"
                        >
                            Lakukan Pembayaran
                        </button>
                    @endif
                    @auth
                        <a href="{{ route("akun.pesanan") }}" class="tf-btn w-25">
                            <span class="text-white">Lihat Pesanan Saya</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
    <!-- /Order Confirmation -->
@endsection

@push('scripts')
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // Set environment untuk sandbox
            if (typeof snap !== 'undefined') {
                snap.environment = 'sandbox';
            }

            $('#bayar').on('click', function () {
                const payButton = $(this);
                const id_invoice = payButton.data('id-invoice');
                const total_bayar = payButton.data('total-bayar');

                payButton.prop('disabled', true).text('Memproses...');

                $.ajax({
                    url: '{{ route("pembayaran.bayar") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id_invoice: id_invoice,
                        total_bayar: total_bayar
                    },
                    success: function(response) {
                        if (!response.snap_token) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Gagal mendapatkan token pembayaran. Silakan coba lagi.',
                            });
                            payButton.prop('disabled', false).html('<i class="fa-solid fa-money-bill"></i> Bayar');
                            return;
                        }

                        // Pastikan snap loaded sebelum digunakan
                        if (typeof snap === 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Midtrans Snap belum termuat. Silakan refresh halaman.',
                            });
                            payButton.prop('disabled', false).html('<i class="fa-solid fa-money-bill"></i> Bayar');
                            return;
                        }

                        snap.pay(response.snap_token, {
                            onSuccess: function(result){
                                console.log('Success:', result);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pembayaran Berhasil!',
                                    text: 'Terima kasih, pembayaran Anda telah kami terima.',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    updateStatus(result.order_id);
                                });
                            },
                            onPending: function(result){
                                console.log('Pending:', result);
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Menunggu Pembayaran',
                                    text: 'Selesaikan pembayaran Anda sesuai instruksi yang diberikan.',
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            onError: function(result){
                                console.log('Error:', result);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Pembayaran Gagal',
                                    text: 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.'
                                });
                                payButton.prop('disabled', false).html('<i class="fa-solid fa-money-bill"></i> Bayar');
                            },
                            onClose: function(){
                                console.log('Popup ditutup oleh pengguna.');
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Dibatalkan',
                                    text: 'Anda menutup jendela pembayaran sebelum selesai.'
                                });
                                payButton.prop('disabled', false).html('<i class="fa-solid fa-money-bill"></i> Bayar');
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Koneksi Gagal',
                            text: 'Tidak dapat terhubung ke server. Periksa koneksi internet Anda.'
                        });
                        payButton.prop('disabled', false).html('<i class="fa-solid fa-money-bill"></i> Bayar');
                    }
                });

                function updateStatus($order_id){
                    console.log($order_id)
                    $.ajax({
                        url: '{{ route("pembayaran.cek-status") }}',
                        method: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT',
                            kode_invoice : $order_id
                        },
                        success: function(response) {
                            window.location.href = '{{ route("akun.pesanan") }}';
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal memperbarui status pembayaran. Silakan hubungi admin.'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
