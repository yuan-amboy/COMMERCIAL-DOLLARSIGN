document.addEventListener("DOMContentLoaded", function () {

    // Menu Elements
    const menuToggle = document.getElementById("menu-toggle");
    const menuIcon = document.querySelector(".menu-icon");
    const closeIcon = document.querySelector(".close-icon");
    const menuSection = document.querySelector(".menu-section");
    const searchInput = document.getElementById("search-input");

    // Shop Elements
    const shopItems = document.getElementById("shop-items");
    const shopSearchInput = document.getElementById("shop-search-input");

    // MENU TOGGLE
    menuIcon.style.display = "block";
    closeIcon.style.display = "none";

    function toggleMenu() {
        menuSection.classList.toggle("active");
        const isActive = menuSection.classList.contains("active");
        menuIcon.style.display = isActive ? "none" : "block";
        closeIcon.style.display = isActive ? "block" : "none";
    }

    menuToggle.addEventListener("click", (event) => {
        event.stopPropagation();
        toggleMenu();
    });

    document.addEventListener("click", (event) => {
        if (!menuSection.contains(event.target) && !menuToggle.contains(event.target)) {
            menuSection.classList.remove("active");
            menuIcon.style.display = "block";
            closeIcon.style.display = "none";
        }
    });

    // MENU SEARCH BAR
    searchInput.addEventListener("keypress", (event) => {
        if (event.key === "Enter" && searchInput.value.trim()) {
            window.location.href = `shop.php?search=${encodeURIComponent(searchInput.value.trim())}`;
        }
    });

    // SHOP
    function loadProducts() {
        if (products && Array.isArray(products)) {
            displayProducts(products);
        } else {
            console.error("Error: Product data is not available.");
        }
    }

    if (window.location.pathname.includes("shop.php")) {
        loadProducts();
    }

    function displayProducts(productList) {
        if (!shopItems) return;

        shopItems.innerHTML = productList.map(product => `
            <a href="product.php?product=${encodeURIComponent(product.name)}" class="product-link">
                <div class="product-container">
                    <div class="product-card"
                         onmouseover="this.querySelector('.product-image').src='${product.imageBack || product.imageFront}'"
                         onmouseout="this.querySelector('.product-image').src='${product.imageFront}'">
                        <img src="${product.imageFront}" alt="${product.name}" class="product-image" style="transition: 0.3s ease;">
                        <p class="name">${product.name}</p>
                        <p class="price">${product.price}</p>
                    </div>
                </div>
            </a>
        `).join("");
    }

// SHOP SEARCH BAR
function filterShopItems(query) {
    const lowerCaseQuery = query.toLowerCase();
    let hasVisibleItems = false; // Track if there are any visible items

    document.querySelectorAll(".product-card").forEach(item => {
        const nameElement = item.querySelector(".name");
        if (nameElement) {
            const itemName = nameElement.innerText.toLowerCase();
            if (itemName.includes(lowerCaseQuery)) {
                item.style.display = "block"; // Show item if it matches
                hasVisibleItems = true; // At least one item is visible
            } else {
                item.style.display = "none"; // Hide item if it doesn't match
            }
        } else {
            item.style.display = "none"; // Hide item if there's no name element
        }
    });

    // Optionally, you can handle the case where no items are visible
    if (!hasVisibleItems) {
        // You can show a message or handle the UI accordingly
        console.log("No items found for your search.");
    }
}

if (shopSearchInput) {
    shopSearchInput.addEventListener("input", () => filterShopItems(shopSearchInput.value));

    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get("search");
    if (searchQuery) {
        shopSearchInput.value = searchQuery;
        filterShopItems(searchQuery);
    }
}

    // NEW ARRIVAL
    const newArrivalSection = document.getElementById("newArrivalSection");
    if (newArrivalSection) fetchNewArrivals();

    function fetchNewArrivals() {
        if (typeof clothingData === "undefined" || !Array.isArray(clothingData)) {
            console.error("clothingData is not available or invalid.");
            return;
        }

        const newArrivals = clothingData.filter(product => product.isNew);

        if (newArrivals.length === 0) {
            console.warn("No new arrivals found.");
            return;
        }

        newArrivals.slice(0, 8).forEach(product => {
            const productLink = document.createElement("a");
            productLink.href = `product.php?product=${encodeURIComponent(product.name)}`;
            productLink.className = "product-link";

            const productContainer = document.createElement("div");
            productContainer.className = "product-container";

            const productCard = document.createElement("div");
            productCard.className = "product-card";

            productCard.addEventListener("mouseover", () => {
                productImage.src = product.imageBack || product.imageFront;
            });
            productCard.addEventListener("mouseout", () => {
                productImage.src = product.imageFront;
            });

            const productImage = document.createElement("img");
            productImage.src = product.imageFront;
            productImage.alt = product.name;
            productImage.className = "product-image";
            productImage.style.transition = "0.3s ease";

            const productName = document.createElement("p");
            productName.className = "name";
            productName.textContent = product.name;

            const productPrice = document.createElement("p");
            productPrice.className = "price";
            productPrice.textContent = product.price;

            const productDescription = document.createElement("p");
            productDescription.className = "description";
            productDescription.textContent = product.description;

            productCard.appendChild(productImage);
            productCard.appendChild(productName);
            productCard.appendChild(productPrice);
            productCard.appendChild(productDescription);
            productContainer.appendChild(productCard);
            productLink.appendChild(productContainer);
            newArrivalSection.appendChild(productLink);
        });
    }

    // Function to update the cart count badge
    function updateCartCount() {
        const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
        const cartCount = document.getElementById('cart-count');
        cartCount.textContent = cartItems.length; // Display total items
    }

    // Ensure cart updates when pages load
    document.addEventListener('DOMContentLoaded', updateCartCount);

    // CART
    const cartPanel = document.getElementById('cart-panel');
    const closeCartBtn = document.getElementById('close-cart');
    const cartContainer = document.getElementById('cart-items');
    const cartIcon = document.querySelector('.cart-icon');

    // Ensure elements exist before adding listeners
    if (!cartPanel || !closeCartBtn || !cartContainer || !cartIcon) {
        console.error("One or more cart elements not found!");
        return;
    }

    // Open Cart
    cartIcon.addEventListener('click', () => {
        cartPanel.classList.add('open');
    });

    // Close Cart
    closeCartBtn.addEventListener('click', () => {
        cartPanel.classList.remove('open');
    });

    let total = 0;
    cartItems.forEach((item, index) => {
        const itemElement = document.createElement('div');
        itemElement.className = 'cart-item';
        itemElement.innerHTML = `
            <img src="${item.image}" alt="${item.name}" class="cart-item-img">
            <div>
                <p>${item.name}</p>
                <p>₱${item.price.toFixed(2)}</p>
                <p>Qty: ${item.quantity}</p>
                <button class="remove-btn" data-index="${index}">Remove</button>
            </div>
        `;
        cartContainer.appendChild(itemElement);
        total += item.price * item.quantity;
    });

    const cartSummary = document.createElement('div');
    cartSummary.className = 'cart-summary';
    cartSummary.innerHTML = `
        <p>Total: ₱<span id="cart-total">${total.toFixed(2)}</span></p>
        <button id="checkout-btn">Proceed to Checkout</button>
    `;
    cartContainer.appendChild(cartSummary);

    // Remove item from cart
    cartContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-btn')) {
            const index = e.target.dataset.index;
            removeFromCart(index);
        }
    });

    function removeFromCart(index) {
        let cartItems = JSON.parse(localStorage.getItem('cart')) || [];
        cartItems.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cartItems));
        window.location.reload(); // Refresh the panel
    }
});