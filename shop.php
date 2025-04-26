<?php
session_start();
$isLoggedIn = isset($_SESSION["users"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | DOLLARSIGN</title>
    <link rel="stylesheet" href="main.css">
    <script src="clothingData.js"></script>
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
<?php include("navbar.php"); ?>
    
    <!-- Clothing Section -->
    <!-- Shop Search Bar -->
    <div class="shop-header">
        <input type="text" id="shop-search-input" placeholder="Search products...">
    </div>

    <div id="no-results-message" style="display: none;">No products found.</div>

    <div id="shop-items" class="shop-section">
        <!-- Products -->
    </div>

    <?php include("footer.php"); ?>
</body>
</html>