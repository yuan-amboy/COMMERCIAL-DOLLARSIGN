<?php
session_start();
require_once "database.php";

if (!isset($_SESSION['users'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION["users"]["id"];
$cartData = [];
$total = 0;

// Fetch cart items from the database
$sql = "SELECT c.quantity, p.name, p.price, p.imageFront FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $cartData[] = $row;
    $total += $row['price'] * $row['quantity'];
}

// Handle order placement
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Here you would typically insert the order into the database
    // For demonstration, we'll just clear the cart and redirect
    $clearCartSql = "DELETE FROM cart WHERE user_id = ?";
    $clearCartStmt = mysqli_prepare($conn, $clearCartSql);
    mysqli_stmt_bind_param($clearCartStmt, "i", $userId);
    mysqli_stmt_execute($clearCartStmt);

    // Redirect to success page
    header("Location: index.php?order=success");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout - DOLLARSIGN</title>
    <link rel="stylesheet" href="main.css">
    <style>
        /* Checkout Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        #checkout-container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        #cart-summary {
            margin-top: 20px;
        }

        .checkout-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }

        .checkout-item img {
            width: 50px;
            height: auto;
            margin-right: 10px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: #000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }

        .btn:hover {
            background: #444;
        }
    </style>
</head>

<body>
    <header>
        <h1>Checkout</h1>
        <a href="shop.php">← Continue Shopping</a>
    </header>

    <main id="checkout-container">
        <div id="cart-summary">
            <h2>Your Cart</h2>
            <div id="checkout-items">
                <?php if (empty($cartData)): ?>
                    <p>Your cart is empty!</p>
                <?php else: ?>
                    <?php foreach ($cartData as $item): ?>
                        <div class="checkout-item">
                            <img src="<?= htmlspecialchars($item['imageFront']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                            <div>
                                <p><b><?= htmlspecialchars($item['name']) ?></b></p>
                                <p>₱<?= number_format($item['price'], 2) ?> x <?= htmlspecialchars($item['quantity']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <p><strong>Total: ₱<span id="checkout-total"><?= number_format($total, 2) ?></span></strong></p>
                <?php endif; ?>
            </div>
            <form method="POST">
                <button type="submit" id="place-order" class="btn">Place Order</button>
            </form>
        </div>
    </main>
</body>

</html>