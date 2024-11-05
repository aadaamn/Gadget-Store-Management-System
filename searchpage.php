<!-- a page to show the user search results -->
<?php
    include 'components/sessionstart.php';
    include 'cursor.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Page</title>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <link rel="stylesheet" href="styling/style.css">
</head>
<body>
<?php include 'header_User.php'; ?>

<div class="title-searchpage">
    <h1><br>Search Results:</h1>
</div>

<section class="shop" id="shop">
    <div class="container">
        <?php
        // Retrieve the search query from the form
        if (isset($_GET['prodname'])) {
            $search_query = $_GET['prodname'];

            // Perform a basic search query on your database
            $sql = "SELECT * FROM `product` WHERE ProdName LIKE '%$search_query%'";
            $result = $conn->query($sql);
            // Display search results
            if ($result-> rowCount() > 0) {
                while($row = $result-> fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="box">';
                    echo '<form action="cart.php" method="post" class="product-form">';
                    echo '<a href="productpopup.php?ProdID=' . $row["ProdID"] . '"><img src="productpic/' . $row["Image"] . '" alt="' . $row["ProdName"] . '"></a>';
                    echo '<h4>' . $row["ProdName"] . '</h4>';
                    echo 'RM ' . $row["ProdPrice"]; 
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
                echo "No results found.";
            }
        }

        ?>
</div>
</section>
<br><br>
</body>

<?php include 'footer.php'; ?>