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
                <h6 class="fw-semibold mb-0">Data Admin</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="{{ route("dashboard.admin") }}"
                            class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Data Admin</li>
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

            <div class="card h-100 p-0 radius-12">
                <div
                    class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-end">
                    <a href="{{ route("admin.create") }}"
                        class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Tambah Admin
                    </a>
                </div>
                <div class="card-body p-24">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">No HP</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admins as $admin)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($admin->foto)
                                                <img src="{{ asset($admin->foto) }}" alt="{{ $admin->nama }}"
                                                    class="w-40-px h-40-px rounded-circle object-fit-cover">
                                            @else
                                                <img src="{{ asset("dashboard/assets/images/user.png") }}"
                                                    alt="{{ $admin->nama }}"
                                                    class="w-40-px h-40-px rounded-circle object-fit-cover">
                                            @endif
                                        </td>
                                        <td>
                                            <span
                                                class="text-md mb-0 fw-normal text-secondary-light">{{ $admin->nama }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-md mb-0 fw-normal text-secondary-light">{{ $admin->username }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-md mb-0 fw-normal text-secondary-light">{{ $admin->email }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-md mb-0 fw-normal text-secondary-light">{{ $admin->no_hp }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                                <a href="{{ route("admin.edit", $admin->id_user) }}"
                                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </a>
                                                <form action="{{ route("admin.destroy", $admin->id_user) }}" method="POST"
                                                    class="delete-form" data-name="{{ $admin->nama }}">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="button"
                                                        class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle btn-delete">
                                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <span class="text-secondary-light">Tidak ada data admin</span>
                                        </td>
                                    </tr>
                                @endforelse
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
                const adminName = form.data('name');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Data admin "${adminName}" akan dihapus permanen!`,
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
