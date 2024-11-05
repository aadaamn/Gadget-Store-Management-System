<?php

include 'components/sessionstart.php';
include 'cursor.php';

if(isset($_SESSION['CustID']))
    $cust_id = $_SESSION['CustID'];

// Ensure order_id is set in the query parameters
if (!isset($_GET['order_id'])) {
    die('Order ID not specified.');
}

$order_id = $_GET['order_id'];

// Fetch order details
$order_query = "SELECT * FROM `Order` WHERE OrderID = ?";
$stmt_order = $conn->prepare($order_query);
$stmt_order->execute([$order_id]);
$order = $stmt_order->fetch(PDO::FETCH_ASSOC);

// Fetch payment details
$payment_query = "SELECT * FROM Payment WHERE OrderID = ?";
$stmt_payment = $conn->prepare($payment_query);
$stmt_payment->execute([$order_id]);
$payment = $stmt_payment->fetch(PDO::FETCH_ASSOC);

// Fetch customer details
$customer_query = "SELECT * FROM Customer WHERE CustID = ?";
$stmt_customer = $conn->prepare($customer_query);
$stmt_customer->execute([$order['CustID']]);
$customer = $stmt_customer->fetch(PDO::FETCH_ASSOC);

// Fetch order items
$order_items_query = "SELECT * FROM OrderItem WHERE OrderID = ?";
$stmt_order_items = $conn->prepare($order_items_query);
$stmt_order_items->execute([$order_id]);
$order_items = $stmt_order_items->fetchAll(PDO::FETCH_ASSOC);

include 'header_User.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt</title>
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .tajuk h1 {
            text-align: center;
        }
        .order-success {
            width: 51.5%;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            padding: 7px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 16px;
            margin-left: 24%;
        }
        .receipt-section {
            margin-bottom: 30px;
            text-align: left;
        }
        .receipt-section h2 {
            margin-left: 95px;
        }
        table {
            margin-left: 100px;
            width: 75%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            margin: auto;
        }
        .text-right {
            text-align: center;
        }
        .download-button {
            margin-left: 35%;
            margin-right: 25%;
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
        }
        .download-button:hover {
            background-color: #45a049;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.1);
        }

        .download-button:active {
            background-color: #388e3c;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <br><br><br><br>
    <div class="order-success">
            Order Successful
    </div>
    <div class="bekas">
        <div class="tajuk">
            <h1>Order Receipt</h1>
        </div>
        <div class="receipt-section">
            <h2>Order Details</h2>
            <table>
                <tr>
                    <th>Order ID</th>
                    <td><?php echo $order['OrderID']; ?></td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td><?php echo $order['OrderDate']; ?></td>
                </tr>
                <tr>
                    <th>Total Products</th>
                    <td><?php echo $order['TotalProd']; ?></td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td>RM<?php echo number_format($order['TotalAmount'],2); ?></td>
                </tr>
            </table>
        </div>
        <div class="receipt-section">
            <h2>Customer Details</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <td><?php echo $customer['CustName']; ?></td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td><?php echo $customer['CustPhoneNo']; ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo $customer['CustAddress']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $customer['CustEmail']; ?></td>
                </tr>
            </table>
        </div>

        <div class="receipt-section">
            <h2>Order Items</h2>
            <table>
                <tr>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Price Per Item</th>
                    <th>Total Price</th>
                </tr>
                <?php foreach ($order_items as $item): ?>
                <tr>
                    <td class="text-right"><?php echo $item['ProdID']; ?></td>
                    <td class="text-right"><?php echo $item['Quantity']; ?></td>
                    <td class="text-right">RM<?php echo number_format($item['PricePerItem'],2); ?></td>
                    <td class="text-right">RM<?php echo number_format($item['TotalPrice'],2); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="receipt-section">
            <h2>Payment Details</h2>
            <table>
                <tr>
                    <th>Payment ID</th>
                    <td><?php echo $payment['PayID']; ?></td>
                </tr>
                <tr>
                    <th>Payment Date</th>
                    <td><?php echo $payment['PayDate']; ?></td>
                </tr>
                <tr>
                    <th>Amount Paid</th>
                    <td>RM<?php echo number_format($payment['AmountPaid'],2); ?></td>
                </tr>
            </table>
        </div>
        <div class="receipt-section">
            <form action="download_receipt.php" method="post">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <button type="submit" class="download-button">Download Receipt (PDF)</button>
            </form>
        </div>
    </div>
    <br><br><br>
    <?php include 'footer.php'; ?>
</body>
</html>
