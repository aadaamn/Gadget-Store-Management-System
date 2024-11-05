<?php
  // connection
  include 'components/sessionstart.php';

  // data collected from form in checkout
  $cust_id = $_POST['CustID'];
  $cust_name = $_POST['CustName'];
  $cust_email = $_POST['CustEmail'];
  $cust_phoneno = $_POST['CustPhoneNo'];
  $cust_address = $_POST['CustAddress'];
  $total_price = $_POST['TotalAmount'];

  // customer details
  $update_query = "UPDATE Customer
                      SET CustName = ?, CustAddress = ?, CustPhoneNo = ?
                      WHERE CustID = ?";

  // Prepare and execute the statement
  $stmt = $conn->prepare($update_query);
  $stmt->execute([$cust_name, $cust_address, $cust_phoneno, $cust_id]);
  echo $cust_email, $cust_name, $cust_phoneno, $total_price;
  $rmx100=($total_price * 100);
  $post_data = array(
      'userSecretKey'=> '',
      'categoryCode'=> '',
      'billName'=> 'D Perantis Online Store',
      'billDescription'=> 'Gadgets Worth: RM'.$total_price ,
      'billPriceSetting'=>1,
      'billPayorInfo'=>1,
      'billAmount'=>$rmx100,
      'billReturnUrl'=>'http://localhost:3000/payment_process.php',
      'billCallbackUrl'=>'http://localhost:3000/home.php',
      'billExternalReferenceNo'=>'',
      'billTo'=>$cust_name,
      'billEmail'=>$cust_email,
      'billPhone'=>$cust_phoneno,
      'billSplitPayment'=>0,
      'billSplitPaymentArgs'=>'',
      'billPaymentChannel'=>0,
    );  
    
    // php curl to post data to payment gateway
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

    $result = curl_exec($curl);
    $info = curl_getinfo($curl);
    curl_close($curl);
    $result = json_decode($result, true);

    $post_data['billCode'] = $result[0]['BillCode'];
    $post_data['paymentURL'] = 'https://dev.toyyibpay.com/' . $result[0]['BillCode'];

    header('Location: ' . $post_data['paymentURL']);
?>
