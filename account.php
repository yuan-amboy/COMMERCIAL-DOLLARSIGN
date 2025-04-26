<?php
session_start();
$isLoggedIn = isset($_SESSION["users"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account | DOLLARSIGN</title>
    <link rel="stylesheet" href="main.css">
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body>
    <?php include("navbar.php"); ?>

    <!-- Account Section -->
    <div class="account-container">
        <h2>Account Details</h2>
        <?php if (isset($_SESSION['users'])): ?>
        <p>
            <?php 
            echo htmlspecialchars($_SESSION['users']['First_Name'] ?? 'First Name') . ' ' . 
            htmlspecialchars($_SESSION['users']['Last_Name'] ?? 'Last Name');
            ?>
        </p>
        
        <p>
            <?php echo htmlspecialchars($_SESSION['users']['default_address'] ?? 'No default address set'); ?>
        </p>
        <a href="addresses.php" class="btn-addresses">Addresses</a>
        <?php else: ?>
            <p>User not logged in</p>
        <?php endif; ?>

        <h2>Order History</h2>
        <?php if (!empty($orderHistory)): ?>
            <ul>
                <?php foreach ($orderHistory as $order): ?>
                    <li>Order #<?php echo $order['order_id']; ?> - <?php echo $order['status']; ?> - <?php echo $order['total']; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No orders found</p>
        <?php endif; ?>

        <a href="logout.php" class="btn-logout">LOGOUT</a>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>
