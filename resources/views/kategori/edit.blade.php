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
                <h6 class="fw-semibold mb-0">Edit Data Kategori</h6>
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
                        <a href="{{ route("kategori.index") }}"
                            class="d-flex align-items-center gap-1 hover-text-primary">
                            Data Kategori
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Edit</li>
                </ul>
            </div>

            <div class="card h-100 p-0 radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Form Edit Kategori</h6>
                </div>
                <div class="card-body p-24">
                    <form action="{{ route("kategori.update", $kategori->id_kategori) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-20">
                                    <label for="nama"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Nama Kategori <span class="text-danger-600">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control radius-8 @error("nama") is-invalid @enderror" id="nama"
                                        name="nama" value="{{ old("nama", $kategori->nama) }}"
                                        placeholder="Masukkan nama kategori">
                                    @error("nama")
                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                            <a href="{{ route("kategori.index") }}"
                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                Batal
                            </a>
                            <button type="submit"
                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        @include("partials.dashboard.footer")
    </main>
    @include("partials.dashboard.scripts")
</body>

</html>
