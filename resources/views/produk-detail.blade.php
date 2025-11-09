@extends("template")
@section("title", $produk->nama . " - Aksesoris Ria")

@section("body")
    <!-- Breakcrumbs -->
    <div class="tf-sp-1">
        <div class="container">
            <ul class="breakcrumbs">
                <li>
                    <a href="{{ route("home") }}" class="body-small link">
                        Home
                    </a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="icon-arrow-right"></i>
                </li>
                <li>
                    <a href="{{ route("home", ["kategori" => $produk->kategori_id]) }}" class="body-small link">
                        {{ $produk->kategori->nama }}
                    </a>
                </li>
                <li class="d-flex align-items-center">
                    <i class="icon-arrow-right"></i>
                </li>
                <li>
                    <span class="body-small">{{ $produk->nama }}</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <!-- Product Main -->
    <section>
        <div class="tf-main-product section-image-zoom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Product Image -->
                        <div class="tf-product-media-wrap bg-white thumbs-default sticky-top">
                            <div class="thumbs-slider">
                                <div class="swiper tf-product-media-main" id="gallery-swiper-started">
                                    <div class="swiper-wrapper">
                                        @forelse ($produk->gambarProduk as $gambar)
                                            <div class="swiper-slide" data-color="gray">
                                                <a href="{{ asset($gambar->path_gambar) }}" target="_blank" class="item"
                                                    data-pswp-width="600px" data-pswp-height="800px">
                                                    <img class="tf-image-zoom lazyload"
                                                        src="{{ asset($gambar->path_gambar) }}"
                                                        data-zoom="{{ asset($gambar->path_gambar) }}"
                                                        data-src="{{ asset($gambar->path_gambar) }}" alt="">
                                                </a>
                                            </div>
                                        @empty
                                            <p>No images available</p>
                                        @endforelse

                                        @foreach ($produk->jenisProduk as $jenis)
                                            <div class="swiper-slide" data-color="gray" data-jenis-id="{{ $jenis->id_jenis_produk }}">
                                                <a href="{{ asset($jenis->path_gambar) }}" target="_blank" class="item"
                                                    data-pswp-width="600px" data-pswp-height="800px">
                                                    <img class="tf-image-zoom lazyload"
                                                        src="{{ asset($jenis->path_gambar) }}"
                                                        data-zoom="{{ asset($jenis->path_gambar) }}"
                                                        data-src="{{ asset($jenis->path_gambar) }}" alt="">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="container-swiper">
                                    <div class="swiper tf-product-media-thumbs other-image-zoom"
                                        data-direction="horizontal">
                                        <div class="swiper-wrapper stagger-wrap">
                                            @foreach ($produk->gambarProduk as $gambar)
                                                <div class="swiper-slide stagger-item" data-color="gray">
                                                    <div class="item">
                                                        <img class="lazyload" data-src="{{ asset($gambar->path_gambar) }}"
                                                            src="{{ asset($gambar->path_gambar) }}" alt="">
                                                    </div>
                                                </div>
                                            @endforeach

                                            @foreach ($produk->jenisProduk as $jenis)
                                                <div class="swiper-slide stagger-item" data-color="gray"
                                                    data-jenis-id="{{ $jenis->id_jenis_produk }}">
                                                    <div class="item">
                                                        <img class="lazyload" data-src="{{ asset($jenis->path_gambar) }}"
                                                            src="{{ asset($jenis->path_gambar) }}" alt="">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Product Image -->
                    </div>
                    <div class="col-md-6">
                        <!-- Product Infor -->
                        <div class="tf-product-info-wrap bg-white position-relative">
                            {{-- <div class="tf-zoom-main"></div> --}}
                            <div class="tf-product-info-list style-2 justify-content-xl-end">
                                <div class="tf-product-info-content">
                                    <div class="infor-heading">
                                        <p class="caption">Kategori:
                                            <a href="{{ route("home", ["kategori" => $produk->kategori->id_kategori] + request()->except("kategori")) }}"
                                                class="link text-secondary">
                                                {{ $produk->kategori->nama }}
                                            </a>
                                        </p>
                                        <h5 class="product-info-name fw-semibold">
                                            {{ $produk->nama }}
                                        </h5>
                                        <span class="body-text-3 caption text-muted">
                                            <strong class="text-success">{{ $produk->totalTerjual }}</strong>
                                            Terjual
                                        </span>
                                    </div>
                                    <div class="infor-center">
                                        <div class="product-info-price">
                                            <h4 class="text-primary">Rp. {{ number_format($produk->harga, 0, ",", ".") }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="tf-product-info-choose-option flex-xl-nowrap">
                                            <div class="product-quantity">
                                                <p class=" title body-text-3">
                                                    Jumlah
                                                </p>
                                                <div class="wg-quantity">
                                                    <button class="btn-quantity btn-decrease">
                                                        <i class="icon-minus"></i>
                                                    </button>
                                                    <input class="quantity-product" type="text" name="number"
                                                        value="1">
                                                    <button class="btn-quantity btn-increase">
                                                        <i class="icon-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @if ($produk->jenisProduk)
                                                <div class="product-color">
                                                    <p class=" title body-text-3">
                                                        Jenis
                                                    </p>
                                                    <div class="tf-select-color ">
                                                        <select class="select-color">
                                                            @foreach ($produk->jenisProduk as $jenis)
                                                                <option value="{{ $jenis->id_jenis_produk }}"
                                                                    {{ $jenis->id_jenis_produk == $produk->jenisProdukTerpilih ? "selected" : "" }}>
                                                                    {{ $jenis->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                            @auth
                                                <div class="product-box-btn">
                                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                        class="tf-btn text-white btn-add-to-cart"
                                                        data-product-id="{{ $produk->id_produk }}"
                                                        data-product-nama="{{ $produk->nama }}"
                                                        data-product-harga="{{ $produk->harga }}"
                                                        data-product-gambar="{{ $produk->gambarProduk->first() ? asset($produk->gambarProduk->first()->path_gambar) : asset("home/images/no-image.png") }}"
                                                        data-product-kategori="{{ $produk->kategori->nama }}">
                                                        Tambah Keranjang
                                                        <i class="icon-cart-2"></i>
                                                    </a>
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                    <div class="infor-bottom">
                                        <h6 class="fw-semibold">Deskripsi</h6>
                                        {!! $produk->keterangan !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /Product Infor -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Product Main -->

    @push("scripts")
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectJenis = document.querySelector('.select-color');

                function selectJenisById(id) {
                    if (!selectJenis) return;
                    // set value hanya jika option tersebut ada
                    const option = selectJenis.querySelector('option[value="' + id + '"]');
                    if (option) {
                        selectJenis.value = id;
                        // trigger change agar behavior lain tetap jalan (mis. slideTo sudah ada di listener change)
                        selectJenis.dispatchEvent(new Event('change', {
                            bubbles: true
                        }));
                    }
                }

                if (selectJenis) {
                    selectJenis.addEventListener('change', function() {
                        const jenisId = this.value;

                        // Cari swiper instance
                        const swiperMain = document.querySelector('#gallery-swiper-started');
                        if (swiperMain && swiperMain.swiper) {
                            // Cari slide yang memiliki data-jenis-id yang sesuai
                            const slides = swiperMain.querySelectorAll('.swiper-slide');
                            let targetIndex = -1;

                            slides.forEach((slide, index) => {
                                if (slide.getAttribute('data-jenis-id') === jenisId) {
                                    targetIndex = index;
                                }
                            });

                            // Jika ditemukan, navigasi ke slide tersebut
                            if (targetIndex !== -1) {
                                swiperMain.swiper.slideTo(targetIndex);
                            }
                        }
                    });
                }

                // Klik pada thumbnail (delegated) -> pilih jenis jika slide punya data-jenis-id
                const thumbsContainer = document.querySelector('.tf-product-media-thumbs');
                if (thumbsContainer) {
                    thumbsContainer.addEventListener('click', function(e) {
                        const slide = e.target.closest('.swiper-slide');
                        if (!slide) return;
                        const jenisId = slide.getAttribute('data-jenis-id');
                        if (jenisId) {
                            selectJenisById(jenisId);
                        }
                    });
                }

                // Klik pada main slide -> pilih jenis jika slide punya data-jenis-id
                const mainSwiper = document.querySelector('#gallery-swiper-started');
                if (mainSwiper) {
                    mainSwiper.addEventListener('click', function(e) {
                        const slide = e.target.closest('.swiper-slide');
                        if (!slide) return;
                        const jenisId = slide.getAttribute('data-jenis-id');
                        if (jenisId) {
                            selectJenisById(jenisId);
                        }
                    });
                }

                // Update gambar keranjang saat jenis dipilih
                function updateCartImage() {
                    const btnAddToCart = document.querySelector('.btn-add-to-cart');
                    if (!btnAddToCart || !selectJenis) return;

                    const selectedJenisId = selectJenis.value;

                    if (selectedJenisId) {
                        // Cari slide dengan data-jenis-id yang sesuai
                        const swiperMain = document.querySelector('#gallery-swiper-started');
                        if (swiperMain) {
                            const targetSlide = swiperMain.querySelector('.swiper-slide[data-jenis-id="' +
                                selectedJenisId + '"]');
                            if (targetSlide) {
                                const img = targetSlide.querySelector('img');
                                if (img) {
                                    const imgSrc = img.getAttribute('src') || img.getAttribute('data-src');
                                    if (imgSrc) {
                                        btnAddToCart.setAttribute('data-product-gambar', imgSrc);
                                    }
                                }
                            }
                        }
                    }
                }

                // Update gambar saat jenis berubah
                if (selectJenis) {
                    selectJenis.addEventListener('change', updateCartImage);
                    // Update saat halaman pertama kali dimuat (jika ada jenis terpilih)
                    updateCartImage();
                }
            });
        </script>
    @endpush
@endsection

@section("footer")
    @include("partials.footer")
@endsection
