<?php
session_start();
$productName = isset($_GET['product']) ? $_GET['product'] : '';
$isLoggedIn = isset($_SESSION["users"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOLLARSIGN</title>
    <link rel="stylesheet" href="main.css">
    <script src="clothingData.js"></script>
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
<?php include("navbar.php"); ?>
    
    <!-- Product Details Section -->
    <div class="product-detail-container">
    <div class="product-media">
        <img id="product-image" src="" alt="Product Image" class="product-image">
    </div>

    <!-- Product Information -->
    <div class="product-info">
        <h1 id="product-name" class="product-title"></h1>
        <p id="product-price" class="product-price"></p>
        <p class="free-shipping">FREE SHIPPING</p>
        <p id="product-description" class="product-description"></p>
        
        <div class="product-options">
            <label>SIZE</label>
            <div id="size-options">
                <button class="size-button">S</button>
                <button class="size-button">M</button>
                <button class="size-button">L</button>
                <button class="size-button">XL</button>
                <button class="size-button">XXL</button>
            </div>
        </div>
        
        <div class="product-options">
            <label for="quantity">QUANTITY</label>
            <div class="quantity-container">
                <button class="quantity-button">−</button>
                <input type="number" id="quantity" class="product-quantity" min="1" value="1">
                <button class="quantity-button">+</button>
            </div>
        </div>
        
        <button class="add-to-cart">ADD TO CART</button>
    </div>
</div>

<!-- Recommendation Section -->
<?php include("recommendation.php"); ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const productName = "<?php echo htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?>";
    let currentProduct = null;

    if (typeof products !== 'undefined') {
        currentProduct = products.find(p => p.name === productName);

        if (currentProduct) {
            const productImage = document.getElementById('product-image');
            document.getElementById('product-name').textContent = currentProduct.name;
            document.getElementById('product-price').textContent = currentProduct.price;
            document.getElementById('product-description').textContent = currentProduct.description;

            if (currentProduct.imageFront && currentProduct.imageBack) {
                productImage.src = currentProduct.imageFront;

                productImage.addEventListener('mouseover', () => {
                    productImage.src = currentProduct.imageBack;
                });

                productImage.addEventListener('mouseout', () => {
                    productImage.src = currentProduct.imageFront;
                });
            }
        }
    } else {
        console.error("Error: 'products' is not defined.");
    }

    // Handle size selection
    const sizeButtons = document.querySelectorAll('.size-button');
    sizeButtons.forEach(button => {
        button.addEventListener('click', () => {
            sizeButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
        });
    });

    // Quantity button handling
    const quantityInput = document.getElementById('quantity');
    const quantityButtons = document.querySelectorAll('.quantity-button');
    quantityButtons.forEach(button => {
        button.addEventListener('click', () => {
            const currentValue = parseInt(quantityInput.value, 10);
            if (button.textContent === '−' && currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
            if (button.textContent === '+' && currentValue < 10) {
                quantityInput.value = currentValue + 1;
            }
        });
    });

    // Add to cart functionality
    document.querySelector('.add-to-cart').addEventListener('click', () => {
        if (!currentProduct) {
            alert("Product not found.");
            return;
        }

        const selectedSize = document.querySelector('.size-button.active')?.textContent;
        if (!selectedSize) {
            alert("Please select a size before adding to cart.");
            return;
        }

        const quantity = parseInt(quantityInput.value, 10);
        const price = parseFloat(currentProduct.price.replace('₱', '').replace(',', ''));

        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if the product with the same size is already in the cart
        const existingItem = cart.find(item => item.name === currentProduct.name && item.size === selectedSize);
        
        if (existingItem) {
            existingItem.quantity += quantity; // Update quantity if already exists
        } else {
            cart.push({
                name: currentProduct.name,
                price: price,
                size: selectedSize,
                quantity: quantity,
                image: currentProduct.imageFront
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));

        if (typeof updateCartBadge === 'function') {
        updateCartBadge();
        }
    });
});
</script>

<?php include("footer.php"); ?>

</body>
</html>

