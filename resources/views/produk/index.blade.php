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
                <h6 class="fw-semibold mb-0">Data Produk</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="{{ route("dashboard.admin") }}"
                            class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Data Produk</li>
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
                <div
                    class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-end">
                    <a href="{{ route("produk.create") }}"
                        class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Tambah Produk
                    </a>
                </div>
                <div class="card-body p-24">
                    <div class="table-responsive scroll-sm">
                        <table id="dataTable" class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Nama Produk</th>
                                    <th scope="col" class="text-center">Kategori</th>
                                    <th scope="col" class="text-center">Harga</th>
                                    <th scope="col" class="text-center">Jumlah</th>
                                    <th scope="col" class="text-center">Foto</th>
                                    <th scope="col" class="text-center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produks as $index => $produk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <span
                                                class="text-md mb-0 fw-semibold text-primary-light">{{ $produk->nama }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge text-sm fw-semibold text-secondary-light bg-secondary-50 px-20 py-9 radius-4">
                                                {{ $produk->kategori->nama ?? "-" }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-md mb-0 fw-semibold text-success-600">Rp
                                                {{ number_format($produk->harga, 0, ",", ".") }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $totalStok = $produk->jumlah_produk ?? 0;
                                                $totalStok += $produk->jenisProduk->sum("jumlah_produk");
                                            @endphp
                                            <span
                                                class="text-md mb-0 fw-normal text-secondary-light">{{ $totalStok }}</span>
                                        </td>
                                        <td>
                                            @if ($produk->gambarProduk->first())
                                                <img src="{{ asset($produk->gambarProduk->first()->path_gambar) }}"
                                                    alt="{{ $produk->nama }}"
                                                    class="w-60-px h-60-px rounded object-fit-cover">
                                            @else
                                                <img src="{{ asset("dashboard/assets/images/product.png") }}"
                                                    alt="{{ $produk->nama }}"
                                                    class="w-60-px h-60-px rounded object-fit-cover">
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                                <a href="{{ route("detail-produk", $produk->id_produk) }}"
                                                    class="bg-info-focus text-info-600 bg-hover-info-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                    title="Detail">
                                                    <iconify-icon icon="solar:eye-bold"
                                                        class="menu-icon"></iconify-icon>
                                                </a>
                                                <a href="{{ route("produk.edit", $produk->id_produk) }}"
                                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                    title="Edit">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </a>
                                                <form action="{{ route("produk.destroy", $produk->id_produk) }}"
                                                    method="POST" class="delete-form" data-name="{{ $produk->nama }}">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="button"
                                                        class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle btn-delete"
                                                        title="Hapus">
                                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        @include("partials.dashboard.footer")
    </main>
    @include("partials.dashboard.scripts")

    <script>
        $(document).ready(function() {
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                const form = $(this).closest('.delete-form');
                const produkName = form.data('name');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Produk "${produkName}" dan semua data terkait akan dihapus permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>

</html>
