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
                @if (session("success"))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="icon-check"></i> {{ session("success") }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session("error"))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="icon-close"></i> {{ session("error") }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
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
                                            @if ($jenis->path_gambar)
                                                <div class="swiper-slide" data-color="gray"
                                                    data-jenis-id="{{ $jenis->id_jenis_produk }}">
                                                    <a href="{{ asset($jenis->path_gambar) }}" target="_blank"
                                                        class="item" data-pswp-width="600px" data-pswp-height="800px">
                                                        <img class="tf-image-zoom lazyload"
                                                            src="{{ asset($jenis->path_gambar) }}"
                                                            data-zoom="{{ asset($jenis->path_gambar) }}"
                                                            data-src="{{ asset($jenis->path_gambar) }}" alt="">
                                                    </a>
                                                </div>
                                            @endif
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
                                                @if ($jenis->path_gambar)
                                                    <div class="swiper-slide stagger-item" data-color="gray"
                                                        data-jenis-id="{{ $jenis->id_jenis_produk }}">
                                                        <div class="item">
                                                            <img class="lazyload"
                                                                data-src="{{ asset($jenis->path_gambar) }}"
                                                                src="{{ asset($jenis->path_gambar) }}" alt="">
                                                        </div>
                                                    </div>
                                                @endif
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
                                                $firstAvailable = $produk->jenisProduk
                                                    ->where("jumlah_produk", ">", 0)
                                                    ->first();
                                                if ($firstAvailable) {
                                                    $initialStock = $firstAvailable->jumlah_produk;
                                                } else {
                                                    $initialStock = $produk->jenisProduk->first()->jumlah_produk ?? 0;
                                                }
                                            }
                                        @endphp
                                        <p class="caption">Sisa Stok: <strong id="stock-count">{{ $initialStock }}</strong>
                                        </p>
                                    </div>
                                    <div class="infor-center">
                                        <div class="product-info-price">
                                            {{-- Harga akan diupdate oleh JS --}}
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

                                            {{-- Opsi Variasi Dinamis --}}
                                            @if ($produk->jenisProduk->count() > 0)
                                                <div id="variant-options">
                                                    @foreach ($jenisProdukGrouped as $attribute => $values)
                                                        @if (count($values) > 0)
                                                            <div class="product-color mt-3">
                                                                <p class="title body-text-3 text-capitalize">
                                                                    {{ $attribute }}</p>
                                                                <div class="tf-select-color">
                                                                    @foreach ($values as $value)
                                                                        <input type="radio"
                                                                            class="btn-check variant-radio"
                                                                            name="variant_{{ $attribute }}"
                                                                            id="variant_{{ $attribute }}_{{ Str::slug($value) }}"
                                                                            value="{{ $value }}"
                                                                            data-attribute="{{ $attribute }}"
                                                                            autocomplete="off">
                                                                        <label class="btn btn-outline-primary"
                                                                            for="variant_{{ $attribute }}_{{ Str::slug($value) }}">{{ $value }}</label>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div id="variant-alert" class="alert alert-warning mt-2"
                                                    style="display: none;">
                                                    Kombinasi variasi tidak tersedia.
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
                                                        data-min-beli="{{ $produk->min_beli ?? 1 }}"
                                                        data-has-variants="{{ $produk->jenisProduk->count() > 0 ? "true" : "false" }}"
                                                        onclick="minPembelian()">
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
                                                        data-product-stok="{{ $initialStock }}"
                                                        data-min-beli="{{ $produk->min_beli ?? 1 }}"
                                                        data-product-jumlah="{{ $produk->jumlah_produk ?? 0 }}"
                                                        onclick="minPembelian()">
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

    <!-- Reviews Section -->
    <section class="tf-sp-2">
        <div class="container">
            <div class="flat-title-tab-product-des">
                <div class="flat-title-tab">
                    <ul class="menu-tab-line">
                        <li class="nav-tab-item">
                            <p class="product-title fw-semibold">
                                Ulasan & Rating
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="tab-main tab-review flex-lg-nowrap">
                    @if ($totalReviews > 0)
                        <div class="tab-rating-wrap">
                            <div class="rating-percent">
                                <p class="rate-percent">{{ number_format($averageRating, 1) }} <span>/ 5</span></p>
                                <ul class="list-star justify-content-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li>
                                            <i
                                                class="icon-star {{ $i <= round($averageRating) ? "" : "text-main-4" }}"></i>
                                        </li>
                                    @endfor
                                </ul>
                                <p class="text-cl-3">
                                    Berdasarkan {{ number_format($totalReviews) }} ulasan
                                </p>
                            </div>
                            <ul class="rating-progress-list">
                                @for ($rating = 5; $rating >= 1; $rating--)
                                    <li>
                                        <p class="start-number body-text-3">{{ $rating }}<i
                                                class="icon-star text-third"></i></p>
                                        <div class="rating-progress">
                                            <div class="progress style-2" role="progressbar"
                                                aria-valuenow="{{ $ratingPercentages[$rating] }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar"
                                                    style="width: {{ $ratingPercentages[$rating] }}%;"></div>
                                            </div>
                                        </div>
                                        <p class="count-review body-text-3">{{ $ratingDistribution[$rating] }}</p>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    @endif
                    <div class="tab-review-wrap" style="flex: 1;">

                        @if ($totalReviews > 0)
                            <ul class="review-list">
                                @foreach ($ulasanRatings as $ulasan)
                                    <li class="box-review">
                                        <div class="avt">
                                            @if ($ulasan->user->foto)
                                                <img src="{{ asset($ulasan->user->foto) }}"
                                                    alt="{{ $ulasan->user->nama }}"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div
                                                    style="width: 50px; height: 50px; border-radius: 50%; background-color: var(--gray-5); display: flex; align-items: center; justify-content: center; color: var(--gray-3); font-weight: bold; font-size: 18px;">
                                                    {{ strtoupper(substr($ulasan->user->nama, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="review-content">
                                            <div class="author-wrap">
                                                <h6 class="name fw-semibold">
                                                    <a href="#" class="link">{{ $ulasan->user->nama }}</a>
                                                </h6>
                                                <ul class="verified">
                                                    <li class="body-small fw-semibold text-main-2">
                                                        Verified Purchase
                                                    </li>
                                                </ul>
                                                <ul class="list-star">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <li>
                                                            <i
                                                                class="icon-star {{ $i <= $ulasan->rating ? "" : "text-main-4" }}"></i>
                                                        </li>
                                                    @endfor
                                                </ul>
                                            </div>
                                            @if ($ulasan->ulasan)
                                                <p class="text-review">
                                                    {{ $ulasan->ulasan }}
                                                </p>
                                            @endif
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="date-review body-small">
                                                    {{ $ulasan->created_at->diffForHumans() }}
                                                </p>
                                                @auth
                                                    @if (Auth::id() == $ulasan->user_id || Auth::user()->role == "admin")
                                                        <form
                                                            action="{{ route("ulasan.destroy", $ulasan->id_ulasan_rating) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                                                            @csrf
                                                            @method("DELETE")
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="icon-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $ulasanRatings->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="icon-star" style="font-size: 3rem; color: #ddd;"></i>
                                <p class="text-muted mt-3">Belum ada ulasan untuk produk ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Reviews Section -->

    @push("scripts")
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const hasVariants = {{ $produk->jenisProduk->count() > 0 ? "true" : "false" }};
                if (!hasVariants) return;

                const allVariants = JSON.parse('{!! $semuaVariasiJson !!}');
                const variantOptionsContainer = document.getElementById('variant-options');
                const variantRadios = document.querySelectorAll('.variant-radio');
                const variantAlert = document.getElementById('variant-alert');

                const priceElement = document.querySelector('.product-info-price h4');
                const stockElement = document.getElementById('stock-count');
                const productNameElement = document.getElementById('selected-jenis-name');

                const btnAddToCart = document.querySelector('.btn-add-to-cart');
                const btnBuyNow = document.querySelector('.btn-buy-now');
                const qtyInput = document.querySelector('.quantity-product');
                const btnInc = document.querySelector('.btn-increase');
                const btnDec = document.querySelector('.btn-decrease');

                const defaultPrice = '{{ number_format($produk->harga, 0, ",", ".") }}';
                const defaultStock = '{{ $produk->jumlah_produk ?? 0 }}';

                function formatPrice(price) {
                    return new Intl.NumberFormat('id-ID').format(price);
                }

                function getSelectedOptions() {
                    const selected = {};
                    const checkedRadios = document.querySelectorAll('.variant-radio:checked');
                    checkedRadios.forEach(radio => {
                        selected[radio.dataset.attribute] = radio.value;
                    });
                    return selected;
                }

                function findMatchingVariant(selectedOptions) {
                    return allVariants.find(variant => {
                        let isMatch = true;
                        for (const attribute in selectedOptions) {
                            if (variant[attribute] !== selectedOptions[attribute]) {
                                isMatch = false;
                                break;
                            }
                        }
                        return isMatch;
                    });
                }

                function updateSliderByVariant(variant) {
                    if (!variant) return;

                    const swiperMain = document.querySelector('#gallery-swiper-started');
                    if (swiperMain && swiperMain.swiper) {
                        const slides = swiperMain.querySelectorAll('.swiper-slide');
                        let targetIndex = -1;

                        slides.forEach((slide, index) => {
                            if (slide.getAttribute('data-jenis-id') == variant.id) {
                                targetIndex = index;
                            }
                        });

                        if (targetIndex !== -1) {
                            swiperMain.swiper.slideTo(targetIndex);
                        }
                    }
                }

                function updateUI(variant) {
                    if (variant) {
                        // Variasi ditemukan
                        variantAlert.style.display = 'none';
                        priceElement.textContent = 'Rp. ' + formatPrice(variant.harga);
                        stockElement.textContent = variant.stok;

                        let variantName = ` - ${variant.nama || ''} ${variant.warna || ''} ${variant.ukuran || ''}`;
                        productNameElement.textContent = variantName.replace(/\s+/g, ' ').trim();

                        updateSliderByVariant(variant);
                        updateQuantityControls(variant.stok);
                        updateActionButtons(variant);

                    } else {
                        // Kombinasi tidak valid
                        variantAlert.style.display = 'block';
                        priceElement.textContent = 'Rp. ' + defaultPrice;
                        stockElement.textContent = '0';
                        productNameElement.textContent = '';
                        updateQuantityControls(0);
                        updateActionButtons(null); // Disable buttons
                    }
                }

                function updateActionButtons(variant) {
                    const buttons = [btnAddToCart, btnBuyNow];
                    if (variant && variant.stok > 0) {
                        buttons.forEach(btn => {
                            if (!btn) return;
                            btn.style.pointerEvents = '';
                            btn.style.opacity = '';
                            btn.removeAttribute('aria-disabled');
                            if (btn.dataset._originalText) {
                                btn.textContent = btn.dataset._originalText;
                                delete btn.dataset._originalText;
                            }
                            // Update data attributes for cart/buy now
                            btn.setAttribute('data-product-harga', variant.harga);
                            btn.setAttribute('data-product-stok', variant.stok);
                            // GAMBAR TIDAK DIUPDATE, JADI GAMBAR UTAMA YANG DIPAKAI
                            // btn.setAttribute('data-product-gambar', variant.gambar);
                            btn.setAttribute('data-product-jenis-id', variant.id);
                            btn.setAttribute('data-product-jenis-nama',
                                `${variant.nama || ''} ${variant.warna || ''} ${variant.ukuran || ''}`
                                .trim());
                        });
                    } else {
                        buttons.forEach(btn => {
                            if (!btn) return;
                            btn.style.pointerEvents = 'none';
                            btn.style.opacity = '0.6';
                            btn.setAttribute('aria-disabled', 'true');
                            if (!btn.dataset._originalText) {
                                btn.dataset._originalText = btn.textContent.trim();
                            }
                            btn.textContent = (variant && variant.stok <= 0) ? 'Habis' : 'Pilih Variasi';
                        });
                    }
                }

                function updateQuantityControls(stock) {
                    if (!qtyInput) return;
                    let val = parseInt(qtyInput.value, 10);
                    if (isNaN(val) || val < 1) val = 1;

                    if (stock <= 0) {
                        qtyInput.value = 0;
                        if (btnDec) btnDec.disabled = true;
                        if (btnInc) btnInc.disabled = true; // Disable both if no stock
                    } else {
                        if (val > stock) val = stock;
                        qtyInput.value = val;
                        if (btnDec) btnDec.disabled = (val <= 1);
                        if (btnInc) btnInc.disabled = (val >= stock);
                    }
                }

                function handleSelectionChange() {
                    const selectedOptions = getSelectedOptions();
                    const requiredAttributes = Array.from(variantOptionsContainer.querySelectorAll('.product-color'))
                        .map(el => el.querySelector('.title').textContent.toLowerCase());

                    // Hanya cari jika semua atribut sudah dipilih
                    if (Object.keys(selectedOptions).length === requiredAttributes.length) {
                        const matchingVariant = findMatchingVariant(selectedOptions);
                        updateUI(matchingVariant);
                    } else {
                        // Jika belum semua dipilih, reset ke state "Pilih Variasi"
                        updateUI(null);
                    }
                }

                function initialize() {
                    // Coba pilih variasi pertama yang tersedia
                    const firstAvailableVariant = allVariants.find(v => v.stok > 0);
                    if (firstAvailableVariant) {
                        for (const attr in firstAvailableVariant) {
                            if (['nama', 'warna', 'ukuran'].includes(attr) && firstAvailableVariant[attr]) {
                                const radio = document.getElementById(
                                    `variant_${attr}_${CSS.escape(firstAvailableVariant[attr].replace(/\s+/g, '-').toLowerCase())}`
                                    );
                                if (radio) {
                                    radio.checked = true;
                                }
                            }
                        }
                        handleSelectionChange(); // Update UI based on pre-selection
                    } else {
                        // Tidak ada variasi yang tersedia sama sekali
                        updateUI(null);
                    }
                }

                variantRadios.forEach(radio => {
                    radio.addEventListener('change', handleSelectionChange);
                });

                // --- Kontrol Kuantitas ---
                if (btnInc) {
                    btnInc.addEventListener('click', function(e) {
                        e.preventDefault();
                        const stock = parseInt(stockElement.textContent, 10) || 0;
                        let val = parseInt(qtyInput.value, 10) || 0;
                        if (val < stock) {
                            qtyInput.value = val + 1;
                            updateQuantityControls(stock);
                        } else {
                            alert('Stok tidak cukup. Sisa stok: ' + stock);
                        }
                    });
                }

                if (btnDec) {
                    btnDec.addEventListener('click', function(e) {
                        e.preventDefault();
                        let val = parseInt(qtyInput.value, 10) || 1;
                        if (val > 1) {
                            qtyInput.value = val - 1;
                            const stock = parseInt(stockElement.textContent, 10) || 0;
                            updateQuantityControls(stock);
                        }
                    });
                }

                if (qtyInput) {
                    qtyInput.addEventListener('input', function() {
                        const stock = parseInt(stockElement.textContent, 10) || 0;
                        let val = parseInt(this.value.replace(/\D/g, ''), 10) || 1;
                        if (stock <= 0) {
                            this.value = 0;
                        } else if (val > stock) {
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

                // --- Logika Tombol Aksi (Add to Cart & Buy Now) ---
                [btnAddToCart, btnBuyNow].forEach(btn => {
                    if (!btn) return;

                    const isBuyNow = btn.classList.contains('btn-buy-now');

                    btn.addEventListener('click', function(e) {
                        const hasSelectedVariant = btn.hasAttribute('data-product-jenis-id');
                        if (!hasSelectedVariant) {
                            e.preventDefault();
                            e.stopPropagation();
                            alert('Silakan pilih variasi produk terlebih dahulu.');
                            return;
                        }

                        const stock = parseInt(btn.getAttribute('data-product-stok'), 10) || 0;
                        const qty = parseInt(qtyInput.value, 10) || 0;

                        if (stock <= 0 || qty <= 0) {
                            e.preventDefault();
                            e.stopPropagation();
                            alert('Stok produk tidak tersedia atau jumlah tidak valid.');
                            return;
                        }
                        if (qty > stock) {
                            e.preventDefault();
                            e.stopPropagation();
                            alert('Jumlah yang dipilih melebihi sisa stok (' + stock + ').');
                            return;
                        }

                        // Jika ini tombol Beli Sekarang, handle redirect
                        if (isBuyNow) {
                            e.preventDefault();
                            const product = {
                                id: parseInt(btn.dataset.productId),
                                nama: btn.dataset.productNama,
                                harga: parseInt(btn.dataset.productHarga),
                                gambar: btn.dataset.productGambar,
                                kategori: btn.dataset.productKategori,
                                quantity: qty,
                                jenis_id: parseInt(btn.dataset.productJenisId),
                                jenis_nama: btn.dataset.productJenisNama,
                            };
                            try {
                                localStorage.setItem('ria_shopping_cart', JSON.stringify([product]));
                                window.location.href = '{{ route("checkout") }}';
                            } catch (err) {
                                console.error('Gagal menyimpan cart ke localStorage', err);
                                alert('Terjadi kesalahan saat memproses pembelian. Coba lagi.');
                            }
                        }
                        // Jika ini tombol Add to Cart, biarkan event default (buka offcanvas) berjalan
                    });
                });

                initialize();
            });

            // Fungsi minPembelian tetap ada jika masih relevan
            function minPembelian() {
                const minBeli = document.querySelector('.btn-add-to-cart')?.getAttribute('data-min-beli') || 1;
                const quantityInput = document.querySelector('.quantity-product');
                if (!quantityInput) return true;

                let currentQty = parseInt(quantityInput.value, 10) || 1;
                if (currentQty < minBeli) {
                    const ok = confirm('Jumlah pembelian minimal adalah ' + minBeli +
                        '.\nTekan OK untuk melanjutkan pembelian, atau Batal untuk membatalkan.');
                    if (ok) {
                        quantityInput.value = minBeli;
                        const stock = parseInt(document.getElementById('stock-count').textContent, 10) || 0;
                        // Panggil fungsi update quantity controls jika ada
                        if (typeof updateQuantityControls === 'function') {
                            updateQuantityControls(stock);
                        }
                        return true;
                    } else {
                        return false; // Mencegah aksi selanjutnya jika dibatalkan
                    }
                }
                return true; // Lanjutkan jika kuantitas sudah memenuhi
            }
        </script>
    @endpush
@endsection

@section("footer")
    @include("partials.footer")
@endsection
