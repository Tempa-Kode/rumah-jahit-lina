@extends("template")
@section("title", "Checkout - Aksesoris Ria")

@section("body")
    <!-- Breakcrumbs -->
    <div class="tf-sp-3 pb-0">
        <div class="container">
            <ul class="breakcrumbs">
                <li><a href="{{ route("home") }}" class="body-small link">Home</a></li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li><a href="{{ route("cart") }}" class="body-small link">Keranjang</a></li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li><span class="body-small">Checkout</span></li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <!-- Checkout -->
    <section class="tf-sp-2">
        <div class="container">
            <div class="checkout-status tf-sp-2 pt-0">
                <div class="checkout-wrap">
                    <span class="checkout-bar next"></span>
                    <div class="step-payment">
                        <span class="icon">
                            <i class="icon-shop-cart-1"></i>
                        </span>
                        <a href="{{ route("cart") }}" class="link body-text-3">Keranjang Belanja</a>
                    </div>
                    <div class="step-payment active">
                        <span class="icon">
                            <i class="icon-shop-cart-2"></i>
                        </span>
                        <span class="text-secondary body-text-3">Checkout</span>
                    </div>
                    <div class="step-payment">
                        <span class="icon">
                            <i class="icon-shop-cart-3"></i>
                        </span>
                        <span class="link-secondary body-text-3">Konfirmasi</span>
                    </div>
                </div>
            </div>

            <div class="tf-checkout-wrap flex-lg-nowrap">
                <div class="page-checkout">
                    @if ($customer)
                        <div class="wrap">
                            <h5 class="title has-account">
                                <span class="fw-semibold">Informasi Akun</span>
                            </h5>
                            <div class="alert alert-info">
                                <p class="mb-0">Anda login sebagai: <strong>{{ $customer->nama }}</strong></p>
                                <p class="mb-0 small">Email: {{ $customer->email }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="wrap">
                        <h5 class="title fw-semibold">Informasi Pengiriman</h5>
                        <form id="checkout-form" class="def">
                            @csrf
                            <div class="cols">
                                <fieldset>
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" value="{{ $customer->nama ?? "" }}"
                                        placeholder="Nama lengkap Anda" required>
                                </fieldset>
                            </div>
                            <fieldset>
                                <label>Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="tel" name="no_hp" value="{{ $customer->no_hp ?? "" }}"
                                    placeholder="08xx xxxx xxxx" required>
                            </fieldset>
                            <fieldset>
                                <label>Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="alamat" rows="4" placeholder="Alamat lengkap untuk pengiriman" required>{{ $customer->alamat ?? "" }}</textarea>
                            </fieldset>
                        </form>
                    </div>

                    <div class="wrap">
                        <h5 class="title fw-semibold">Metode Pembayaran</h5>
                        <div class="form-payment">
                            <div class="payment-box" id="payment-box">
                                <div class="payment-item payment-choose-card active">
                                    <label for="bank-transfer-method" class="payment-header" data-bs-toggle="collapse"
                                        data-bs-target="#bank-transfer-payment" aria-controls="bank-transfer-payment"
                                        aria-expanded="true">
                                        <input type="radio" name="payment-method" class="d-none tf-check-rounded"
                                            id="bank-transfer-method" checked="">
                                        <p class="select-payment">
                                            Trasnfer Bank / QRIS
                                        </p>
                                    </label>
                                    <div id="bank-transfer-payment" class="collapse show" data-bs-parent="#payment-box">
                                        <div class="payment-body">
                                            <div class="alert alert-warning mb-3">
                                                <p class="mb-2 body-text-3"><strong>Transfer ke:</strong></p>
                                                <p class="mb-1 body-text-4">Bank BRI: 5322 0101 5797 536</p>
                                                <p class="mb-2 body-text-4">a.n. Riahma Uli Br Saragih</p>
                                                <p class="mb-2 body-text-4 mt-2">Atau <strong>scan QRIS</strong> berikut:</p>
                                                <img src="{{ asset('home/images/qris.jpg') }}" alt="qris" class="w-50">
                                                <p class="mb-0 caption text-main-2">
                                                    Silakan transfer sesuai total pembayaran dan upload bukti transfer.
                                                </p>
                                            </div>
                                            <fieldset>
                                                <label>Upload Bukti Transfer <span class="text-danger">*</span></label>
                                                <input type="file" name="bukti_transfer" id="bukti_transfer"
                                                    accept="image/*" class="def form-control" required>
                                                <p class="caption text-main-2 mt-1">Format: JPG, PNG, JPEG (Max: 2MB)</p>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-btn">
                                <button type="button" id="btn-place-order" class="tf-btn w-100">
                                    <span class="text-white">Buat Pesanan</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flat-sidebar-checkout">
                    <div class="sidebar-checkout-content">
                        <h5 class="fw-semibold">Ringkasan Pesanan</h5>
                        <ul class="list-product" id="checkout-summary">
                            <!-- Items will be dynamically inserted -->
                        </ul>
                        <ul class="sec-total-price">
                            <li><span class="body-text-3">Subtotal</span><span class="body-text-3"
                                    id="checkout-subtotal">Rp. 0</span></li>
                            <li><span class="body-md-2 fw-semibold">Total</span><span
                                    class="body-md-2 fw-semibold text-primary" id="checkout-total">Rp. 0</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Checkout -->

    @push("scripts")
        <script>
            // Format price helper
            function formatPrice(price) {
                return new Intl.NumberFormat('id-ID').format(price);
            }

            // Render checkout summary
            function renderCheckoutSummary() {
                // Get cart from localStorage directly
                const cartData = localStorage.getItem('ria_shopping_cart');
                const cart = cartData ? JSON.parse(cartData) : [];

                const checkoutSummary = document.getElementById('checkout-summary');
                const checkoutSubtotal = document.getElementById('checkout-subtotal');
                const checkoutTotal = document.getElementById('checkout-total');

                if (cart.length === 0) {
                    window.location.href = '{{ route("cart") }}';
                    return;
                }

                // Render items using template structure
                checkoutSummary.innerHTML = cart.map(item => {
                    const itemTotal = parseInt(item.harga) * parseInt(item.quantity);
                    return `
                <li class="item-product">
                    <a href="#" class="img-product">
                        <img src="${item.gambar}" alt="${item.nama}">
                    </a>
                    <div class="content-box">
                        <a href="#" class="link-secondary body-md-2 fw-semibold">
                            ${item.nama}
                        </a>
                        <p class="price-quantity price-text fw-semibold">
                            Rp. ${formatPrice(itemTotal)}
                            <span class="body-md-2 text-main-2 fw-normal">X${item.quantity}</span>
                        </p>
                        ${item.jenis_nama ? `<p class="body-md-2 text-main-2">${item.jenis_nama}</p>` : ''}
                    </div>
                </li>
            `;
                }).join('');

                // Calculate and update totals
                const total = cart.reduce((sum, item) => {
                    return sum + (parseInt(item.harga) * parseInt(item.quantity));
                }, 0);

                checkoutSubtotal.textContent = `Rp. ${formatPrice(total)}`;
                checkoutTotal.textContent = `Rp. ${formatPrice(total)}`;
            }

            // Process checkout
            document.getElementById('btn-place-order').addEventListener('click', function() {
                const form = document.getElementById('checkout-form');

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                // Check payment method
                const paymentMethod = document.querySelector('input[name="payment-method"]:checked');
                const buktiTransferInput = document.getElementById('bukti_transfer');

                // Validate bukti transfer if bank transfer is selected
                if (paymentMethod && paymentMethod.id === 'bank-transfer-method') {
                    if (!buktiTransferInput.files || buktiTransferInput.files.length === 0) {
                        alert('Silakan upload bukti transfer!');
                        buktiTransferInput.focus();
                        return;
                    }

                    // Validate file size (max 2MB)
                    const file = buktiTransferInput.files[0];
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file maksimal 2MB!');
                        buktiTransferInput.value = '';
                        return;
                    }
                }

                // Get cart from localStorage
                const cartData = localStorage.getItem('ria_shopping_cart');
                const cart = cartData ? JSON.parse(cartData) : [];

                if (cart.length === 0) {
                    alert('Keranjang belanja kosong!');
                    return;
                }

                // Disable button
                this.disabled = true;
                this.innerHTML = '<span class="text-white">Memproses...</span>';

                // Prepare FormData with file upload
                const formData = new FormData(form);
                formData.append('cart_data', JSON.stringify(cart));

                // Add bukti transfer if exists
                if (buktiTransferInput.files && buktiTransferInput.files.length > 0) {
                    formData.append('bukti_transfer', buktiTransferInput.files[0]);
                }

                // Send to server
                fetch('{{ route("checkout.process") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token')
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Clear cart from localStorage
                            localStorage.removeItem('ria_shopping_cart');

                            // Clear cart object if available
                            if (window.cart) {
                                window.cart.clearCart();
                            }

                            // Show success message
                            alert('Pesanan berhasil dibuat! Kode Invoice: ' + data.kode_invoice);

                            // Redirect to order confirmation
                            window.location.href = data.redirect_url;
                        } else {
                            alert('Terjadi kesalahan: ' + data.message);
                            this.disabled = false;
                            this.innerHTML = '<span class="text-white">Buat Pesanan</span>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memproses pesanan');
                        this.disabled = false;
                        this.innerHTML = '<span class="text-white">Buat Pesanan</span>';
                    });
            });

            // Toggle bukti transfer required based on payment method
            document.querySelectorAll('input[name="payment-method"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const buktiTransferInput = document.getElementById('bukti_transfer');
                    if (this.id === 'bank-transfer-method') {
                        buktiTransferInput.setAttribute('required', 'required');
                    } else {
                        buktiTransferInput.removeAttribute('required');
                    }
                });
            });

            // Initial render - wait for DOM
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(renderCheckoutSummary, 100);
                });
            } else {
                setTimeout(renderCheckoutSummary, 100);
            }
        </script>
    @endpush
@endsection
