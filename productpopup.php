<!-- this file for - when the user click on the row, it will display the item name, price, details and more -->
<?php

include 'components/sessionstart.php';
include 'cursor.php';

include 'header_User.php';
if (isset($_GET['ProdID'])) {
    $prodID = $_GET['ProdID'];
   
    $sql = "SELECT * FROM product WHERE ProdID = ?";
    $result = $conn->prepare($sql);
    $result->execute([$prodID]);
   
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    if ($row) {
        // row details found, display them
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><title><?php echo $row['ProdName']; ?> </title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    body {
    font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    justify-content: center;
    align-items: center;
    height: 100vh;
}   
.contain{
    margin-top: 100px;
    margin-left: 15%;
    max-width: 1100px;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    gap: 20px;
    display: flex;
}

.product-image img {
  width: 400px;
  height: auto;
  border-radius: 10px;
}

.product-details {
  max-width: 500px;
  padding: 20px;
}

.product-name {
  font-size: 24px;
  margin-bottom: 10px;
}

.product-description {
  font-size: 16px;
  color: #777;
  margin-bottom: 20px;
}

.product-price {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
  font-size: 20px;
  font-weight: bold;
}


.quantity-selector {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 20px;
}

.quantity-selector button {
  width: 30px;
  height: 30px;
  background-color: #f0f0f0;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 18px;
}

.quantity-selector input {
  width: 50px;
  text-align: center;
  border: 1px solid #ddd;
  border-radius: 5px;
  padding: 5px;
}

.add-to-cart-btn {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 20px;
  background-color: black;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

.add-to-cart-btn img {
  width: 20px;
  height: 20px;
}

@media (max-width: 768px) {
  .container {
      flex-direction: column;
      align-items: center;
  }
}
    </style>
</head>
<body>
    <div class="contain">
        <div class="product-image">
            <?php echo '<img src="productpic/' . $row['Image'] . '" alt="' . $row['ProdName'] . '">'; ?>
        </div>
        <div class="product-details">
            <h1 class="product-name"> <?php echo $row['ProdName']; ?> </h1>
            <p class="product-description">
                <?php echo $row['ProdDesc']; ?>
            </p>
            <div class="product-price">
                <span class="current-price">RM <?php echo $row['ProdPrice']; ?></span>
            </div>
            <form action="cart.php" method="post" class="product-form">
                <div class="quantity-selector">
                    <!-- <button id="decrease">-</button> -->
                    <input type="number" name="Quantity"id="Quantity" value="1" min="1">
                    <!-- <button id="increase">+</button> -->
                </div>
                <?php
                    echo '<input type="hidden" name="ProdID" value="' . $row["ProdID"] . '">';
                    echo '<input type="hidden" name="ProdName" value="' . $row["ProdName"] . '">';
                    echo '<input type="hidden" name="ProdPrice" value="' . $row["ProdPrice"] . '">';
                    echo '<input type="hidden" name="Image" value="' . $row["Image"] . '">';
                ?>
                <button type="submit" name = "add_to_cart" class="add-to-cart-btn">
                    <i class="fas fa-shopping-cart"></i alt="Cart Icon"> Add to cart
                </button>
            </form>    
        </div>
    </div>
    <script src="JS/hehe.js"></script>
</body>
</html>

<?php }} ?>
