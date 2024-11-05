<?php 
include 'components/sessionstart.php';
include 'cursor.php';

$cust_id = $_SESSION['CustID'];

// Data current customer details
$customer_details = $conn->prepare("SELECT * FROM Customer WHERE CustID = ?");
$customer_details->execute([$cust_id]);
$customer = $customer_details->fetch(PDO::FETCH_ASSOC);

// Data cart items
$select_cart = $conn->prepare("SELECT cart.*, product.* FROM cart INNER JOIN product ON cart.ProdID = product.ProdID WHERE cart.CustID = ?");
$select_cart->execute([$cust_id]);

$grand_total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   
   <style>
      body {
         font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto;
         background-color: #f4f4f4;
         margin: 0;
         padding: 0;
         background: linear-gradient(to right, #fff, #c9d6ff);
      }
      .checkouttitle{
         text-align: center;
         font-size: 50px;
      }
      .heading {
         text-align: center;
         margin: 20px 0;
         font-size: 2em;
         color: #333;
         margin-top: 20px;
      }
      .details {
         text-align: center;
         margin-top: -10px;
         font-weight: 400;
      }

      .checkout {
         display: flex;
         justify-content: space-between;
         width: 80%;
         margin: 0 auto;
         gap: 20px;
      }

      .table-container {
         flex: 1.6;
         background-color: #fff;
         padding: 20px;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         height: 450px; 
         overflow-y: auto; 
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

      .price, .sub-total {
         color: #333;
      }

      .cart-total {
         text-align: center;
         padding: 20px;
         background-color: #fff;
         margin: 20px 0;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .cart-total p {
         font-size: 1.2em;
         color: #333;
         margin: 10px 0;
      }

      .form-container {
         flex: 1.5;
         background-color: #fff;
         padding: 20px;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         height: 450px; 
         overflow-y: auto; 
      }

      .form-container form {
         display: flex;
         flex-direction: column;
      }

      .form-container label {
         margin: 10px 0 5px;
         color: #333;
      }

      .form-container input {
         padding: 10px;
         border-radius: 4px;
         border: 1px solid #ddd;
         margin-bottom: 20px;
      }

      .form-container button {
         padding: 10px;
         border: none;
         border-radius: 4px;
         background-color: #ff4757;
         color: #fff;
         cursor: pointer;
         font-size: 1em;
      }

      .button-container {
         text-align: center;
         padding: 20px;
         margin: 20px 0;
      }

      .button-container button {
         padding: 15px 30px;
         border: none;
         border-radius: 6px;
         background-color: #ff4757;
         color: #fff;
         cursor: pointer;
         font-size: 1.2em;
      }
   </style>
</head>
<body>
   
<?php include 'header_User.php'; ?>
<br><br>
<h1 class="checkouttitle">Checkout</h1>
<section class="checkout">
   
   <div class="table-container">
      <h2 class="heading">Your Cart</h2>
      <table>
         <thead>
            <tr>
               <th>Product</th>
               <th>Product Name</th>
               <th>Price</th>
               <th>Quantity</th>
               <th>Sub Total</th>
            </tr>
         </thead>
         <tbody>
            <?php
               if($select_cart->rowCount() > 0){
                  while($row = $select_cart->fetch(PDO::FETCH_ASSOC)){
                     $sub_total = $row['ProdPrice'] * $row['Quantity'];
                     $grand_total += $sub_total;
            ?>
            <tr>
               <td><img src="productpic/<?= $row['Image']; ?>" alt="<?= $row['ProdName']; ?>" style="width: 100px; border-radius: 8px;"></td>
               <td><?= $row['ProdName']; ?></td>
               <td class="price">RM<?= number_format($row['ProdPrice'],2); ?></td>
               <td style="text-align: center"><?= $row['Quantity']; ?></td>
               <td class="sub-total">RM<?= number_format($sub_total,2); ?></td>
            </tr>
            <?php
                  }
               } 
            ?>
         </tbody>
      </table>
      <div class="cart-total">
         <p>Grand total: <span>RM<?= number_format($grand_total,2); ?></span></p>
      </div>
   </div>
   <div class="form-container">
      <h2 class="heading">Update Details</h2>
      <h5 class="details">For delivery & Billing purposes</h5>
      <form method="POST" action="payment.php">
         <input type="hidden" id="CustID" name="CustID" value="<?= $cust_id; ?>"> 
         <label for="CustName">Name:</label>
         <input type="text" id="CustName" name="CustName" value="<?= ($customer['CustName']); ?>" required>
         <label for="CustAddress">Address:</label>
         <input type="text" id="CustAddress" name="CustAddress" value="<?= ($customer['CustAddress']); ?>" required>
         <label for="CustPhoneNo">Phone Number:</label>
         <input type="text" id="CustPhoneNo" name="CustPhoneNo" value="<?= ($customer['CustPhoneNo']); ?>" required>
         <input type="hidden" id="CustEmail" name="CustEmail" value="<?= ($customer['CustEmail']); ?>" >
         <input type="hidden" id="TotalAmount" name="TotalAmount" value="<?= $grand_total; ?>">
         <button type="submit">Proceed to Payment</button>
      </form>
   </div>

</section>
<br><br><br>
</body>
</html>
<?php include 'footer.php'; ?>
