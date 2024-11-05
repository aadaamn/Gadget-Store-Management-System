<?php

include 'components/connect.php';
require_once('TCPDF-main/tcpdf.php'); // Ensure the correct path to tcpdf.php

if (!isset($_POST['order_id'])) {
    die('Order ID not specified.');
}

$order_id = $_POST['order_id'];

// Fetch order details
$order_query = "SELECT * FROM `Order` WHERE OrderID = ?";
$stmt_order = $conn->prepare($order_query);
$stmt_order->execute([$order_id]);
$order = $stmt_order->fetch(PDO::FETCH_ASSOC);

// Fetch payment details
$payment_query = "SELECT * FROM Payment WHERE OrderID = ?";
$stmt_payment = $conn->prepare($payment_query);
$stmt_payment->execute([$order_id]);
$payment = $stmt_payment->fetch(PDO::FETCH_ASSOC);

// Fetch customer details
$customer_query = "SELECT * FROM Customer WHERE CustID = ?";
$stmt_customer = $conn->prepare($customer_query);
$stmt_customer->execute([$order['CustID']]);
$customer = $stmt_customer->fetch(PDO::FETCH_ASSOC);

// Fetch order items
$order_items_query = "SELECT * FROM OrderItem WHERE OrderID = ?";
$stmt_order_items = $conn->prepare($order_items_query);
$stmt_order_items->execute([$order_id]);
$order_items = $stmt_order_items->fetchAll(PDO::FETCH_ASSOC);

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('D Perantis Gadget Store');
$pdf->SetTitle('Order Receipt');
$pdf->SetSubject('Order Receipt');

// Add a page
$pdf->AddPage();

// Set content
$html = '<h1><br>Order Receipt</h1>';
$html .= '<h2>Order Details</h2>';
$html .= '<table border="1" cellpadding="4">
            <tr><th>Order ID</th><td>' . ($order['OrderID']) . '</td></tr>
            <tr><th>Order Date</th><td>' . ($order['OrderDate']) . '</td></tr>
            <tr><th>Total Products</th><td>' . ($order['TotalProd']) . '</td></tr>
            <tr><th>Total Amount</th><td>RM' . number_format($order['TotalAmount'], 2) . '</td></tr>
            <tr><th>Status</th><td>' . ($order['Status']) . '</td></tr>
          </table>';

$html .= '<h2>Customer Details</h2>';
$html .= '<table border="1" cellpadding="4">
            <tr><th>Name</th><td>' . ($customer['CustName']) . '</td></tr>
            <tr><th>Phone Number</th><td>' . ($customer['CustPhoneNo']) . '</td></tr>
            <tr><th>Address</th><td>' . ($customer['CustAddress']) . '</td></tr>
            <tr><th>Email</th><td>' . ($customer['CustEmail']) . '</td></tr>
          </table>';

$html .= '<h2>Order Items</h2>';
$html .= '<table border="1" cellpadding="4">
            <tr><th>Product ID</th><th>Quantity</th><th>Price Per Item</th><th>Total Price</th></tr>';
foreach ($order_items as $item) {
    $html .= '<tr>
                <td>' . ($item['ProdID']) . '</td>
                <td>' . ($item['Quantity']) . '</td>
                <td>RM' . number_format($item['PricePerItem'],2) . '</td>
                <td>RM' . number_format($item['TotalPrice'],2) . '</td>
              </tr>';
}
$html .= '</table>';

$html .= '<h2>Payment Details</h2>';
$html .= '<table border="1" cellpadding="4">
            <tr><th>Payment ID</th><td>' . ($payment['PayID']) . '</td></tr>
            <tr><th>Payment Date</th><td>' . ($payment['PayDate']) . '</td></tr>
            <tr><th>Amount Paid</th><td>RM' . number_format(($payment['AmountPaid']), 2) . '</td></tr>
          </table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('order_receipt.pdf', 'D'); // D for download, I for inline display

?>
