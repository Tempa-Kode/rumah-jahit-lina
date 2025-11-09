<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

@include("partials.dashboard.head")

<body>

    @include("partials.dashboard.sidebar")

    <main class="dashboard-main">
        @include("partials.dashboard.navbar")

        <div class="dashboard-main-body">

            @include("partials.dashboard.breadcrumb")
            <!-- Statistics Cards -->
            <div class="row gy-4 mb-24">
                <!-- Total Produk -->
                <div class="col-xxl-3 col-sm-6">
                    <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-1">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Total Produk</span>
                                    <h6 class="fw-semibold mb-1 text-primary-600">{{ $totalProduk }}</h6>
                                </div>
                                <div
                                    class="w-64-px h-64-px radius-16 bg-primary-600 d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="flowbite:store-outline"
                                        class="text-white text-32"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Customer -->
                <div class="col-xxl-3 col-sm-6">
                    <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Total Customer</span>
                                    <h6 class="fw-semibold mb-1 text-success-600">{{ $totalCustomer }}</h6>
                                    <p class="text-xs mb-0 text-secondary-light">Pelanggan Terdaftar</p>
                                </div>
                                <div
                                    class="w-64-px h-64-px radius-16 bg-success-600 d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="flowbite:users-group-outline"
                                        class="text-white text-32"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Invoice -->
                <div class="col-xxl-3 col-sm-6">
                    <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-3">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Total Invoice</span>
                                    <h6 class="fw-semibold mb-1 text-warning-600">{{ $totalInvoice }}</h6>
                                    <p class="text-xs mb-0 text-secondary-light">
                                        @if ($invoicePending > 0)
                                            <span class="text-warning-600">{{ $invoicePending }} pending</span>
                                        @else
                                            <span class="text-success-600">Tidak ada pending</span>
                                        @endif
                                    </p>
                                </div>
                                <div
                                    class="w-64-px h-64-px radius-16 bg-warning-600 d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="flowbite:cart-outline"
                                        class="text-white text-32"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Pengguna -->
                <div class="col-xxl-3 col-sm-6">
                    <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-4">
                        <div class="card-body p-0">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Total Pengguna</span>
                                    <h6 class="fw-semibold mb-1 text-info-600">{{ $totalPengguna }}</h6>
                                    <p class="text-xs mb-0 text-secondary-light">Admin & Karyawan</p>
                                </div>
                                <div
                                    class="w-64-px h-64-px radius-16 bg-info-600 d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="solar:user-bold" class="text-white text-32"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Stok Produk Rendah -->
            <div class="row gy-4 mb-24">
                <div class="col-12">
                    <div class="card h-100 radius-8 border-0">
                        <div
                            class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                            <h6 class="text-lg fw-semibold mb-0">
                                <iconify-icon icon="solar:danger-triangle-bold-duotone"
                                    class="text-danger-600 me-2"></iconify-icon>
                                Peringatan Stok Produk (≤ 5 Unit)
                            </h6>
                            <span class="badge bg-danger-100 text-danger-600">{{ $stokProduk->count() }} Item</span>
                        </div>
                        <div class="card-body p-24">
                            @if ($stokProduk->count() > 0)
                                <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                                    <iconify-icon icon="solar:info-circle-bold" class="text-warning-600 me-2"
                                        style="font-size: 20px;"></iconify-icon>
                                    <div>
                                        <strong>Perhatian!</strong> Produk-produk berikut memiliki stok ≤ 5 unit. Segera
                                        lakukan restok!
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle mb-0">
                                        <thead class="bg-base">
                                            <tr>
                                                <th class="text-center" style="width: 50px;">No</th>
                                                <th>Nama Produk</th>
                                                <th>Jenis Produk</th>
                                                <th class="text-center" style="width: 150px;">Stok Tersisa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($stokProduk as $index => $item)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>
                                                        <span
                                                            class="fw-semibold text-primary-600">{{ $item["nama_produk"] }}</span>
                                                    </td>
                                                    <td>{{ $item["nama_jenis"] ?? 'Produk Utama'}}</td>
                                                    <td class="text-center">
                                                        <span class="fw-bold text-danger-600" style="font-size: 18px;">
                                                            {{ $item["stok"] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <p class="text-success-600 fw-semibold mt-3 mb-1">Semua Stok Aman!</p>
                                    <p class="text-secondary-light mb-0">Tidak ada produk dengan stok ≤ 5 unit</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Info & Quick Actions -->
            <div class="row gy-4">
                <!-- Detail Login -->
                <div class="col">
                    <div class="card h-100 radius-8 border-0">
                        <div class="card-header border-bottom bg-base py-16 px-24">
                            <h6 class="text-lg fw-semibold mb-0">Detail Login</h6>
                        </div>
                        <div class="card-body p-24">
                            <div class="d-flex align-items-center gap-3 mb-20">
                                <img src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : asset("dashboard/assets/images/user.png") }}"
                                    alt="User" class="rounded-circle"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ Auth::user()->nama }}</h6>
                                    <p class="mb-0 text-sm text-secondary-light">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="px-0 py-2 text-secondary-light" style="width: 140px;">Username
                                            </td>
                                            <td class="px-0 py-2">: {{ Auth::user()->username }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-0 py-2 text-secondary-light">No. HP</td>
                                            <td class="px-0 py-2">: {{ Auth::user()->no_hp ?? "-" }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-0 py-2 text-secondary-light">Alamat</td>
                                            <td class="px-0 py-2">: {{ Auth::user()->alamat ?? "-" }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-0 py-2 text-secondary-light">Role</td>
                                            <td class="px-0 py-2">: <span
                                                    class="badge bg-primary-100 text-primary-600">{{ ucfirst(Auth::user()->role) }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @include("partials.dashboard.footer")
    </main>
    @include("partials.dashboard.scripts")
    <script src="{{ asset("dashboard/assets/js/homeThreeChart.js") }}"></script>

    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Update time every second
        updateTime();
        setInterval(updateTime, 1000);

        // Hover scale effect
        document.querySelectorAll('.hover-scale').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
                this.style.transition = 'transform 0.3s ease';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
</body>

</html>
