<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

@include("partials.dashboard.head")

<body>

    @include("partials.dashboard.sidebar")

    <main class="dashboard-main">
        @include("partials.dashboard.navbar")

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Detail Transaksi</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="{{ route("dashboard.admin") }}"
                            class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">
                        <a href="{{ route("transaksi.index") }}"
                            class="d-flex align-items-center gap-1 hover-text-primary">
                            Data Transaksi
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Detail</li>
                </ul>
            </div>

            @if (session("success"))
                <div class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                    role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                        {{ session("success") }}
                    </div>
                    <button class="remove-button text-success-600 text-xxl line-height-1">
                        <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                    </button>
                </div>
            @endif

            <div class="row gy-4">
                <!-- Info Transaksi -->
                <div class="col-lg-8">
                    <div class="card mb-24">
                        <div class="card-header border-bottom">
                            <h6 class="fw-semibold mb-0">Informasi Transaksi</h6>
                        </div>
                        <div class="card-body p-24">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-semibold text-secondary-light mb-2">Kode Invoice:</label>
                                    <p class="mb-0 fw-bold text-primary-600">{{ $transaksi->kode_invoice }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-semibold text-secondary-light mb-2">Tanggal:</label>
                                    <p class="mb-0">{{ $transaksi->tanggal->format("d F Y") }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-semibold text-secondary-light mb-2">Nama Customer:</label>
                                    <p class="mb-0">{{ $transaksi->nama }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-semibold text-secondary-light mb-2">No. HP:</label>
                                    <p class="mb-0">{{ $transaksi->no_hp }}</p>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="fw-semibold text-secondary-light mb-2">Alamat Pengiriman:</label>
                                    <p class="mb-0">{{ $transaksi->alamat }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-semibold text-secondary-light mb-2">Total Bayar:</label>
                                    <p class="mb-0 fw-bold text-success-600">Rp
                                        {{ number_format($transaksi->total_bayar, 0, ",", ".") }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-semibold text-secondary-light mb-2">No. Resi:</label>
                                    <p class="mb-0">{{ $transaksi->resi ?? "-" }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item Transaksi -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom">
                            <h6 class="fw-semibold mb-0">Detail Pesanan</h6>
                        </div>
                        <div class="card-body p-24">
                            <div class="table-responsive">
                                <table class="table bordered-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksi->itemTransaksi as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        @if ($item->produk->gambarProduk->first())
                                                            <img src="{{ asset($item->produk->gambarProduk->first()->path_gambar) }}"
                                                                alt="{{ $item->produk->nama }}"
                                                                class="w-40-px h-40-px rounded object-fit-cover">
                                                        @endif
                                                        <span>{{ $item->produk->nama }}</span>
                                                    </div>
                                                </td>
                                                <td>Rp {{ number_format($item->produk->harga, 0, ",", ".") }}</td>
                                                <td>{{ $item->jumlah }}</td>
                                                <td class="fw-semibold">Rp
                                                    {{ number_format($item->produk->harga * $item->jumlah, 0, ",", ".") }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-base">
                                            <td colspan="3" class="text-end fw-bold">TOTAL:</td>
                                            <td class="fw-bold text-success-600">Rp
                                                {{ number_format($transaksi->total_bayar, 0, ",", ".") }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Panel -->
                <div class="col-lg-4">
                    <!-- Status Pembayaran -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom bg-primary-50">
                            <h6 class="fw-semibold mb-0">Validasi Pembayaran</h6>
                        </div>
                        <div class="card-body p-24">
                            <div class="mb-3">
                                <label class="fw-semibold text-secondary-light mb-2">Status Saat Ini:</label>
                                @if ($transaksi->status_pembayaran === "pending")
                                    <span
                                        class="badge text-sm fw-semibold text-warning-600 bg-warning-100 px-20 py-9 radius-4">
                                        Pending
                                    </span>
                                @elseif($transaksi->status_pembayaran === "terima")
                                    <span
                                        class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4">
                                        Terima
                                    </span>
                                @else
                                    <span
                                        class="badge text-sm fw-semibold text-danger-600 bg-danger-100 px-20 py-9 radius-4">
                                        Tolak
                                    </span>
                                @endif
                            </div>

                            @if ($transaksi->bukti_pembayaran)
                                <div class="mb-3">
                                    <label class="fw-semibold text-secondary-light mb-2">Bukti Pembayaran:</label>
                                    <img src="{{ asset($transaksi->bukti_pembayaran) }}" alt="Bukti Pembayaran"
                                        class="w-100 rounded border" style="cursor: pointer;"
                                        onclick="window.open('{{ asset($transaksi->bukti_pembayaran) }}', '_blank')">
                                </div>
                            @endif

                            <form action="{{ route("transaksi.validate-payment", $transaksi->id_invoice) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Update Status Pembayaran
                                    </label>
                                    <select class="form-select radius-8" name="status_pembayaran" required>
                                        <option value="">Pilih Status</option>
                                        <option value="pending"
                                            {{ $transaksi->status_pembayaran === "pending" ? "selected" : "" }}>Pending
                                        </option>
                                        <option value="terima"
                                            {{ $transaksi->status_pembayaran === "terima" ? "selected" : "" }}>Terima
                                        </option>
                                        <option value="tolak"
                                            {{ $transaksi->status_pembayaran === "tolak" ? "selected" : "" }}>Tolak
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 radius-8">
                                    Update Status Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Status Pengiriman -->
                    <div class="card mb-24">
                        <div class="card-header border-bottom bg-success-50">
                            <h6 class="fw-semibold mb-0">Informasi Pengiriman</h6>
                        </div>
                        <div class="card-body p-24">
                            <div class="mb-3">
                                <label class="fw-semibold text-secondary-light mb-2">Status Saat Ini:</label>
                                @if ($transaksi->status_pengiriman)
                                    <span
                                        class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4">
                                        Sudah Dikirim
                                    </span>
                                @else
                                    <span
                                        class="badge text-sm fw-semibold text-warning-600 bg-warning-100 px-20 py-9 radius-4">
                                        Belum Dikirim
                                    </span>
                                @endif
                            </div>

                            <form action="{{ route("transaksi.update-shipping", $transaksi->id_invoice) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Nomor Resi <span class="text-danger-600">*</span>
                                    </label>
                                    <input type="text" class="form-control radius-8" name="resi"
                                        value="{{ $transaksi->resi }}" placeholder="Masukkan nomor resi" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Status Pengiriman
                                    </label>
                                    <select class="form-select radius-8" name="status_pengiriman" required>
                                        <option value="">Pilih Status</option>
                                        <option value="0" {{ !$transaksi->status_pengiriman ? "selected" : "" }}>
                                            Belum Dikirim</option>
                                        <option value="1" {{ $transaksi->status_pengiriman ? "selected" : "" }}>
                                            Sudah Dikirim</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success w-100 radius-8">
                                    Update Pengiriman
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3">
                <a href="{{ route("transaksi.index") }}" class="btn btn-secondary px-24 py-12 radius-8">
                    <iconify-icon icon="solar:arrow-left-outline" class="icon"></iconify-icon>
                    Kembali
                </a>
                <a href="{{ route("transaksi.invoice", $transaksi->id_invoice) }}"
                    class="btn btn-success px-24 py-12 radius-8">
                    <iconify-icon icon="solar:download-linear" class="icon"></iconify-icon>
                    Download Invoice
                </a>
            </div>

        </div>
        @include("partials.dashboard.footer")
    </main>
    @include("partials.dashboard.scripts")

</body>

</html>
