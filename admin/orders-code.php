<?php 

include('../config/function.php');

if(!isset($_SESSION['productItems'])){
    $_SESSION['productItems'] = [];
}
if(!isset($_SESSION['productItemIds'])){
    $_SESSION['productItemIds'] = [];
}

if(isset($_POST['addItem']) && $_SERVER["REQUEST_METHOD"] === 'POST'){
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $errors = [];

    $checkProduct = mysqli_query($con, "SELECT * FROM products WHERE id='$productId' LIMIT 1");
    if($checkProduct){
        if(mysqli_num_rows($checkProduct) > 0) {
            $row = mysqli_fetch_assoc($checkProduct);
            if($row['quantity'] < $quantity) {
                $errors[] = 'Only '.$row['quantity'].' quantity available!';
                if(!empty($errors)) {
                    redirect('order-create.php', $errors);
                }
            }else {
                $productData = [
                    'product_id' => $row['id'],
                    'name' => $row['name'],
                    'image' => $row['image'],
                    'price' => $row['price'],
                    'quantity' => $quantity
                ];
                
                if(!in_array($row['id'], $_SESSION['productItemIds'])) {
                    array_push($_SESSION['productItemIds'], $row['id']);
                    array_push($_SESSION['productItems'], $productData);
                }else {
                    foreach($_SESSION['productItems'] as $key => $productSessionItem) {
                        if($productSessionItem['product_id'] == $row['id']){
                            $newQuantity = $productSessionItem['quantity'] + $quantity;
                            $productData = [
                                'product_id' => $row['id'],
                                'name' => $row['name'],
                                'image' => $row['image'],
                                'price' => $row['price'],
                                'quantity' => $newQuantity
                            ];
                            $_SESSION['productItems'][$key] = $productData;
                        }
                    }
                }
                redirect('order-create.php', 'Item Added '.$row['name']);
            }
        }else {
            $errors[] = 'No such product found!';
            if(!empty($errors)) {
                redirect('order-create.php', $errors);
            }
        }
    }else {
        $errors[] = 'Something Went Wrong';
        if(!empty($errors)) {
            redirect('order-create.php', $errors);
        }
    }
}

if(isset($_POST['productIncDec'])) {
    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $flag = false;

    foreach($_SESSION['productItems'] as $key => $item) {
        if($item['product_id'] == $productId){
            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }

    if($flag){
        jsonResponse(200,'success','Quantity Updated');
    }else {
        jsonResponse(500,'error','Something Went Wrong. Please re-fresh');
    }
}

if(isset($_POST['proceedToPlaceBtn'])){
    $phone = validate($_POST['cphone']);
    $payment_mode = validate($_POST['payment_mode']);

    // Checking for customer
    $checkCustomer = mysqli_query($con, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
    if($checkCustomer){
        if(mysqli_num_rows($checkCustomer) > 0){
            $_SESSION['invoice_no'] = "INV-".rand(111111,999999);
            $_SESSION['cphone'] = $phone;
            $_SESSION['payment_mode'] = $payment_mode;
            jsonResponse(200, 'success', 'Customer found.');

        }else {
             $_SESSION['cphone'] = $phone;
            jsonResponse(404, 'warning', 'Customer Not found');
        }
    }else {
        jsonResponse(500, 'error', 'Something Went Wrong');
    }

}

if(isset($_POST['saveCustomerBtn'])){
    $name = validate($_POST['c_name']);
    $phone = validate($_POST['c_phone']);
    $email = validate($_POST['c_email']);

    if($name !='' && $phone !=''){

        $data = [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
        ];
        $result = insert('customers', $data);
        if($result){

            jsonResponse(200, 'success', 'Customer Created Successfully');
        }else {
            jsonResponse(500, 'error', 'Something Went Wrong');
        }
    }else {
        jsonResponse(422, 'warning', 'Please fill requierd fields');
    }
}


if(isset($_POST['saveOrder'])){
    $phone = validate($_SESSION['cphone']);
    $invoice_no = validate($_SESSION['invoice_no']);
    $payment_mode = validate($_SESSION['payment_mode']);
    $order_placed_by_id = $_SESSION['loggedInUser']['user_id'];

    $checkCustomer = mysqli_query($con, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");
    if(!$checkCustomer){
        jsonResponse(500, 'error', 'Something Went Wrong');
    }

    if(mysqli_num_rows($checkCustomer) > 0) {
        $customerData = mysqli_fetch_assoc($checkCustomer);
        if(!isset($_SESSION['productItems'])){
            jsonResponse(404, 'warning', 'No Items to place order!');
        }

        $sessionProducts = $_SESSION['productItems'];
        $totalAmount = 0;

        foreach($sessionProducts as $amountItem){
            $totalAmount += $amountItem['price'] * $amountItem['quantity'];
        }

        $data = [
            'customer_id' => $customerData['id'],
            'tracking_no' => rand(111111,999999),
            'invoice_no' => $invoice_no,
            'total_amount' => $totalAmount,
            'order_date' => date('Y-m-d'),
            'order_status' => 'booked',
            'payment_mode' => $payment_mode,
            'order_placed_by_id' => $order_placed_by_id
        ];
        $result = insert('orders', $data);
        $lastOrderId = mysqli_insert_id($con);
        foreach($sessionProducts as $productItem){
            $productId = $productItem['product_id'];
            $price = $productItem['price'];
            $quantity = $productItem['quantity'];

            // inserting order items
            $dataOrderItem = [
                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity
            ];
            $orderItemQuery = insert('order_items', $dataOrderItem);

            // Checking for the books quantity and decreasing quantity and making total quantity
            $checkProductQuantityQuery = mysqli_query($con, "SELECT * FROM products WHERE id='$productId'");
            $productData = mysqli_fetch_assoc($checkProductQuantityQuery);
            $totalProductQuantity = $productData['quantity'] - $quantity;

            $dataUpdate = [
                'quantity' => $totalProductQuantity
            ];
            $updateProductQuantity = update('products', $productId, $dataUpdate);
        }

        unset($_SESSION['productItemIds']);
        unset($_SESSION['productItems']);
        unset($_SESSION['cphone']);
        unset($_SESSION['payment_mode']);
        unset($_SESSION['invoice_no']);

        jsonResponse(200, 'success', 'Order Placed Successfully.');
    }else {
        jsonResponse(404, 'warning', 'No customer found!');
    }
}