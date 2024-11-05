<?php

    include 'components/sessionstart.php';

    // Ensure CustID is set in the session
    if (!isset($_SESSION['CustID'])) {
        die('Customer not logged in.');
    }

    $cust_id = $_SESSION['CustID'];

    // Check if the GET parameters are set and assign them to variables
    $status_id = isset($_GET['status_id']) ? $_GET['status_id'] : null;
    $billcode = isset($_GET['billcode']) ? $_GET['billcode'] : null;

    // If either status_id or billcode is not set, terminate the script
    if (!$status_id || !$billcode) {
        die('Invalid payment details.');
    }

    $some_data = array(
        'billCode' => $billcode,
        'billpaymentStatus' => $status_id
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/getBillTransactions');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
    $result = curl_exec($curl);
    $info = curl_getinfo($curl);
    curl_close($curl);

    $result = json_decode($result, true);
    $obj = $result[0];

    // Check if the payment status is successful
    if ($status_id == 1) {
        $order_date = date('Y-m-d H:i:s', strtotime($obj['billPaymentDate']));
        $amount_paid = $obj['billpaymentAmount'];
        $order_status = 'Paid';

        try {
            // Begin transaction
            $conn->beginTransaction();

            // 1. Create Order
            $insert_order_query = "INSERT INTO `Order` (OrderDate, CustID, TotalProd, TotalAmount, Status) 
                                VALUES (?, ?, 0, 0, ?)";
            $stmt = $conn->prepare($insert_order_query);
            $stmt->execute([$order_date, $cust_id, $order_status]);
            $order_id = $conn->lastInsertId();

            // 2. Transfer/move cart items to order item table
            $cart_items_query = "SELECT * FROM Cart WHERE CustID = ?";
            $stmt = $conn->prepare($cart_items_query);
            $stmt->execute([$cust_id]);
            $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $total_prod = 0;
            $total_amount = 0;

            foreach ($cart_items as $item) {
                $prod_id = $item['ProdID'];
                $quantity = $item['Quantity'];

                // Retrieve product price
                $price_query = "SELECT ProdPrice FROM Product WHERE ProdID = ?";
                $stmt_price = $conn->prepare($price_query);
                $stmt_price->execute([$prod_id]);
                $price_row = $stmt_price->fetch(PDO::FETCH_ASSOC);
                $price_per_item = $price_row['ProdPrice'];

                $total_price = $price_per_item * $quantity;
                $total_prod += $quantity;
                $total_amount += $total_price;

                // Insert into OrderItem
                $insert_order_item_query = "INSERT INTO OrderItem (OrderID, ProdID, PricePerItem, Quantity, TotalPrice) 
                                            VALUES (?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($insert_order_item_query);
                $stmt_insert->execute([$order_id, $prod_id, $price_per_item, $quantity, $total_price]);
            }

            // Update order with total products and amount
            $update_order_query = "UPDATE `Order` SET TotalProd = ?, TotalAmount = ? WHERE OrderID = ?";
            $stmt_update = $conn->prepare($update_order_query);
            $stmt_update->execute([$total_prod, $total_amount, $order_id]);

            // 3. Create payment entry
            $payment_date = date('Y-m-d H:i:s', strtotime($obj['billPaymentDate']));
            $insert_payment_query = "INSERT INTO Payment (PayID, PayDate, AmountPaid, OrderID) 
                                    VALUES (?, ?, ?, ?)";
            $stmt_payment = $conn->prepare($insert_payment_query);
            $stmt_payment->execute([$billcode, $payment_date, $amount_paid, $order_id]);

            // 4. Remove items from the cart
            $delete_cart_query = "DELETE FROM Cart WHERE CustID = ?";
            $stmt_delete = $conn->prepare($delete_cart_query);
            $stmt_delete->execute([$cust_id]);

            // 5. Create a delivery entry in the database
            $tracking_code = NULL;
            $courier_name = NULL;

            $create_delivery_query = "INSERT INTO Delivery (OrderID, TrackingCode, CourierName) 
                                    VALUES (?, ?, ?)";
            $stmt_delivery = $conn->prepare($create_delivery_query);
            $stmt_delivery->execute([$order_id, $tracking_code, $courier_name]);

            // Commit transaction
            $conn->commit();

            // Redirect to receipt page with order ID
            header('Location: order_success.php?order_id=' . $order_id);
            exit();
        } catch (Exception $e) {
            // If error
            $conn->rollBack();
        }
    }
    // if payment unsuccessfull
    else if ($status_id == 3){
        header('Location: order_unsuccessful.php');
    }
?>
