<?php
    include 'header_User.php';
    include 'components/sessionstart.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Unsuccessful</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .bekas {
            width: 50%;
            margin-left: 24%;
            margin-right: 25%;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            height: 150px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .order-unsuccessful {
            width: 51.5%;
            text-align: center;
            background-color: red;
            color: white;
            padding: 7px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 16px;
            margin-left: 24%;
        } 
        .home-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, box-shadow 0.3s;
            margin-left: 38%;
        }
        .home-button:hover {
            background-color: #45a049;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
        }
        .home-button:active {
            background-color: #388e3c;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .message {
            font-size: 16px;
            text-align: center;
        }
    </style>
</head>
<body>
    <br><br><br><br>
    <div class="order-unsuccessful">
            Order Unsuccessful
    </div>
    <div class="bekas">
        <br>
        <div class="message">
            You can go back to the homepage to try to pay again for your order.
        </div>
        <br>
        <a href="home.php" class="home-button">Go to Homepage</a>
    </div>
    <br><br><br><br><br><br>
    <br><br><br>
</body>
</html>
<?php include 'footer.php'; ?>
