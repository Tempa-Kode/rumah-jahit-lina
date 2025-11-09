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
                <h6 class="fw-semibold mb-0">Profil Pengguna</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="{{ route("dashboard.admin") }}"
                            class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Profil Pengguna</li>
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

            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                        <img src="https://cdn.pixabay.com/photo/2014/10/07/13/48/mountain-477832_1280.jpg"
                            alt="" class="w-100 object-fit-cover">
                        <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                            <div class="text-center border border-top-0 border-start-0 border-end-0">
                                <img src="{{ asset($user->foto ?? "dashboard/assets/images/user.png") }}" alt=""
                                    class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                                <h6 class="mb-0 mt-16 text-capitalize">{{ $user->nama }}</h6>
                                <span class="text-secondary-light mb-16">{{ $user->email }}</span>
                            </div>
                            <div class="mt-24">
                                <h6 class="text-xl mb-16">Informasi Pribadi</h6>
                                <ul>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Nama Lengkap</span>
                                        <span class="w-70 text-secondary-light fw-medium text-capitalize">:
                                            {{ $user->nama }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Username</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $user->username }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Email</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $user->email }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">No. HP</span>
                                        <span class="w-70 text-secondary-light fw-medium">:
                                            {{ $user->no_hp ?? "-" }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Role</span>
                                        <span class="w-70 text-secondary-light fw-medium text-capitalize">:
                                            {{ $user->role }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Alamat</span>
                                        <span class="w-70 text-secondary-light fw-medium">:
                                            {{ $user->alamat ?? "-" }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card h-100">
                        <div class="card-body p-24">
                            <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab"
                                role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link d-flex align-items-center px-24 active"
                                        id="pills-edit-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-edit-profile" type="button" role="tab"
                                        aria-controls="pills-edit-profile" aria-selected="true">
                                        Edit Profil
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link d-flex align-items-center px-24"
                                        id="pills-change-passwork-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-change-passwork" type="button" role="tab"
                                        aria-controls="pills-change-passwork" aria-selected="false" tabindex="-1">
                                        Ubah Password
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel"
                                    aria-labelledby="pills-edit-profile-tab" tabindex="0">
                                    <h6 class="text-md text-primary-light mb-16">Foto Profil</h6>
                                    <!-- Upload Image Start -->
                                    <form action="{{ route("profile.update") }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method("PUT")
                                        <div class="mb-24 mt-16">
                                            <div class="avatar-upload">
                                                <div
                                                    class="avatar-edit position-absolute bottom-0 end-0 me-24 mt-16 z-1 cursor-pointer">
                                                    <input type='file' id="imageUpload" name="foto"
                                                        accept=".png, .jpg, .jpeg" hidden>
                                                    <label for="imageUpload"
                                                        class="w-32-px h-32-px d-flex justify-content-center align-items-center bg-primary-50 text-primary-600 border border-primary-600 bg-hover-primary-100 text-lg rounded-circle">
                                                        <iconify-icon icon="solar:camera-outline"
                                                            class="icon"></iconify-icon>
                                                    </label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id="imagePreview"
                                                        style="background-image: url('{{ asset($user->foto ?? "dashboard/assets/images/user.png") }}');">
                                                    </div>
                                                </div>
                                            </div>
                                            @error("foto")
                                                <div class="text-danger-600 mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- Upload Image End -->

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <label for="nama"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Nama
                                                        Lengkap <span class="text-danger-600">*</span></label>
                                                    <input type="text"
                                                        class="form-control radius-8 @error("nama") is-invalid @enderror"
                                                        id="nama" name="nama"
                                                        value="{{ old("nama", $user->nama) }}"
                                                        placeholder="Enter Full Name">
                                                    @error("nama")
                                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <label for="username"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Username
                                                        <span class="text-danger-600">*</span></label>
                                                    <input type="text"
                                                        class="form-control radius-8 @error("username") is-invalid @enderror"
                                                        id="username" name="username"
                                                        value="{{ old("username", $user->username) }}"
                                                        placeholder="Enter username">
                                                    @error("username")
                                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <label for="email"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Email
                                                        <span class="text-danger-600">*</span></label>
                                                    <input type="email"
                                                        class="form-control radius-8 @error("email") is-invalid @enderror"
                                                        id="email" name="email"
                                                        value="{{ old("email", $user->email) }}"
                                                        placeholder="Enter email address">
                                                    @error("email")
                                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <label for="no_hp"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Telp</label>
                                                    <input type="text"
                                                        class="form-control radius-8 @error("no_hp") is-invalid @enderror"
                                                        id="no_hp" name="no_hp"
                                                        value="{{ old("no_hp", $user->no_hp) }}"
                                                        placeholder="Enter phone number">
                                                    @error("no_hp")
                                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-20">
                                                    <label for="alamat"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Alamat</label>
                                                    <textarea name="alamat" class="form-control radius-8 @error("alamat") is-invalid @enderror" id="alamat"
                                                        rows="3" placeholder="Write address...">{{ old("alamat", $user->alamat) }}</textarea>
                                                    @error("alamat")
                                                        <div class="text-danger-600 mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center gap-3">
                                            <a href="{{ route("dashboard.admin") }}"
                                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                                Batal
                                            </a>
                                            <button type="submit"
                                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="pills-change-passwork" role="tabpanel"
                                    aria-labelledby="pills-change-passwork-tab" tabindex="0">

                                    @if (session("success_password"))
                                        <div
                                            class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px px-24 py-13 mb-3 fw-semibold text-lg radius-4">
                                            {{ session("success_password") }}
                                        </div>
                                    @endif

                                    @if (session("error_password"))
                                        <div
                                            class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px px-24 py-13 mb-3 fw-semibold text-lg radius-4">
                                            {{ session("error_password") }}
                                        </div>
                                    @endif

                                    <form action="{{ route("profile.password.update") }}" method="POST">
                                        @csrf
                                        @method("PUT")
                                        <div class="mb-20">
                                            <label for="current-password"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Password
                                                Saat Ini <span class="text-danger-600">*</span></label>
                                            <div class="position-relative">
                                                <input type="password"
                                                    class="form-control radius-8 @error("current_password") is-invalid @enderror"
                                                    id="current-password" name="current_password"
                                                    placeholder="Masukkan Password Saat Ini">
                                                <span
                                                    class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                                    data-toggle="#current-password"></span>
                                            </div>
                                            @error("current_password")
                                                <div class="text-danger-600 mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-20">
                                            <label for="password"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Password
                                                Baru <span class="text-danger-600">*</span></label>
                                            <div class="position-relative">
                                                <input type="password"
                                                    class="form-control radius-8 @error("password") is-invalid @enderror"
                                                    id="password" name="password"
                                                    placeholder="Masukkan Password Baru">
                                                <span
                                                    class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                                    data-toggle="#password"></span>
                                            </div>
                                            @error("password")
                                                <div class="text-danger-600 mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-20">
                                            <label for="password-confirmation"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Konfirmasi
                                                Password <span class="text-danger-600">*</span></label>
                                            <div class="position-relative">
                                                <input type="password" class="form-control radius-8"
                                                    id="password-confirmation" name="password_confirmation"
                                                    placeholder="Masukkan Konfirmasi Password">
                                                <span
                                                    class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                                    data-toggle="#password-confirmation"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center gap-3">
                                            <a href="{{ route("dashboard.admin") }}"
                                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                                Batal
                                            </a>
                                            <button type="submit"
                                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                                Perbarui Password
                                            </button>
                                        </div>
                                    </form>
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

    <script>
        // ======================== Upload Image Start =====================
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#imagePreview").css("background-image", "url(" + e.target.result + ")");
                    $("#imagePreview").hide();
                    $("#imagePreview").fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });
        // ======================== Upload Image End =====================

        // ================== Password Show Hide Js Start ==========
        function initializePasswordToggle(toggleSelector) {
            $(toggleSelector).on("click", function() {
                $(this).toggleClass("ri-eye-off-line");
                var input = $($(this).attr("data-toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        }
        // Call the function
        initializePasswordToggle(".toggle-password");
        // ========================= Password Show Hide Js End ===========================
    </script>
</body>

</html>
