<!-- Navigation Bar -->
<header>
    <div class="nav-wrapper">
        <nav class="navbar">
            <div class="nav-container">
                <button id="menu-toggle" class="menu-button">
                    <img src="images/menu-icon.png" alt="Menu" class="menu-icon">
                    <img src="images/close-icon.png" alt="Close" class="close-icon">
                </button>   

                <a href="index.php">
                    <img src="images/logo.png" alt="DollarSign Logo" class="logo">
                </a>

                <div class="nav-icons">
                    <?php if ($isLoggedIn): ?>
                        <a href="account.php">
                            <img src="images/user-icon.png" alt="Account" class="user-icon">
                        </a>
                    <?php else: ?>
                        <a href="login.php">
                        <img src="images/user-icon.png" alt="Login" class="user-icon">
                    </a>
                    <?php endif; ?>

                    <div class="cart-container">
                        <img src="images/cart-icon.png" alt="Cart" class="cart-icon">
                        <span id="cart-count" class="cart-badge">0</span>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Menu -->
         <div class="menu-section">
            <div class="menu-search">
                <input type="text" id="search-input" placeholder="Search...">
            </div>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="shop.php">SHOP</a></li>
                <li><a href="about-us.php">ABOUT US</a></li>
                <li><a href="how-to-order.php">HOW TO ORDER</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Sliding Cart Panel -->
    <div id="cart-panel" class="cart-panel">
        <div class="cart-header">
            <h2>Your Cart</h2>
            <button id="close-cart" class="close-cart">&times;</button>
        </div>

        <div id="cart-items" class="cart-items"></div>

        <div id="cart-summary" class="cart-summary" style="display: none;">
            <p>Total: ₱<span id="cart-total">0.00</span></p>
            <button id="checkout-btn">PROCEED TO CHECKOUT</button>
        </div>

        <div id="continue-shopping" class="continue-shopping" style="display: none;">
            <a href="javascript:void(0)" onclick="closeCart()">Continue shopping</a>
        </div>
    </div>

    <div id="overlay" class="overlay"></div>

    <style>
/* Navigation Bar */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 78px;
    background-color: #111111;
    padding: 0 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    transition: height 0.3s ease, padding 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.nav-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    max-width: 1200px;
    transition: all 0.3s ease;
}

.logo {
    height: 45px;
    cursor: pointer;
    display: block;
    filter: invert(1);
    transition: height 0.3s ease, transform 0.3s ease;
}

.logo:hover {
    transform: scale(1.05);
}

.nav-icons {
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.nav-icons img {    
    width: 25px; 
    height: 25px;
    transition: all 0.3s ease;
}

.nav-icons img:hover {
    opacity: 0.7;
    transform: scale(1.1);
}

.cart-icon {
    position: relative; /* This makes the badge position relative to the icon */
    display: inline-block;
    margin-right: 20px;
    filter: invert(1);
    transition: all 0.3s ease;
}

.user-icon {
    margin-right: 30px;
    filter: invert(1);
    transition: all 0.3s ease;
}

.user-icon, .cart-icon {
    width: 25px;
    height: 25px;
    display: block;
    cursor: pointer;
}

/* Menu Button */
#menu-toggle {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

#menu-toggle:hover {
    transform: scale(1.1);
}

.menu-button {
    background: none;
    border: none;
    cursor: pointer;
    margin-left: 20px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.menu-button img {
    width: 25px;
    height: auto;
    display: block;
    filter: invert(1);
    transition: all 0.3s ease;
}

.menu-button img:hover {
    opacity: 0.7;
    transform: rotate(5deg);
}

.menu-icon {
    display: block;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.close-icon {
    display: none;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.menu-section.active ~ .nav-wrapper .menu-button .menu-icon {
    display: none;
}

.menu-section.active ~ .nav-wrapper .menu-button .close-icon {
    display: block;
    animation: rotateIn 0.3s ease-out;
}

@keyframes rotateIn {
    from {
        transform: rotate(-90deg);
        opacity: 0;
    }
    to {
        transform: rotate(0);
        opacity: 1;
    }
}

/* Media Queries for Responsiveness */
@media screen and (max-width: 768px) {
    .navbar {
        height: 60px;
        padding: 0 15px;
    }
    
    .logo {
        height: 35px;
    }
    
    .nav-icons img,
    .user-icon,
    .cart-icon,
    .menu-button img {
        width: 22px;
        height: 22px;
    }
    
    .user-icon {
        margin-right: 20px;
    }
    
    .cart-icon {
        margin-right: 15px;
    }
}

@media screen and (max-width: 480px) {
    .navbar {
        height: 55px;
        padding: 0 10px;
    }
    
    .logo {
        height: 30px;
    }
    
    .nav-icons img,
    .user-icon,
    .cart-icon,
    .menu-button img {
        width: 20px;
        height: 20px;
    }
    
    .user-icon {
        margin-right: 15px;
    }
    
    .cart-icon {
        margin-right: 12px;
    }
    
    .menu-button {
        margin-left: 12px;
    }
}
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', updateCartBadge);

        const cartPanel = document.getElementById('cart-panel');
        const closeCartButton = document.getElementById('close-cart');
        const overlay = document.getElementById('overlay');
        const cartContainer = document.getElementById('cart-items');

        // Open cart
        document.querySelector('.cart-icon').addEventListener('click', () => {
            loadCart();
            cartPanel.classList.add('open');
            overlay.style.display = 'block';
        });

        // Close cart
        function closeCart() {
            cartPanel.classList.remove('open');
            overlay.style.display = 'none';
        }

        closeCartButton.addEventListener('click', closeCart);
        overlay.addEventListener('click', closeCart);

        // Update cart badge
        function updateCartBadge() {
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
            const cartCount = document.getElementById('cart-count');

            const totalQuantity = cartItems.reduce((sum, item) => sum + item.quantity, 0);

            cartCount.textContent = totalQuantity;
            cartCount.style.display = totalQuantity > 0 ? 'flex' : 'none';
        }

        // Load cart with updated quantity UI
        function loadCart() {
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
            const cartTotal = document.getElementById('cart-total');
            const cartSummary = document.getElementById('cart-summary');
            const continueShopping = document.getElementById('continue-shopping');

            cartContainer.innerHTML = '';

            if (cartItems.length === 0) {
                continueShopping.style.display = 'block';
                cartSummary.style.display = 'none';
                return;
            }

            let total = 0;
            cartItems.forEach((item, index) => {
                const itemElement = document.createElement('div');
                itemElement.className = 'cart-item';
                itemElement.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                    <div>
                        <p><b>${item.name} (${item.size})</b></p>
                        <p>₱${item.price.toFixed(2)}</p>
                        <div class="quantity-container">
                            <button class="quantity-btn" onclick="adjustQuantity(${index}, -1)">
                                ${item.quantity === 1 ? '🗑️' : '−'}
                            </button>
                            <span>${item.quantity}</span>
                            <button class="quantity-btn" onclick="adjustQuantity(${index}, 1)">+</button>
                        </div>
                    </div>
                `;
                cartContainer.appendChild(itemElement);

                total += item.price * item.quantity;
            });

            cartTotal.textContent = total.toFixed(2);
            cartSummary.style.display = 'block';
        }

        // Adjust item quantity
        function adjustQuantity(index, change) {
            let cartItems = JSON.parse(localStorage.getItem('cart')) || [];

            if (cartItems[index].quantity + change <= 0) {
                cartItems.splice(index, 1); // Remove if quantity drops to 0
            } else {
                cartItems[index].quantity += change;
            }

            localStorage.setItem('cart', JSON.stringify(cartItems));
            loadCart();
            updateCartBadge();
        }

        // Handle Proceed to Checkout
        document.getElementById('checkout-btn').addEventListener('click', () => {
            const cartItems = JSON.parse(localStorage.getItem('cart')) || [];

            if (cartItems.length === 0) {
                alert('Your cart is empty!');
            return;
        }

        // Store cart data temporarily for checkout
        localStorage.setItem('checkoutCart', JSON.stringify(cartItems));

        // Redirect to the checkout page
        window.location.href = 'checkout.php';
    });
</script>
</header>