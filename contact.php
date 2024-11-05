<?php 
    include 'components/sessionstart.php';
    include 'cursor.php';

    if(isset($_SESSION['CustID']))
        $cust_id = $_SESSION['CustID'];

    include 'header_User.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact Us</title>
   <link rel="stylesheet" href="styling/style.css">
</head>

<body>
    <br><br><br>
    <h1 class="tajuk">D Perantis Gadget Store</h1>
    <div class="maps-container">
        <div class="content-container">
            <div class="image-container">
                <img src="images/gambaqkedai.jpg" alt="D Perantis Gadget Store" width="400" height="500">
            </div>
            <div class="info-container">
                <h2>Contact Information</h2>
                <p><strong>Owner Name:</strong> Mohd Kamal Md. Akhir</p>
                <p><strong>Address:</strong> ANJUNG SISWA UiTM PERLIS, UiTM Arau, 02600 Arau, Perlis</p>
                <p><strong>Phone Number:</strong> +6019 - 2311223</p>
                <p><strong>Email:</strong> dperantis@gmail.com</p><br><br>
                <p>A small gadget store located at Anjung Siswa, Uitm Perlis. Do not forget to visit us here! 
                    <br><br>Too far?<br> You can buy directly at our online store, just head to the 'Shop' section on the navigation bar.
                </p>
            </div>
        </div>
        <p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d495.5713924447842!2d100.27995953995267!3d6.44906561548692!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304ca3455f596521%3A0x8a3bb17202f2542a!2sANJUNG%20SISWA%20UiTM%20PERLIS!5e0!3m2!1sen!2smy!4v1717428621262!5m2!1sen!2smy" width="1000" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </p>
    </div>
    <br><br><br>
</body>
</html>
<?php include 'footer.php'; ?>