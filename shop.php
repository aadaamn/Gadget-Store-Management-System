<?php
   include 'components/sessionstart.php';
   include 'cursor.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop Page</title> <!-- Ensure this tag is correct -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" href="styling/style.css">
</head>
<body>
<?php include 'header_User.php'; ?>

  <br><br>
  <section class="shop" id="shop">
    <div class="container">
    
    <?php
    // Enable error reporting for debugging
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Step 2: Retrieve products from the database
    $sql = "SELECT ProdID, ProdName, ProdPrice, ProdDesc, Image FROM product";
    $result = $conn->query($sql);

    // Step 3: Loop through the retrieved products and generate HTML markup
    if ($result->rowCount() > 0) {
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          echo '<div class="box">';
          echo '<form action="cart.php" method="post" class="product-form">';
          echo '<a href="productpopup.php?ProdID=' . $row["ProdID"] . '"><img src="productpic/' . $row["Image"] . '" alt="' . $row["ProdName"] . '"></a>';
          echo '<h4>' . $row["ProdName"] . '</h4>';
          echo 'RM ' . number_format($row["ProdPrice"],2);
          echo '<div class="cart">';
          echo '<input type="hidden" name="ProdID" value="' . $row["ProdID"] . '">';
          echo '<input type="hidden" name="ProdName" value="' . $row["ProdName"] . '">';
          echo '<input type="hidden" name="ProdPrice" value="' . $row["ProdPrice"] . '">';
          echo '<input type="hidden" name="Image" value="' . $row["Image"] . '">';
          echo '<button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>';
          echo '<input type="hidden" name="Quantity" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">';
          echo '</div>';
          echo '</form>';
          echo '</div>';
        }
    } else {
        echo "0 results";
    }
    ?>
    
    </div>
  </section>
  
</body>
<br><br>
</html>
<?php include 'footer.php'; ?>
