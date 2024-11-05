<?php
include 'components/sessionstart.php';
include 'cursor.php';

if(isset($_SESSION['CustID']))
    $cust_id = $_SESSION['CustID'];
else {
    $cust_id = '';
    header('location:Cust_Account.php');
    exit;
}

// Fetch orders for the logged-in customer
$order_query = "
    SELECT o.OrderID, o.OrderDate, o.TotalProd, o.TotalAmount, o.Status, d.TrackingCode, d.CourierName 
    FROM `Order` o 
    LEFT JOIN `Delivery` d ON o.OrderID = d.OrderID 
    WHERE o.CustID = :CustID
";
$stmt_order = $conn->prepare($order_query);
$stmt_order->bindParam(':CustID', $cust_id, PDO::PARAM_INT);
$stmt_order->execute();
$orders = $stmt_order->fetchAll(PDO::FETCH_ASSOC);

include 'header_User.php';

// Define colors for each status
$status_colors = [
    'Paid' => 'lightblue',
    'Packing' => '#FFD580',
    'In Transit' => '#FFA500',
    'Delivered' => 'green'
];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Orders</title>
    <style>
        body {
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #fff, #c9d6ff);
        }
        .INDI {
            text-align: center;
            margin: 20px 0;
            font-size: 3em;
            color: #333;
            margin-top: 50px;
        }
        .table-container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-sizing: border-box; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f8f8f8;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
   
<?php include 'header_User.php'; ?>

<section class="orders">

   <br>
   <h2 class="INDI">Order History</h2>

   <div class="table-container">
      <table>
         <thead>
            <tr>
               <th>Order ID</th>
               <th>Order Date</th>
               <th>Total Products</th>
               <th>Total Amount</th>
               <th>Tracking Code</th>
               <th>Courier Name</th>
               <th>Status</th>
            </tr>
         </thead>
         <tbody>
            <?php
               if(count($orders) > 0) {
                  foreach ($orders as $order) {
                      $status = $order['Status'];
                      $color = isset($status_colors[$status]) ? $status_colors[$status] : 'white';
            ?>
            <tr>
               <td><?= $order['OrderID']; ?></td>
               <td><?= $order['OrderDate']; ?></td>
               <td><?= $order['TotalProd']; ?></td>
               <td>RM<?= number_format($order['TotalAmount'], 2); ?></td>
               <td><?= $order['TrackingCode'] ? $order['TrackingCode'] : 'N/A'; ?></td>
               <td><?= $order['CourierName'] ? $order['CourierName'] : 'N/A'; ?></td>
               <td style="background-color: <?= $color; ?>;"><?= $status; ?></td>
            </tr>
            <?php
                  }
               } else {
                  echo '<tr><td colspan="7" class="text-center">No orders found</td></tr>';
               }
            ?>
         </tbody>
      </table>
   </div>

</section>
<br><br><br>
<?php include 'footer.php'; ?>
</body>
</html>
