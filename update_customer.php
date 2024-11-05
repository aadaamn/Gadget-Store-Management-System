<?php
include 'components/sessionstart.php';
include 'cursor.php';

// Check if user is logged in
if (!isset($_SESSION['CustID'])) {
    header('Location: Cust_Account.php');
    exit();
}

// Fetch customer details
$customer_id = $_SESSION['CustID'];
$select_user = $conn->prepare("SELECT * FROM `customer` WHERE CustID = ?");
$select_user->execute([$customer_id]);
$customer = $select_user->fetch(PDO::FETCH_ASSOC);

$message = [];

if(isset($_POST['update_submit'])){
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $Address = $_POST['Address'];
    $Address = filter_var($Address, FILTER_SANITIZE_STRING);;
    $phone = $_POST['phone'];
    $phone = filter_var($phone, FILTER_SANITIZE_STRING);

    $update_user = $conn->prepare("UPDATE `customer` SET CustUsername = ?, CustEmail = ?, CustName = ?, CustAddress = ?, CustPhoneNo = ? WHERE CustID = ?");
    $update_user->execute([$username, $email, $name, $Address, $phone, $customer_id]);

    $message[] = 'Information updated successfully!';
}

include 'header_User.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Update Information</title>
    <style>
        body {
            background: linear-gradient(to right, #fff, #c9d6ff);
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto;
        }
        .cawan {
            max-width: 600px;
            margin: 10px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            width: 41.5%;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            padding: 2px;
            border-radius: 8px;
            margin-bottom: 2px;
            font-size: 16px;
            margin-left: 29%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 10px;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="tel"] {
            width: 90%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .butang {
            margin-left: 25%;
            margin-right: 25%;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .butang:hover {
            background-color: #45a049;
        }
        .butang {
            margin-left: 43%;
        }
    </style>
</head>

<body>
    <br><br><br>
    <?php if(!empty($message)): ?>
        <div class="message">
            <?php foreach($message as $msg): ?>
                <p><?php echo $msg; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="cawan">
        <h1 style="text-align: center">Update Profile</h1>

        <form action="" method="post">
            <table>
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input type="text" id="username" name="username" required maxlength="10" value="<?php echo $customer['CustUsername']; ?>"></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email"  value="<?php echo $customer['CustEmail']; ?>"></td>
                </tr>
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td><input type="text" id="name" name="name"value="<?php echo $customer['CustName']; ?>"></td>
                </tr>
                <tr>
                    <td><label for="Address">Address:</label></td>
                    <td><input type="text" id="Address" name="Address" value="<?php echo $customer['CustAddress']; ?>"></td>
                </tr>
                <tr>
                    <td><label for="phone">Phone Number:</label></td>
                    <td><input type="tel" id="phone" name="phone"  value="<?php echo $customer['CustPhoneNo']; ?>"></td>
                </tr>
            </table>
            <button class="butang" type="submit" name="update_submit">Update</button>
        </form>
    </div>
<br><br>
</body>
<?php include 'footer.php'; ?>
</html>
