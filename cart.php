<?php 

include 'components/connect.php';
include 'cursor.php';

session_start();

if(isset($_SESSION['CustID'])){
    $cust_id = $_SESSION['CustID'];
}else{
    $cust_id = '';
    header('location:Cust_Account.php');
}; 

if(isset($_POST['add_to_cart'])){

   if($cust_id == ''){
      header('location:Cust_Account.php');
   }else{

      $pid = $_POST['ProdID'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['ProdName'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['ProdPrice'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['Image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $qty = $_POST['Quantity'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE ProdID= ? AND CustID = ?");
      $check_cart_numbers->execute([$pid, $cust_id]);

      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'already added to cart!';
         $insert_cart = $conn->prepare('UPDATE `cart` SET Quantity = Quantity + ? WHERE CustID = ? AND ProdID = ?');
         $insert_cart->execute([$qty ,$cust_id, $pid]);
      }else{


         $insert_cart = $conn->prepare("INSERT INTO `cart`(CustID, ProdID, Quantity) VALUES(?,?,?)");
         $insert_cart->execute([$cust_id, $pid, $qty]);
         $message[] = 'added to cart!';
         
      }

   }

}
if(isset($_SESSION['CustID'])){
    $CustID = $_SESSION['CustID'];
 }
else{
    $CustID = '';
    header('location:Cust_Account.php');
 };
 
 if(isset($_POST['delete'])){
    $CartID = $_POST['CartID'];
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE CartID = ?");
    $delete_cart_item->execute([$CartID]);
 }
 
 if(isset($_GET['delete_all'])){
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE CustID = ?");
    $delete_cart_item->execute([$CustID]);
    header('location:cart.php');
 }
 
 if(isset($_POST['update_qty'])){
    $CartID = $_POST['CartID'];
    $qty = $_POST['Quantity'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
    $update_qty = $conn->prepare("UPDATE `cart` SET Quantity = ? WHERE CartID = ?");
    $update_qty->execute([$qty, $CartID]);
    $message[] = 'cart quantity updated';
 }
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shopping Cart</title>
   
   <style>
      body {
         font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto;
         background-color: #f4f4f4;
         margin: 0;
         padding: 0;
         background: linear-gradient(to right, #fff, #c9d6ff);
      }
      .heading {
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
      .price, .sub-total {
         color: #333;
      }
      .qty {
         width: 60px;
         padding: 5px;
         border: 1px solid #ddd;
         border-radius: 4px;
         text-align: center;
      }
      .delete-btn, .option-btn, .btn {
         display: inline-block;
         padding: 10px 20px;
         margin: 10px 0;
         border-radius: 4px;
         text-decoration: none;
         color: #fff;
         background-color: #ff4757;
         border: none;
         cursor: pointer;
      }
      .option-btn {
         background-color: lightblue;
      }
      .delete-btn.disabled, .btn.disabled {
         background-color: #ccc;
         cursor: not-allowed;
      }
      .btn {
         background-color: grey;
      }
      .cart-total {
         width: 80%; 
         margin: 0 auto;
         margin-top: -30px; 
         text-align: center;
         padding: 20px;
         background-color: #fff;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
         box-sizing: border-box; 
      }
      .cart-total p {
         font-size: 1.2em;
         color: #333;
         margin: 10px 0;
      }
   </style>
</head>
<body>
   
<?php include 'header_User.php'; ?>

<section class="products shopping-cart">

   <br>
   <h2 class="heading">Shopping Cart</h2>

   <div class="table-container">
      <table>
         <thead>
            <tr>
               <th>Product Image</th>
               <th>Product Name</th>
               <th>Price</th>
               <th>Quantity</th>
               <th>Sub Total</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php
               $grand_total = 0;
               $select_cart = $conn->prepare("SELECT cart.*, product.* FROM cart INNER JOIN product ON cart.ProdID = product.ProdID WHERE cart.CustID = ?");
               $select_cart->execute([$cust_id]);
               if($select_cart->rowCount() > 0){
                  while($row = $select_cart->fetch(PDO::FETCH_ASSOC)){
                     $sub_total = $row['ProdPrice'] * $row['Quantity'];
                     $grand_total += $sub_total;
            ?>
            <tr>
               <td><img src="productpic/<?= $row['Image']; ?>" alt="<?= $row['ProdName']; ?>" style="width: 100px; border-radius: 8px;"></td>
               <td><?= $row['ProdName']; ?></td>
               <td class="price">RM<?= number_format($row['ProdPrice'],2); ?></td>
               <td>
                  <form action="" method="post" style="display: inline;">
                     <input type="hidden" name="CartID" value="<?= $row['CartID']; ?>">
                     <input type="number" name="Quantity" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $row['Quantity']; ?>">
                     <button type="submit" class="fas fa-edit" name="update_qty"></button>
                  </form>
               </td>
               <td class="sub-total">RM<?= number_format($sub_total,2); ?></td>
               <td> 
                  <form action="" method="post" >
                     <input type="hidden" name="CartID" value="<?= $row['CartID']; ?>">
                     <input type="submit" value="Remove Item" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete">
                  </form>
               </td>
            </tr>
            <?php
                  }
               } else {
                  echo '<tr><td colspan="6" style="text-align: center">Your cart is empty</td></tr>';
               }
            ?>
         </tbody>
      </table>
   </div>

   <div class="cart-total">
      <p>Grand total: <span>RM<?= number_format($grand_total,2); ?></span></p>
      <a href="shop.php" class="option-btn">Continue Shopping</a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 0)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">Remove all items</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 0)?'':'disabled'; ?>">Proceed to Checkout</a> 
      <br>
   </div>

</section>
<br><br><br>
</body>
</html>
<?php include 'footer.php'; ?>
