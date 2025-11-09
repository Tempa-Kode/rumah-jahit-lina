<!DOCTYPE html>
<html lang="en" data-theme="light">

@include("partials.dashboard.head")

<body>

    @include("partials.dashboard.sidebar")

    <main class="dashboard-main">
        @include("partials.dashboard.navbar")

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Preview Laporan Penjualan</h6>
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
                        <a href="{{ route("laporan.index") }}"
                            class="d-flex align-items-center gap-1 hover-text-primary">
                            Laporan Penjualan
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Preview</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="card mb-24 radius-12">
                <div class="card-body p-20">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <h6 class="text-md fw-semibold mb-1">Periode: {{ date("d M Y", strtotime($tanggalAwal)) }} -
                                {{ date("d M Y", strtotime($tanggalAkhir)) }}</h6>
                            <p class="text-sm text-secondary-light mb-0">Total: {{ $totalTransaksi }} Transaksi |
                                Pendapatan: Rp {{ number_format($totalPendapatan, 0, ",", ".") }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route("laporan.index") }}"
                                class="btn btn-sm btn-secondary radius-8 d-inline-flex align-items-center gap-1">
                                <iconify-icon icon="solar:arrow-left-outline" class="text-xl"></iconify-icon>
                                Kembali
                            </a>
                            <form action="{{ route("laporan.print") }}" method="POST" target="_blank" class="d-inline">
                                @csrf
                                <input type="hidden" name="tanggal_awal" value="{{ $tanggalAwal }}">
                                <input type="hidden" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
                                <button type="submit"
                                    class="btn btn-sm btn-warning radius-8 d-inline-flex align-items-center gap-1">
                                    <iconify-icon icon="basil:printer-outline" class="text-xl"></iconify-icon>
                                    Print
                                </button>
                            </form>
                            <form action="{{ route("laporan.pdf") }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="tanggal_awal" value="{{ $tanggalAwal }}">
                                <input type="hidden" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
                                <button type="submit"
                                    class="btn btn-sm btn-success radius-8 d-inline-flex align-items-center gap-1">
                                    <iconify-icon icon="solar:download-linear" class="text-xl"></iconify-icon>
                                    Download PDF
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row gy-4 mb-24">
                <div class="col-xxl-4 col-sm-6">
                    <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-1">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-md">Total Transaksi</span>
                                    <h6 class="fw-semibold mb-1 text-primary-light">{{ $totalTransaksi }}</h6>
                                    <p class="text-sm mb-0 text-secondary-light">Transaksi Berhasil</p>
                                </div>
                                <div
                                    class="w-64-px h-64-px radius-16 bg-primary-600 d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="flowbite:cart-outline"
                                        class="text-white text-32"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-sm-6">
                    <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-md">Total Pendapatan</span>
                                    <h6 class="fw-semibold mb-1 text-success-600">Rp
                                        {{ number_format($totalPendapatan, 0, ",", ".") }}</h6>
                                    <p class="text-sm mb-0 text-secondary-light">Dari Transaksi Terima</p>
                                </div>
                                <div
                                    class="w-64-px h-64-px radius-16 bg-success-600 d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="solar:wallet-bold" class="text-white text-32"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-sm-6">
                    <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-3">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-md">Rata-rata per
                                        Transaksi</span>
                                    <h6 class="fw-semibold mb-1 text-warning-600">Rp
                                        {{ $totalTransaksi > 0 ? number_format($totalPendapatan / $totalTransaksi, 0, ",", ".") : 0 }}
                                    </h6>
                                    <p class="text-sm mb-0 text-secondary-light">Average Order Value</p>
                                </div>
                                <div
                                    class="w-64-px h-64-px radius-16 bg-warning-600 d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="solar:chart-outline" class="text-white text-32"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="card radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Detail Transaksi</h6>
                </div>
                <div class="card-body p-24">
                    @if ($transaksis->count() > 0)
                        <div class="table-responsive">
                            <table class="table bordered-table sm-table mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Kode Invoice</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status Pengiriman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksis as $index => $transaksi)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $transaksi->tanggal->format("d M Y") }}</td>
                                            <td><span
                                                    class="text-primary-600 fw-semibold">{{ $transaksi->kode_invoice }}</span>
                                            </td>
                                            <td>{{ $transaksi->nama }}</td>
                                            <td><span class="text-success-600 fw-semibold">Rp
                                                    {{ number_format($transaksi->total_bayar, 0, ",", ".") }}</span>
                                            </td>
                                            <td>
                                                @if ($transaksi->status_pengiriman)
                                                    <span class="badge bg-success-100 text-success-600 px-20 py-9">Sudah
                                                        Dikirim</span>
                                                @else
                                                    <span class="badge bg-warning-100 text-warning-600 px-20 py-9">Belum
                                                        Dikirim</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-base">
                                        <td colspan="4" class="text-end fw-bold">TOTAL PENDAPATAN:</td>
                                        <td colspan="2"><span class="text-success-600 fw-bold text-lg">Rp
                                                {{ number_format($totalPendapatan, 0, ",", ".") }}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <iconify-icon icon="solar:document-text-outline"
                                class="text-secondary-light text-64"></iconify-icon>
                            <p class="text-secondary-light mt-3">Tidak ada transaksi pada periode ini</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
        @include("partials.dashboard.footer")
    </main>
    @include("partials.dashboard.scripts")

</body>

</html>
