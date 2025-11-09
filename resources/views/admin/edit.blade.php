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
                <h6 class="fw-semibold mb-0">Edit Data Admin</h6>
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
                        <a href="{{ route("admin.index") }}" class="d-flex align-items-center gap-1 hover-text-primary">
                            Data Admin
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Edit</li>
                </ul>
            </div>

            <div class="card h-100 p-0 radius-12">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="text-lg fw-semibold mb-0">Form Edit Admin</h6>
                </div>
                <div class="card-body p-24">
                    <form action="{{ route("admin.update", $admin->id_user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-20">
                                    <label for="nama"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Nama Lengkap <span class="text-danger-600">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control radius-8 @error("nama") is-invalid @enderror" id="nama"
                                        name="nama" value="{{ old("nama", $admin->nama) }}"
                                        placeholder="Masukkan nama lengkap">
                                    @error("nama")
                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-20">
                                    <label for="username"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Username <span class="text-danger-600">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control radius-8 @error("username") is-invalid @enderror"
                                        id="username" name="username" value="{{ old("username", $admin->username) }}"
                                        placeholder="Masukkan username">
                                    @error("username")
                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-20">
                                    <label for="email"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Email <span class="text-danger-600">*</span>
                                    </label>
                                    <input type="email"
                                        class="form-control radius-8 @error("email") is-invalid @enderror"
                                        id="email" name="email" value="{{ old("email", $admin->email) }}"
                                        placeholder="Masukkan email">
                                    @error("email")
                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-20">
                                    <label for="no_hp"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        No HP <span class="text-danger-600">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control radius-8 @error("no_hp") is-invalid @enderror"
                                        id="no_hp" name="no_hp" value="{{ old("no_hp", $admin->no_hp) }}"
                                        placeholder="Masukkan nomor HP">
                                    @error("no_hp")
                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-20">
                                    <label for="password"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Password <small class="text-secondary-light">(Kosongkan jika tidak ingin
                                            mengubah)</small>
                                    </label>
                                    <input type="password"
                                        class="form-control radius-8 @error("password") is-invalid @enderror"
                                        id="password" name="password" placeholder="Masukkan password baru">
                                    @error("password")
                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-20">
                                    <label for="password_confirmation"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Konfirmasi Password
                                    </label>
                                    <input type="password" class="form-control radius-8" id="password_confirmation"
                                        name="password_confirmation" placeholder="Konfirmasi password baru">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-20">
                                    <label for="alamat"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Alamat
                                    </label>
                                    <textarea class="form-control radius-8 @error("alamat") is-invalid @enderror" id="alamat" name="alamat"
                                        rows="3" placeholder="Masukkan alamat">{{ old("alamat", $admin->alamat) }}</textarea>
                                    @error("alamat")
                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-20">
                                    <label for="foto"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Foto Profil
                                    </label>
                                    @if ($admin->foto)
                                        <div class="mb-2">
                                            <img src="{{ asset($admin->foto) }}" alt="{{ $admin->nama }}"
                                                class="w-25 rounded-circle object-fit-cover">
                                        </div>
                                    @endif
                                    <input type="file"
                                        class="form-control radius-8 @error("foto") is-invalid @enderror"
                                        id="foto" name="foto" accept="image/*">
                                    @error("foto")
                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                    @enderror
                                    <small class="text-secondary-light">Format: JPG, JPEG, PNG. Max: 2MB</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                            <a href="{{ route("admin.index") }}"
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
