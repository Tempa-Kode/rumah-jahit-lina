<!DOCTYPE html>
<html lang="en" data-theme="light">

@include("partials.dashboard.head")

<body>

    @include("partials.dashboard.sidebar")

    <main class="dashboard-main">
        @include("partials.dashboard.navbar")

        <div class="dashboard-main-body">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Laporan Penjualan</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="{{ route("dashboard.admin") }}"
                            class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Laporan Penjualan</li>
                </ul>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-3 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                    role="alert">
                    <div>
                        <iconify-icon icon="mdi:alert-circle" class="icon text-xl me-2"></iconify-icon>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="remove-button text-danger-600 text-xxl line-height-1">
                        <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                    </button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card h-100 p-0 radius-12">
                        <div class="card-header border-bottom bg-base py-16 px-24">
                            <h6 class="text-lg fw-semibold mb-0">Pilih Periode Laporan</h6>
                        </div>
                        <div class="card-body p-24">
                            <form action="{{ route("laporan.generate") }}" method="POST">
                                @csrf
                                <div class="row gy-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Tanggal Awal <span class="text-danger-600">*</span>
                                        </label>
                                        <input type="date" class="form-control radius-8" name="tanggal_awal"
                                            value="{{ old("tanggal_awal") }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Tanggal Akhir <span class="text-danger-600">*</span>
                                        </label>
                                        <input type="date" class="form-control radius-8" name="tanggal_akhir"
                                            value="{{ old("tanggal_akhir") }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <div
                                            class="alert alert-info bg-info-100 text-info-600 border-info-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-medium text-sm radius-4">
                                            <iconify-icon icon="mdi:information"
                                                class="icon text-lg me-2"></iconify-icon>
                                            Laporan akan menampilkan transaksi dengan status pembayaran
                                            <strong>"Terima"</strong> pada periode yang dipilih.
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                    <button type="reset"
                                        class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-50 py-11 radius-8">
                                        Reset
                                    </button>
                                    <button type="submit"
                                        class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                        <iconify-icon icon="solar:chart-outline"
                                            class="icon text-xl me-2"></iconify-icon>
                                        Buat Laporan
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body p-24">
                            <h6 class="text-md fw-semibold mb-3">Periode Cepat:</h6>
                            <div class="d-flex flex-wrap gap-2 justify-content-around">
                                <button type="button" class="btn btn-outline-primary btn-sm radius-8"
                                    onclick="setToday()">
                                    Hari Ini
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm radius-8"
                                    onclick="setThisWeek()">
                                    Minggu Ini
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm radius-8"
                                    onclick="setThisMonth()">
                                    Bulan Ini
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm radius-8"
                                    onclick="setLastMonth()">
                                    Bulan Lalu
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        @include("partials.dashboard.footer")
    </main>
    @include("partials.dashboard.scripts")

    <script>
        function setToday() {
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('input[name="tanggal_awal"]').value = today;
            document.querySelector('input[name="tanggal_akhir"]').value = today;
        }

        function setThisWeek() {
            const today = new Date();
            const firstDay = new Date(today.setDate(today.getDate() - today.getDay()));
            const lastDay = new Date(today.setDate(today.getDate() - today.getDay() + 6));

            document.querySelector('input[name="tanggal_awal"]').value = firstDay.toISOString().split('T')[0];
            document.querySelector('input[name="tanggal_akhir"]').value = lastDay.toISOString().split('T')[0];
        }

        function setThisMonth() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

            document.querySelector('input[name="tanggal_awal"]').value = firstDay.toISOString().split('T')[0];
            document.querySelector('input[name="tanggal_akhir"]').value = lastDay.toISOString().split('T')[0];
        }

        function setLastMonth() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth(), 0);

            document.querySelector('input[name="tanggal_awal"]').value = firstDay.toISOString().split('T')[0];
            document.querySelector('input[name="tanggal_akhir"]').value = lastDay.toISOString().split('T')[0];
        }
    </script>

</body>

</html>
