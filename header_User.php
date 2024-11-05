<?php 
    include 'components/connect.php';


    $isLoggedIn = isset($_SESSION['CustID']);

    if ($isLoggedIn) {
        $customerlog = $conn->prepare("SELECT * FROM customer WHERE CustID = ?");
        $customerlog->execute([$cust_id]);
        $row = $customerlog->fetch(PDO::FETCH_ASSOC);
        $userName = $row['CustUsername'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D' Perantis Gadget Store</title>
    <link rel="stylesheet" href="styling/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
        <nav class="navbar">
            <ul>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="check_orders.php">Orders</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>

            <!-- centered logo -->
            <a href="home.php"><img id="hollowpic" src="images/hollow.png" alt="Hollow"></a>
            <!-- search box -->
            <div class="search-box">
                <form action="searchpage.php" method="GET">
                    <input type="text" name="prodname" id="prodname" placeholder="Search...">
                </form>
            </div>
            <!-- icons -->
            <div class="icons">
                <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
                <?php if ($isLoggedIn): ?>
                <a href="#" id="user-icon"><?php echo ($userName); ?></a>
                <div class="popup" id="user-popup">
                    <div>Hi <?php echo ($userName); ?>!</div>
                    <a href="update_customer.php">Update Profile</a>
                    <a href="change_password.php">Change Password</a>
                    <a href="components/user_logout.php">Logout</a>
                </div>
                <?php else: ?>
                    <a href="Cust_Account.php" id="user-icon"><i class="fas fa-user"></i></a>
                <?php endif; ?>
        </nav>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userIcon = document.getElementById('user-icon');
            const userPopup = document.getElementById('user-popup');

            if (userPopup) {
                userIcon.addEventListener('click', function(event) {
                    event.preventDefault();
                    userPopup.style.display = userPopup.style.display === 'block' ? 'none' : 'block';
                });

                document.addEventListener('click', function(event) {
                    if (!userIcon.contains(event.target) && !userPopup.contains(event.target)) {
                        userPopup.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>

</html>
