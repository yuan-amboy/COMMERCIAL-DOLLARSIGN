<!-- Recommended Products Section -->
<div class="recommendation-container">
    <h2>RECOMMENDATION</h2>
    <div class="recommendation-grid" id="recommendations">
        <!-- Recommended products will be inserted here -->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const productName = "<?php echo htmlspecialchars($productName, ENT_QUOTES, 'UTF-8'); ?>";
    let currentProduct = null;

    if (typeof products !== 'undefined') {
        currentProduct = products.find(p => p.name === productName);

        if (currentProduct) {
            document.getElementById('product-name').textContent = currentProduct.name;
            document.getElementById('product-price').textContent = currentProduct.price;
            document.getElementById('product-description').textContent = currentProduct.description;
            
            const productImage = document.getElementById('product-image');
            productImage.src = currentProduct.imageFront;

            productImage.addEventListener('mouseover', () => {
                productImage.src = currentProduct.imageBack;
            });

            productImage.addEventListener('mouseout', () => {
                productImage.src = currentProduct.imageFront;
            });
        }

        generateRecommendations(currentProduct);
    } else {
        console.error("Error: 'products' is not defined.");
    }
});

function generateRecommendations(currentProduct) {
    if (!products || products.length === 0) return;

    // Filter out the current product
    let filteredProducts = products.filter(p => p.name !== currentProduct.name);

    // Shuffle and pick 4 random products
    let shuffled = filteredProducts.sort(() => 0.5 - Math.random());
    let recommended = shuffled.slice(0, 4);

    // Insert into the DOM
    const recommendationsContainer = document.getElementById('recommendations');
    recommendationsContainer.innerHTML = recommended.map(p => `
        <div class="recommended-item">
            <a href="product.php?product=${encodeURIComponent(p.name)}">
                <img src="${p.imageFront}" alt="${p.name}" 
                    onmouseover="this.src='${p.imageBack}'" 
                    onmouseout="this.src='${p.imageFront}'">
                <p class="recommended-title">${p.name}</p>
                <p class="recommended-price">${p.price}</p>
            </a>
        </div>
    `).join('');
}
</script>

<style>
/* Recommendation Section - Enhanced */
.recommendation-container {
    margin-top: 60px;
    padding: 30px 20px;
    text-align: center;
    margin-bottom: 40px;
}

.recommendation-container h2 {
    font-family: 'Arial', sans-serif;
    font-size: 42px;
    margin: 0 0 20px 0;
    padding: 0;
    color: #333;
    position: relative;
    display: inline-block;
}

.recommendation-container h2::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: #333;
    transition: width 0.3s ease;
}

.recommendation-container:hover h2::after {
    width: 120px;
}

.recommendation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
    align-items: stretch;
}

.recommended-item {
    background-color: rgb(216, 216, 216);
    padding: 15px;
    margin: 0;
    width: 100%;
    max-width: 240px;
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    text-align: center;
    overflow: hidden;
    position: relative;
}

.recommended-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background-color: #333;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.recommended-item:hover {
    background-color: #fff;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

.recommended-item:hover::before {
    transform: scaleX(1);
}

.recommended-item a {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
}

.recommended-item img {
    width: 100%;
    max-width: 200px;
    height: 200px;
    margin: 0 auto 15px;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.recommended-item:hover img {
    transform: scale(1.05);
}

.recommended-title {
    font-family: 'Arial', sans-serif;
    font-size: 16px;
    font-weight: bold;
    color: #222;
    margin: 10px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    padding: 0 5px;
}

.recommended-price {
    font-family: 'Arial', sans-serif;
    font-size: 16px;
    font-weight: bold;
    color: #333;
    margin: 0 0 10px 0;
}

/* Add to Cart Button for Recommendations */
.recommended-add-to-cart {
    background: #333;
    color: white;
    border: none;
    padding: 8px 15px;
    font-size: 14px;
    cursor: pointer;
    margin-top: 10px;
    transition: all 0.3s ease;
    width: 80%;
    opacity: 0;
    transform: translateY(10px);
}

.recommended-item:hover .recommended-add-to-cart {
    opacity: 1;
    transform: translateY(0);
}

.recommended-add-to-cart:hover {
    background: #000;
}

/* Tablet Styles */
@media (max-width: 991px) {
    .recommendation-container h2 {
        font-size: 36px;
    }
    
    .recommendation-grid {
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 20px;
    }
    
    .recommended-item {
        max-width: 210px;
    }
    
    .recommended-item img {
        height: 180px;
    }
}

/* Mobile Styles */
@media (max-width: 767px) {
    .recommendation-container {
        padding: 25px 15px;
        margin-top: 40px;
    }
    
    .recommendation-container h2 {
        font-size: 30px;
        margin-bottom: 15px;
    }
    
    .recommendation-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 15px;
        padding: 10px;
    }
    
    .recommended-item {
        max-width: 160px;
        padding: 10px;
    }
    
    .recommended-item img {
        height: 150px;
        margin-bottom: 10px;
    }
    
    .recommended-title {
        font-size: 14px;
    }
    
    .recommended-price {
        font-size: 14px;
    }
    
    .recommended-add-to-cart {
        opacity: 1;
        transform: translateY(0);
        width: 90%;
        padding: 6px 10px;
        font-size: 13px;
    }
}

/* Small Mobile Styles */
@media (max-width: 480px) {
    .recommendation-container h2 {
        font-size: 26px;
    }
    
    .recommendation-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    
    .recommended-item {
        max-width: 100%;
    }
    
    .recommended-item img {
        height: 120px;
    }
}
</style>