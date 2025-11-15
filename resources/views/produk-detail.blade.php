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
                                            <div class="swiper-slide" data-color="gray"
                                                data-jenis-id="{{ $jenis->id_jenis_produk }}">
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
                            <div class="tf-product-info-content">
                                <div class="tf-product-info-content">
                                    <div class="infor-heading">
                                        <p class="caption">Kategori:
                                            <a href="{{ route("home", ["kategori" => $produk->kategori->id_kategori] + request()->except("kategori")) }}"
                                                class="link text-primary">
                                                {{ $produk->kategori->nama }}
                                            </a>
                                        </p>
                                        <h5 class="product-info-name fw-semibold">
                                            {{ $produk->nama }}<span id="selected-jenis-name" class="text-primary"></span>
                                        </h5>
                                        <span class="body-text-3 caption text-muted">
                                            <strong class="text-success">{{ $produk->totalTerjual }}</strong>
                                            Terjual
                                        </span>
                                        {{-- Sisa Stok --}}
                                        @php
                                            $initialStock = $produk->jumlah_produk ?? 0;
                                            if ($produk->jenisProduk->count() > 0) {
                                                $selected = $produk->jenisProduk->firstWhere(
                                                    "id_jenis_produk",
                                                    $produk->jenisProdukTerpilih,
                                                );
                                                if ($selected) {
                                                    $initialStock = $selected->jumlah_produk ?? $initialStock;
                                                }
                                            }
                                        @endphp
                                        <p class="caption">Sisa Stok: <strong id="stock-count">{{ $initialStock }}</strong>
                                        </p>
                                    </div>
                                    <div class="infor-center">
                                        <div class="product-info-price">
                                            <h4 class="text-primary">Rp. {{ number_format($produk->harga, 0, ",", ".") }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class="tf-product-info-choose-option sticky-top">
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
                                            @if ($produk->jenisProduk->count() > 0)
                                                <div class="product-color">
                                                    <p class=" title body-text-3">
                                                        Jenis/Variasi
                                                    </p>
                                                    <div class="tf-select-color">
                                                        @foreach ($produk->jenisProduk as $jenis)
                                                            <input type="checkbox" class="btn-check jenis-checkbox"
                                                                id="jenis-{{ $jenis->id_jenis_produk }}"
                                                                value="{{ $jenis->id_jenis_produk }}"
                                                                data-jenis-nama="{{ $jenis->nama }}"
                                                                data-jenis-harga="{{ $jenis->harga }}"
                                                                data-jenis-warna="{{ $jenis->warna }}"
                                                                data-jenis-ukuran="{{ $jenis->ukuran }}"
                                                                data-jenis-jumlah="{{ $jenis->jumlah_produk }}"
                                                                {{ $jenis->id_jenis_produk == $produk->jenisProdukTerpilih ? "checked" : "" }}
                                                                autocomplete="off">
                                                            <label class="btn btn-outline-primary"
                                                                for="jenis-{{ $jenis->id_jenis_produk }}">
                                                                {{ $jenis->nama }}
                                                                @if ($jenis->warna || $jenis->ukuran)
                                                                    <br><small class="text-muted">
                                                                        @if ($jenis->warna)
                                                                            {{ $jenis->warna }}
                                                                        @endif
                                                                        @if ($jenis->warna && $jenis->ukuran)
                                                                            -
                                                                        @endif
                                                                        @if ($jenis->ukuran)
                                                                            {{ $jenis->ukuran }}
                                                                        @endif
                                                                    </small>
                                                                @endif
                                                                {{-- <br><small class="text-success fw-bold">Rp {{ number_format($jenis->harga, 0, ',', '.') }}</small> --}}
                                                            </label>
                                                        @endforeach
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
                                                        data-product-kategori="{{ $produk->kategori->nama }}"
                                                        data-product-jumlah="{{ $produk->jumlah_produk ?? 0 }}"
                                                        data-product-stok="{{ $initialStock }}"
                                                        data-has-variants="{{ $produk->jenisProduk->count() > 0 ? "true" : "false" }}">
                                                        Tambah Keranjang
                                                        <i class="icon-cart-2"></i>
                                                    </a>
                                                </div>
                                                {{-- Tombol Beli Langsung --}}
                                                <div class="product-box-btn mt-2">
                                                    <button type="button" class="btn btn-warning w-100 btn-buy-now"
                                                        data-product-id="{{ $produk->id_produk }}"
                                                        data-product-nama="{{ $produk->nama }}"
                                                        data-product-harga="{{ $produk->harga }}"
                                                        data-product-gambar="{{ $produk->gambarProduk->first() ? asset($produk->gambarProduk->first()->path_gambar) : asset("home/images/no-image.png") }}"
                                                        data-product-kategori="{{ $produk->kategori->nama }}"
                                                        data-product-jumlah="{{ $produk->jumlah_produk ?? 0 }}">
                                                        Beli Sekarang
                                                    </button>
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
                const jenisCheckboxes = document.querySelectorAll('.jenis-checkbox');
                const btnAddToCart = document.querySelector('.btn-add-to-cart');

                // Fungsi untuk mendapatkan checkbox yang terpilih
                function getSelectedJenis() {
                    const checked = document.querySelector('.jenis-checkbox:checked');
                    return checked ? {
                        id: checked.value,
                        nama: checked.getAttribute('data-jenis-nama')
                    } : null;
                }

                // Fungsi untuk update gambar slider berdasarkan jenis yang dipilih
                function updateSliderByJenis(jenisId) {
                    const swiperMain = document.querySelector('#gallery-swiper-started');
                    if (swiperMain && swiperMain.swiper) {
                        const slides = swiperMain.querySelectorAll('.swiper-slide');
                        let targetIndex = -1;

                        slides.forEach((slide, index) => {
                            if (slide.getAttribute('data-jenis-id') === jenisId) {
                                targetIndex = index;
                            }
                        });

                        if (targetIndex !== -1) {
                            swiperMain.swiper.slideTo(targetIndex);
                        }
                    }
                }

                // Fungsi untuk update harga berdasarkan jenis yang dipilih
                function updatePrice() {
                    const selectedCheckbox = document.querySelector('.jenis-checkbox:checked');
                    const priceElement = document.querySelector('.product-info-price h4');

                    if (selectedCheckbox && priceElement) {
                        const jenisHarga = selectedCheckbox.getAttribute('data-jenis-harga');
                        if (jenisHarga) {
                            const formattedPrice = new Intl.NumberFormat('id-ID').format(jenisHarga);
                            priceElement.textContent = 'Rp. ' + formattedPrice;
                        }
                    }
                }

                // Fungsi untuk update sisa stok berdasarkan jenis yang dipilih atau produk utama
                function updateStock() {
                    const stockElement = document.getElementById('stock-count');
                    if (!stockElement) return;

                    const selectedCheckbox = document.querySelector('.jenis-checkbox:checked');
                    let stok = null;

                    if (selectedCheckbox) {
                        stok = selectedCheckbox.getAttribute('data-jenis-jumlah');
                    } else if (btnAddToCart) {
                        stok = btnAddToCart.getAttribute('data-product-jumlah');
                    }

                    if (stok === null || stok === undefined) {
                        stok = 0;
                    }

                    stockElement.textContent = stok;

                    // update quantity controls (buttons and input) based on stok
                    updateQuantityControls(parseInt(stok || 0, 10));
                }

                // Helper: ambil stok yang tersedia (number)
                function getAvailableStock() {
                    const selectedCheckbox = document.querySelector('.jenis-checkbox:checked');
                    if (selectedCheckbox) {
                        return parseInt(selectedCheckbox.getAttribute('data-jenis-jumlah') || 0, 10);
                    }
                    if (btnAddToCart) {
                        return parseInt(btnAddToCart.getAttribute('data-product-jumlah') || 0, 10);
                    }
                    return 0;
                }

                // Update controls: enable/disable increase/decrease, clamp quantity, manage add-to-cart
                function updateQuantityControls(stock) {
                    const qtyInput = document.querySelector('.quantity-product');
                    const btnInc = document.querySelector('.btn-increase');
                    const btnDec = document.querySelector('.btn-decrease');

                    if (!qtyInput) return;

                    let val = parseInt(qtyInput.value, 10);
                    if (isNaN(val) || val < 1) val = 1;

                    if (stock <= 0) {
                        // jika stok habis, tampilkan 0. Keep increase button clickable so we can show alert.
                        qtyInput.value = 0;
                        if (btnDec) btnDec.disabled = true;
                        if (btnAddToCart) {
                            btnAddToCart.style.pointerEvents = 'none';
                            btnAddToCart.style.opacity = '0.6';
                            btnAddToCart.setAttribute('aria-disabled', 'true');
                            // ubah teks sementara untuk memberi tahu habis
                            btnAddToCart.dataset._originalText = btnAddToCart.textContent.trim();
                            btnAddToCart.textContent = 'Habis';
                        }
                        return;
                    }

                    // jika stok ada, pastikan qty tidak lebih dari stok
                    if (val > stock) val = stock;
                    qtyInput.value = val;

                    // Keep increase clickable to allow showing an alert when at max
                    if (btnInc) btnInc.disabled = false;
                    if (btnDec) btnDec.disabled = (val <= 1);

                    if (btnAddToCart) {
                        btnAddToCart.style.pointerEvents = '';
                        btnAddToCart.style.opacity = '';
                        btnAddToCart.removeAttribute('aria-disabled');
                        if (btnAddToCart.dataset._originalText) {
                            // restore original label if sebelumnya diubah
                            btnAddToCart.textContent = btnAddToCart.dataset._originalText;
                            delete btnAddToCart.dataset._originalText;
                        }
                    }
                }

                // Fungsi untuk update nama jenis di judul produk
                function updateProductName() {
                    const selectedCheckbox = document.querySelector('.jenis-checkbox:checked');
                    const jenisNameElement = document.getElementById('selected-jenis-name');

                    if (selectedCheckbox && jenisNameElement) {
                        const jenisNama = selectedCheckbox.getAttribute('data-jenis-nama');
                        const jenisWarna = selectedCheckbox.getAttribute('data-jenis-warna');
                        const jenisUkuran = selectedCheckbox.getAttribute('data-jenis-ukuran');

                        let displayText = ` - ${jenisNama}`;

                        // if (jenisWarna && jenisUkuran) {
                        //     displayText = ` - ${jenisWarna} ${jenisUkuran}`;
                        // } else if (jenisWarna) {
                        //     displayText = ` - ${jenisWarna}`;
                        // } else if (jenisUkuran) {
                        //     displayText = ` - ${jenisUkuran}`;
                        // } else if (jenisNama) {
                        //     displayText = ` - ${jenisNama}`;
                        // }

                        jenisNameElement.textContent = displayText;
                    } else if (jenisNameElement) {
                        jenisNameElement.textContent = '';
                    }
                }

                // Fungsi untuk update gambar pada tombol keranjang
                function updateCartImage() {
                    if (!btnAddToCart) return;

                    const selectedJenis = getSelectedJenis();

                    if (selectedJenis && selectedJenis.id) {
                        const swiperMain = document.querySelector('#gallery-swiper-started');
                        if (swiperMain) {
                            const targetSlide = swiperMain.querySelector('.swiper-slide[data-jenis-id="' +
                                selectedJenis.id + '"]');
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
                        // Simpan jenis yang dipilih ke data attribute
                        btnAddToCart.setAttribute('data-product-jenis-id', selectedJenis.id);
                        btnAddToCart.setAttribute('data-product-jenis-nama', selectedJenis.nama);

                        // Update harga dan nama produk
                        updatePrice();
                        updateProductName();
                        updateStock();
                    } else {
                        // Jika tidak ada jenis yang dipilih, gunakan gambar default (gambar produk pertama)
                        btnAddToCart.removeAttribute('data-product-jenis-id');
                        btnAddToCart.removeAttribute('data-product-jenis-nama');
                        updateProductName();
                        updateStock();
                    }
                }

                // Fungsi untuk memilih checkbox berdasarkan ID
                function selectJenisById(id) {
                    const checkbox = document.querySelector('.jenis-checkbox[value="' + id + '"]');
                    if (checkbox) {
                        // Uncheck semua checkbox lainnya
                        jenisCheckboxes.forEach(cb => {
                            if (cb !== checkbox) {
                                cb.checked = false;
                            }
                        });
                        // Check checkbox yang dipilih
                        checkbox.checked = true;
                        // Update slider dan cart image
                        updateSliderByJenis(id);
                        updateCartImage();
                    }
                }

                // Event listener untuk setiap checkbox
                jenisCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            // Uncheck semua checkbox lainnya
                            jenisCheckboxes.forEach(cb => {
                                if (cb !== this) {
                                    cb.checked = false;
                                }
                            });
                            // Update slider dan cart image
                            updateSliderByJenis(this.value);
                            updateCartImage();
                        } else {
                            // Jika di-uncheck, reset ke gambar default
                            updateCartImage();
                        }
                    });
                });

                // Quantity controls: increase / decrease / manual input
                const qtyInput = document.querySelector('.quantity-product');
                const btnInc = document.querySelector('.btn-increase');
                const btnDec = document.querySelector('.btn-decrease');

                if (btnInc) {
                    btnInc.addEventListener('click', function(e) {
                        e.preventDefault();
                        const stock = getAvailableStock();
                        let val = parseInt(qtyInput.value, 10) || 1;
                        if (val < stock) {
                            val += 1;
                            qtyInput.value = val;
                        } else {
                            alert('Stok tidak cukup. Sisa stok: ' + stock);
                        }
                        updateQuantityControls(stock);
                    });
                }

                if (btnDec) {
                    btnDec.addEventListener('click', function(e) {
                        e.preventDefault();
                        let val = parseInt(qtyInput.value, 10) || 1;
                        if (val > 1) {
                            val -= 1;
                            qtyInput.value = val;
                        }
                        updateQuantityControls(getAvailableStock());
                    });
                }

                if (qtyInput) {
                    qtyInput.addEventListener('input', function() {
                        // hanya angka
                        const cleaned = this.value.replace(/\D/g, '');
                        let val = parseInt(cleaned, 10) || 1;
                        const stock = getAvailableStock();
                        if (val > stock) {
                            this.value = stock;
                            alert('Jumlah melebihi stok tersedia. Sisa stok: ' + stock);
                        } else if (val < 1) {
                            this.value = 1;
                        } else {
                            this.value = val;
                        }
                        updateQuantityControls(stock);
                    });
                }

                // Klik pada thumbnail -> pilih jenis jika slide punya data-jenis-id
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

                // Update gambar dan nama saat halaman pertama kali dimuat (jika ada jenis terpilih)
                updateCartImage();
                updateProductName();

                // ensure quantity controls reflect initial stock on load
                updateStock();

                // Intercept add-to-cart to validate stock before opening cart offcanvas
                if (btnAddToCart) {
                    btnAddToCart.addEventListener('click', function(e) {
                        const stock = getAvailableStock();
                        const qty = parseInt(document.querySelector('.quantity-product').value, 10) || 0;
                        if (stock <= 0) {
                            e.preventDefault();
                            alert('Stok produk habis.');
                            return;
                        }
                        if (qty <= 0) {
                            e.preventDefault();
                            alert('Jumlah minimal adalah 1.');
                            return;
                        }
                        if (qty > stock) {
                            e.preventDefault();
                            alert('Jumlah yang dipilih melebihi sisa stok (' + stock + ').');
                            return;
                        }
                        // otherwise allow add-to-cart to proceed (offcanvas)
                    });
                }

                // Buy Now: langsung ke checkout dengan satu item di cart (localStorage)
                const btnBuyNow = document.querySelector('.btn-buy-now');
                if (btnBuyNow) {
                    btnBuyNow.addEventListener('click', function(e) {
                        e.preventDefault();

                        const stock = getAvailableStock();
                        let qty = parseInt(document.querySelector('.quantity-product').value, 10) || 1;

                        if (stock <= 0) {
                            alert('Stok produk habis.');
                            return;
                        }
                        if (qty <= 0) {
                            alert('Jumlah minimal adalah 1.');
                            return;
                        }
                        if (qty > stock) {
                            alert('Jumlah yang dipilih melebihi sisa stok (' + stock + ').');
                            qty = stock;
                            document.querySelector('.quantity-product').value = qty;
                            updateQuantityControls(stock);
                            return;
                        }

                        // Build product object same shape as cart.js expects
                        const product = {
                            id: parseInt(btnBuyNow.dataset.productId),
                            nama: btnBuyNow.dataset.productNama,
                            harga: parseInt(btnBuyNow.dataset.productHarga),
                            gambar: btnBuyNow.dataset.productGambar,
                            kategori: btnBuyNow.dataset.productKategori,
                            quantity: qty,
                            jenis_id: null,
                            jenis_nama: null,
                        };

                        // If a variant is selected, include it and adjust price if variant has price
                        const selectedJenis = document.querySelector('.jenis-checkbox:checked');
                        if (selectedJenis) {
                            product.jenis_id = parseInt(selectedJenis.value);
                            product.jenis_nama = selectedJenis.getAttribute('data-jenis-nama');
                            const jenisHarga = selectedJenis.getAttribute('data-jenis-harga');
                            if (jenisHarga) product.harga = parseInt(jenisHarga);
                        }

                        // Save single-item cart to localStorage and redirect to checkout
                        try {
                            localStorage.setItem('ria_shopping_cart', JSON.stringify([product]));
                            window.location.href = '{{ route("checkout") }}';
                        } catch (err) {
                            console.error('Gagal menyimpan cart ke localStorage', err);
                            alert('Terjadi kesalahan saat memproses pembelian. Coba lagi.');
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection

@section("footer")
    @include("partials.footer")
@endsection
