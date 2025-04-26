<?php
session_start();

$isLoggedIn = isset($_SESSION["users"]);
if (!$isLoggedIn) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Addresses | DOLLARSIGN</title>
    <link rel="stylesheet" href="main.css">
    <script defer src="script.js"></script>
</head>
<body>
    <?php include("navbar.php"); ?>

    <div class="address-container">
        <button id="addAddressBtn" class="btn">Add a New Address</button>
        
        <div id="addressForm" class="address-form hidden">
            <form action="add_address.php" method="POST">
                <label>First Name: <input type="text" name="First_Name" required></label>
                <label>Last Name: <input type="text" name="Last_Name" required></label>
                <label>Address: <input type="text" name="address" required></label>
                <label>City: <input type="text" name="city" required></label>
                <label>ZIP Code: <input type="text" name="zip" required></label>
                <label>Country: <input type="text" value="Philippines" readonly></label>
                <label>State: <input type="text" name="state" required></label>
                <label>Phone Number: <input type="text" name="phone" required></label>

                <button type="submit" class="btn">Add Address</button>
                <button type="button" id="cancelBtn" class="btn">Cancel</button>
            </form>
        </div>

        <div class="address-list">
            <?php if (!empty($addresses)): ?>
                <?php foreach ($addresses as $address): ?>
                    <div class="address-item <?php echo $address['is_default'] ? 'default-address' : ''; ?>">
                        <p><?php echo htmlspecialchars($address['First_Name'] . ' ' . $address['Last_Name']); ?></p>
                        <p><?php echo htmlspecialchars($address['address']); ?></p>
                        <p><?php echo htmlspecialchars($address['city'] . ', ' . $address['state'] . ' ' . $address['zip']); ?></p>
                        <p><?php echo htmlspecialchars($address['phone']); ?></p>
                        <?php if ($address['is_default']): ?>
                            <span class="default-label">Default Address</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No addresses found</p>
            <?php endif; ?>
        </div>
    </div>

    <style>
        .address-container {
            max-width: 500px;
            margin: 95px auto;
            padding: 40px;
            background-color: rgb(216, 216, 216);
        }

        .address-container h2 {
            font-family: Arial, sans-serif;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            margin: 10px 0;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background: #000;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
        }

        .btn:hover {
            background: #222;
        }

        .address-form {
            margin: 0px;
            padding: 20px;
        }

        .address-form label {
            display: block;
            margin: 20px 0px;
            font-weight: bold;
            text-align: left;
        }

        .address-form input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
        }

        .hidden {
            display: none;
        }

        .address-list {
            margin-top: 30px;
        }

        .address-item {
            padding: 15px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            background: #fff;
        }

        .default-address {
            border-left: 5px solid #000;
        }

        .default-label {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background: #000;
            color: #fff;
            font-weight: bold;
        }
    </style>

    <script>
    const addAddressBtn = document.getElementById('addAddressBtn');
    const addressForm = document.getElementById('addressForm');
    const cancelBtn = document.getElementById('cancelBtn');

    addAddressBtn.addEventListener('click', () => {
        addressForm.classList.remove('hidden');
        addAddressBtn.style.display = 'none';
    });

    cancelBtn.addEventListener('click', () => {
        addressForm.classList.add('hidden');
        addAddressBtn.style.display = 'inline-block';
    });
    </script>

    <?php include("footer.php"); ?>
</body>
</html>
