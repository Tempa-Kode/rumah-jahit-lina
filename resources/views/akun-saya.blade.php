@extends("template")

@section("title", "Akun Saya - Aksesoris Ria")

@section("body")
    <!-- My Account -->
    <section class="tf-sp-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 d-none d-lg-block">
                    <div class="wrap-sidebar-account">
                        <ul class="my-account-nav content-append">
                            <li><span class="my-account-nav-item active">Dashboard</span></li>
                            <li><a href="{{ route("akun.pesanan") }}" class="my-account-nav-item">Pesanan</a></li>
                            <li><a href="{{ route("akun.alamat") }}" class="my-account-nav-item">Alamat</a></li>
                            <li><a href="{{ route("akun.edit") }}" class="my-account-nav-item">Detail Akun</a></li>
                            <li>
                                <form action="{{ route("logout") }}" method="POST">
                                    @csrf
                                    <button type="submit" class="my-account-nav-item"
                                        style="border: none; background: none; cursor: pointer; text-align: left; width: 100%;">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="my-account-content account-dashboard">
                        <div class="mb_60">
                            <h3 class="fw-semibold mb-20">Halo {{ Auth::user()->nama ?? "Pengguna" }}</h3>
                            <p>
                                Dari dashboard akun Anda, Anda dapat melihat
                                <a class="text-secondary link fw-medium" href="{{ route("akun.pesanan") }}">
                                    pesanan terbaru
                                </a>
                                , mengelola
                                <a class="text-secondary link fw-medium" href="{{ route("akun.alamat") }}">
                                    alamat pengiriman dan pembayaran
                                </a>
                                , dan
                                <a class="text-secondary link fw-medium" href="{{ route("akun.edit") }}">
                                    mengedit kata sandi dan detail akun Anda
                                </a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /My Account -->
@endsection
