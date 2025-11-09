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
                <h6 class="fw-semibold mb-0">Data Transaksi</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="{{ route("dashboard.admin") }}"
                            class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Data Transaksi</li>
                </ul>
            </div>

            @if (session("success"))
                <div class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
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

            @if (session("error"))
                <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                    role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="mdi:alert-circle" class="icon text-xl"></iconify-icon>
                        {{ session("error") }}
                    </div>
                    <button class="remove-button text-danger-600 text-xxl line-height-1">
                        <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                    </button>
                </div>
            @endif

            <div class="card h-100 p-0 radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="text-lg fw-semibold mb-0">Daftar Transaksi</h6>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route("transaksi.index") }}" method="GET" class="d-flex gap-2">
                                <input type="text" name="search" class="form-control radius-8"
                                    placeholder="Cari kode invoice atau nama..." value="{{ request("search") }}">
                                <button type="submit" class="btn btn-primary radius-8">
                                    <iconify-icon icon="mingcute:search-line"></iconify-icon>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body p-24">
                    <!-- Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form action="{{ route("transaksi.index") }}" method="GET" id="filterForm">
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <select name="status_pembayaran" class="form-select radius-8"
                                            onchange="this.form.submit()">
                                            <option value="">Semua Status Pembayaran</option>
                                            <option value="pending"
                                                {{ request("status_pembayaran") == "pending" ? "selected" : "" }}>
                                                Pending</option>
                                            <option value="terima"
                                                {{ request("status_pembayaran") == "terima" ? "selected" : "" }}>Terima
                                            </option>
                                            <option value="tolak"
                                                {{ request("status_pembayaran") == "tolak" ? "selected" : "" }}>Tolak
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="status_pengiriman" class="form-select radius-8"
                                            onchange="this.form.submit()">
                                            <option value="">Semua Status Pengiriman</option>
                                            <option value="0"
                                                {{ request("status_pengiriman") === "0" ? "selected" : "" }}>Belum
                                                Dikirim</option>
                                            <option value="1"
                                                {{ request("status_pengiriman") === "1" ? "selected" : "" }}>Sudah
                                                Dikirim</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        @if (request("status_pembayaran") || request("status_pengiriman") || request("search"))
                                            <a href="{{ route("transaksi.index") }}"
                                                class="btn btn-secondary radius-8">
                                                Reset Filter
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col">Kode Invoice</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status Pembayaran</th>
                                    <th scope="col">Status Pengiriman</th>
                                    <th scope="col" class="text-center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $index => $transaksi)
                                    <tr>
                                        <td class="text-center">{{ $transaksis->firstItem() + $index }}</td>
                                        <td>
                                            <span
                                                class="text-md fw-semibold text-primary-light">{{ $transaksi->kode_invoice }}</span>
                                        </td>
                                        <td>{{ $transaksi->tanggal->format("d M Y") }}</td>
                                        <td>{{ $transaksi->nama }}</td>
                                        <td>
                                            <span class="text-success-600 fw-semibold">Rp
                                                {{ number_format($transaksi->total_bayar, 0, ",", ".") }}</span>
                                        </td>
                                        <td>
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
                                        </td>
                                        <td>
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
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                                <a href="{{ route("transaksi.show", $transaksi->id_invoice) }}"
                                                    class="bg-info-focus text-info-600 bg-hover-info-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                    title="Detail">
                                                    <iconify-icon icon="solar:eye-bold"
                                                        class="menu-icon"></iconify-icon>
                                                </a>
                                                <a href="{{ route("transaksi.invoice", $transaksi->id_invoice) }}"
                                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                    title="Download Invoice">
                                                    <iconify-icon icon="solar:download-linear"
                                                        class="menu-icon"></iconify-icon>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <span class="text-secondary-light">Tidak ada data transaksi</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
                        <span>Showing {{ $transaksis->firstItem() ?? 0 }} to {{ $transaksis->lastItem() ?? 0 }} of
                            {{ $transaksis->total() }} entries</span>
                        <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                            {{ $transaksis->links() }}
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        @include("partials.dashboard.footer")
    </main>
    @include("partials.dashboard.scripts")

</body>

</html>
