<?php 
    include 'components/sessionstart.php';
    include 'header_User.php';
    include 'cursor.php';
?>      


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5/css/all.min.css">
    <link rel="stylesheet" href="styling/style.css">
    
    <title>D' Perantis Gadget Store</title>
</head>

<body>
    <img class = "content" src="images/pscrop.png" alt="Description of the image">
    <div class="logos">
      <div class="logos-slide">
        <img src="./logo/sony.svg" />
        <img src="./logo/apple.svg" />
        <img src="./logo/bose.svg" />
        <img src="./logo/playstation.svg" />
        <img src="./logo/corsair.svg" />
        <img src="./logo/honor.svg" />
        <img src="./logo/amd.svg" />
        <img src="./logo/msi.svg" />
      </div>
    </div>

    <script>
      var copy = document.querySelector(".logos-slide").cloneNode(true);
      document.querySelector(".logos").appendChild(copy);
    </script>

  <div class="yapping">
      <h1>D' Perantis</h1>
      <h4>“one stop store. every <strong>gadgets</strong> you need. anytime. anywhere”.</h4>
      <img src="images/hollowtransparent.jpg">
  </div>
  
</body>
</html>
<?php include 'footer.php'; ?>