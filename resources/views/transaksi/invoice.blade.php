<!DOCTYPE html>
<html lang="en" data-theme="light">

@include("partials.dashboard.head")

<body>

    @include("partials.dashboard.sidebar")

    <main class="dashboard-main">
        @include("partials.dashboard.navbar")

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Invoice</h6>
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
                    <li class="fw-medium">Invoice</li>
                </ul>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                        <a href="{{ route("transaksi.show", $transaksi->id_invoice) }}"
                            class="btn btn-sm btn-secondary radius-8 d-inline-flex align-items-center gap-1">
                            <iconify-icon icon="solar:arrow-left-outline" class="text-xl"></iconify-icon>
                            Kembali
                        </a>
                        <button type="button"
                            class="btn btn-sm btn-warning radius-8 d-inline-flex align-items-center gap-1"
                            onclick="window.print()">
                            <iconify-icon icon="basil:printer-outline" class="text-xl"></iconify-icon>
                            Print
                        </button>
                    </div>
                </div>
                <div class="card-body py-40">
                    <div class="row justify-content-center" id="invoice">
                        <div class="col-lg-8">
                            <div class="shadow-4 border radius-8">
                                <div class="p-20 d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                    <div>
                                        <h3 class="text-xl">Invoice {{ $transaksi->kode_invoice }}</h3>
                                        <p class="mb-1 text-sm">Tanggal: {{ $transaksi->tanggal->format("d/m/Y") }}</p>
                                        <p class="mb-0 text-sm">Status:
                                            @if ($transaksi->status_pembayaran === "pending")
                                                <span class="text-warning-600 fw-semibold">Pending</span>
                                            @elseif($transaksi->status_pembayaran === "terima")
                                                <span class="text-success-600 fw-semibold">Terima</span>
                                            @else
                                                <span class="text-danger-600 fw-semibold">Tolak</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="text-end">
                                        <p class="mb-1 text-sm fw-semibold">Ria Aksesoris</p>
                                        <p class="mb-1 text-sm">Jl. Flamboyan Raya No.46/B, Tj. Selamat</p>
                                        <p class="mb-0 text-sm">riahmasaragih23@gmail.com, 0813-7097-3874</p>
                                    </div>
                                </div>
                                <div class="py-28 px-20">
                                    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
                                        <div>
                                            <h6 class="text-md mb-2">Invoice Untuk:</h6>
                                            <table class="text-sm text-secondary-light">
                                                <tbody>
                                                    <tr>
                                                        <td>Nama</td>
                                                        <td class="ps-8">: {{ $transaksi->nama }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alamat</td>
                                                        <td class="ps-8">: {{ $transaksi->alamat }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>No. HP</td>
                                                        <td class="ps-8">: {{ $transaksi->no_hp }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div>
                                            <table class="text-sm text-secondary-light">
                                                <tbody>
                                                    <tr>
                                                        <td>Tanggal Invoice</td>
                                                        <td class="ps-8">: {{ $transaksi->tanggal->format("d M Y") }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kode Invoice</td>
                                                        <td class="ps-8">: {{ $transaksi->kode_invoice }}</td>
                                                    </tr>
                                                    @if ($transaksi->resi)
                                                        <tr>
                                                            <td>No. Resi</td>
                                                            <td class="ps-8">: {{ $transaksi->resi }}</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="mt-24">
                                        <div class="table-responsive scroll-sm">
                                            <table class="table bordered-table text-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-sm">No.</th>
                                                        <th scope="col" class="text-sm">Item</th>
                                                        <th scope="col" class="text-sm">Qty</th>
                                                        <th scope="col" class="text-sm">Harga Satuan</th>
                                                        <th scope="col" class="text-end text-sm">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($transaksi->itemTransaksi as $index => $item)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $item->produk->nama }}</td>
                                                            <td>{{ $item->jumlah }}</td>
                                                            <td>Rp {{ number_format($item->produk->harga, 0, ",", ".") }}</td>
                                                            <td class="text-end">Rp
                                                                {{ number_format($item->produk->harga * $item->jumlah, 0, ",", ".") }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex flex-wrap justify-content-between gap-3 mt-3">
                                            <div>
                                                <p class="text-sm mb-0">
                                                    <span class="text-primary-light fw-semibold">Status
                                                        Pengiriman:</span>
                                                    @if ($transaksi->status_pengiriman)
                                                        <span class="text-success-600">Sudah Dikirim</span>
                                                    @else
                                                        <span class="text-warning-600">Belum Dikirim</span>
                                                    @endif
                                                </p>
                                                <p class="text-sm mb-0 mt-2">Terima kasih atas pembelian Anda!</p>
                                            </div>
                                            <div>
                                                <table class="text-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td class="pe-64 border-bottom pb-4">Subtotal:</td>
                                                            <td class="pe-16 border-bottom pb-4 text-end">
                                                                <span class="text-primary-light fw-semibold">
                                                                    Rp
                                                                    {{ number_format($transaksi->total_bayar, 0, ",", ".") }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="pe-64 pt-4">
                                                                <span
                                                                    class="text-primary-light fw-semibold">Total:</span>
                                                            </td>
                                                            <td class="pe-16 pt-4 text-end">
                                                                <span class="text-primary-light fw-bold text-lg">
                                                                    Rp
                                                                    {{ number_format($transaksi->total_bayar, 0, ",", ".") }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-64">
                                        <p class="text-center text-secondary-light text-sm fw-semibold">Terima kasih
                                            atas pembelian Anda!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @include("partials.dashboard.footer")
    </main>
    @include("partials.dashboard.scripts")

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #invoice,
            #invoice * {
                visibility: visible;
            }

            #invoice {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .card-header {
                display: none !important;
            }
        }
    </style>

</body>

</html>
