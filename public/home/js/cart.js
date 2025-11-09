/**
 * Shopping Cart Management with localStorage
 * Aksesoris Ria - Cart System
 */

class ShoppingCart {
    constructor() {
        this.storageKey = "ria_shopping_cart";
        this.init();
    }

    init() {
        this.renderCart();
        this.attachEventListeners();
        this.updateCartCount();
    }

    // Get cart from localStorage
    getCart() {
        const cart = localStorage.getItem(this.storageKey);
        return cart ? JSON.parse(cart) : [];
    }

    // Save cart to localStorage
    saveCart(cart) {
        localStorage.setItem(this.storageKey, JSON.stringify(cart));
        this.updateCartCount();
        this.renderCart();
    }

    // Add item to cart
    addToCart(product) {
        let cart = this.getCart();
        const existingItemIndex = cart.findIndex(
            (item) =>
                item.id === product.id && item.jenis_id === product.jenis_id
        );

        if (existingItemIndex > -1) {
            // Update quantity if item exists
            cart[existingItemIndex].quantity += product.quantity;
        } else {
            // Add new item
            cart.push({
                id: product.id,
                nama: product.nama,
                harga: product.harga,
                quantity: product.quantity,
                gambar: product.gambar,
                kategori: product.kategori,
                jenis_id: product.jenis_id || null,
                jenis_nama: product.jenis_nama || null,
            });
        }

        this.saveCart(cart);
        this.showNotification(
            "Produk berhasil ditambahkan ke keranjang!",
            "success"
        );
    }

    // Update item quantity
    updateQuantity(productId, jenisId, quantity) {
        let cart = this.getCart();
        const itemIndex = cart.findIndex(
            (item) => item.id === productId && item.jenis_id === jenisId
        );

        if (itemIndex > -1) {
            if (quantity <= 0) {
                this.removeFromCart(productId, jenisId);
            } else {
                cart[itemIndex].quantity = quantity;
                this.saveCart(cart);
            }
        }
    }

    // Remove item from cart
    removeFromCart(productId, jenisId) {
        let cart = this.getCart();
        cart = cart.filter(
            (item) => !(item.id === productId && item.jenis_id === jenisId)
        );
        this.saveCart(cart);
        this.showNotification("Produk dihapus dari keranjang", "info");
    }

    // Clear cart
    clearCart() {
        localStorage.removeItem(this.storageKey);
        this.updateCartCount();
        this.renderCart();
    }

    // Get cart total
    getCartTotal() {
        const cart = this.getCart();
        return cart.reduce(
            (total, item) => total + item.harga * item.quantity,
            0
        );
    }

    // Get cart item count
    getCartItemCount() {
        const cart = this.getCart();
        return cart.reduce((total, item) => total + item.quantity, 0);
    }

    // Update cart count in UI
    updateCartCount() {
        const count = this.getCartItemCount();
        const cartCountElements = document.querySelectorAll(
            ".count-box, .count-cart"
        );

        cartCountElements.forEach((element) => {
            element.textContent = count;
            if (count > 0) {
                element.style.display = "flex";
            } else {
                element.style.display = "none";
            }
        });
    }

    // Render cart in offcanvas
    renderCart() {
        const cart = this.getCart();
        const cartContainer = document.querySelector(
            "#shoppingCart .product-list-wrap"
        );
        const emptyCart = document.querySelector(
            "#shoppingCart .minicart-empty"
        );
        const cartFooter = document.querySelector(
            "#shoppingCart .popup-footer"
        );

        if (!cartContainer) return;

        if (cart.length === 0) {
            cartContainer.innerHTML = "";
            if (emptyCart) emptyCart.style.display = "block";
            if (cartFooter) cartFooter.style.display = "none";
        } else {
            if (emptyCart) emptyCart.style.display = "none";
            if (cartFooter) cartFooter.style.display = "block";

            cartContainer.innerHTML = cart
                .map(
                    (item) => `
                <li class="file-delete">
                    <div class="card-product style-row row-small-2 align-items-center">
                        <div class="card-product-wrapper">
                            <a href="/produk/${item.id}" class="product-img">
                                <img class="lazyload" src="${
                                    item.gambar
                                }" alt="${item.nama}">
                            </a>
                        </div>
                        <div class="card-product-info">
                            <div class="box-title">
                                <a href="/produk/${
                                    item.id
                                }" class="name-product body-md-2 fw-semibold text-secondary link">
                                    ${item.nama}
                                </a>
                                ${
                                    item.jenis_nama
                                        ? `<p class="body-text-3 text-secondary mb-1">${item.jenis_nama}</p>`
                                        : ""
                                }
                                <p class="price-wrap fw-medium">
                                    <span class="new-price price-text fw-medium">Rp. ${this.formatPrice(
                                        item.harga
                                    )}</span>
                                </p>
                                <div class="wg-quantity mt-2">
                                    <button class="btn-quantity btn-decrease-cart"
                                        data-id="${item.id}"
                                        data-jenis="${item.jenis_id || ""}">
                                        <i class="icon-minus"></i>
                                    </button>
                                    <input class="quantity-product" type="text"
                                        value="${item.quantity}"
                                        data-id="${item.id}"
                                        data-jenis="${item.jenis_id || ""}"
                                        readonly>
                                    <button class="btn-quantity btn-increase-cart"
                                        data-id="${item.id}"
                                        data-jenis="${item.jenis_id || ""}">
                                        <i class="icon-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <span class="icon-close remove remove-cart link"
                            data-id="${item.id}"
                            data-jenis="${item.jenis_id || ""}"></span>
                    </div>
                </li>
            `
                )
                .join("");

            // Update total
            const totalElement = document.querySelector(
                "#shoppingCart .cart-total .tf-totals-price"
            );
            if (totalElement) {
                totalElement.textContent = `Rp. ${this.formatPrice(
                    this.getCartTotal()
                )}`;
            }

            // Attach event listeners to new elements
            this.attachCartItemEvents();
        }
    }

    // Format price to Indonesian format
    formatPrice(price) {
        return new Intl.NumberFormat("id-ID").format(price);
    }

    // Attach event listeners to cart items
    attachCartItemEvents() {
        // Remove buttons
        document.querySelectorAll(".remove-cart").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                const id = parseInt(btn.dataset.id);
                const jenisId = btn.dataset.jenis
                    ? parseInt(btn.dataset.jenis)
                    : null;
                this.removeFromCart(id, jenisId);
            });
        });

        // Increase quantity
        document.querySelectorAll(".btn-increase-cart").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                const id = parseInt(btn.dataset.id);
                const jenisId = btn.dataset.jenis
                    ? parseInt(btn.dataset.jenis)
                    : null;
                const input =
                    btn.parentElement.querySelector(".quantity-product");
                const currentQty = parseInt(input.value);
                this.updateQuantity(id, jenisId, currentQty + 1);
            });
        });

        // Decrease quantity
        document.querySelectorAll(".btn-decrease-cart").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                const id = parseInt(btn.dataset.id);
                const jenisId = btn.dataset.jenis
                    ? parseInt(btn.dataset.jenis)
                    : null;
                const input =
                    btn.parentElement.querySelector(".quantity-product");
                const currentQty = parseInt(input.value);
                if (currentQty > 1) {
                    this.updateQuantity(id, jenisId, currentQty - 1);
                }
            });
        });
    }

    // Attach global event listeners
    attachEventListeners() {
        // Add to cart buttons
        document.querySelectorAll(".btn-add-to-cart").forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();
                this.handleAddToCart(btn);
            });
        });
    }

    // Handle add to cart from product detail page
    handleAddToCart(btn) {
        const productData = {
            id: parseInt(btn.dataset.productId),
            nama: btn.dataset.productNama,
            harga: parseInt(btn.dataset.productHarga),
            gambar: btn.dataset.productGambar,
            kategori: btn.dataset.productKategori,
            quantity: 1,
            jenis_id: null,
            jenis_nama: null,
        };

        // Get quantity from input
        const quantityInput = document.querySelector(".quantity-product");
        if (quantityInput) {
            productData.quantity = parseInt(quantityInput.value) || 1;
        }

        // Get jenis if exists
        const jenisSelect = document.querySelector(".select-color");
        if (jenisSelect) {
            const selectedOption =
                jenisSelect.options[jenisSelect.selectedIndex];
            productData.jenis_id = parseInt(jenisSelect.value);
            productData.jenis_nama = selectedOption.text;
        }

        this.addToCart(productData);
    }

    // Show notification
    showNotification(message, type = "success") {
        // Create notification element
        const notification = document.createElement("div");
        notification.className = `cart-notification alert alert-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 15px 20px;
            background: ${type === "success" ? "#28a745" : "#17a2b8"};
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease-out;
        `;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = "slideOut 0.3s ease-out";
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Prepare data for checkout
    prepareCheckoutData() {
        const cart = this.getCart();
        const total = this.getCartTotal();

        return {
            items: cart,
            subtotal: total,
            total: total,
            itemCount: this.getCartItemCount(),
        };
    }
}

// Add CSS animations
const style = document.createElement("style");
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Initialize cart when DOM is ready
let cart;

function initCart() {
    cart = new ShoppingCart();
    window.cart = cart;
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCart);
} else {
    initCart();
}

// Export for use in other scripts
window.ShoppingCart = ShoppingCart;
