<?php
    @include 'config.php';

    session_start();

    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)){
        header('location:login.php');
    }

    if (isset($_POST['order'])){
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email= filter_var($email, FILTER_SANITIZE_STRING);

        $number = $_POST['number'];
        $number= filter_var($number, FILTER_SANITIZE_STRING);

        $method = $_POST['method'];
        $method= filter_var($method, FILTER_SANITIZE_STRING);

        $address = $_POST['flat'] .' '. $_POST['street'] .', '. $_POST['city'] .' '. $_POST['state'] .' - '. $_POST['zip_code'] .', '. $_POST['country'];
        $address= filter_var($address, FILTER_SANITIZE_STRING);

        $placed_on = date('MM/D/YYYY');

        $cart_total = 0;
        $cart_products[] = '';

        $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $cart_query->execute([$user_id]);

        if ($cart_query->rowCount() > 0){
            while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
                $cart_products[] = $cart_item['name']. ' x ' . $cart_item['quantity'];
                $sub_total = ($cart_item['price'] * $cart_item['quantity']);
                $cart_total += $sub_total;
            }
        }
        
        $total_products = implode(', ', $cart_products);

        $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
        $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

        if ($cart_total == 0){
            $message[] = 'Your Cart is Empty!';
        } elseif ($order_query->rowCount() > 0){
            $message[] = 'Order Placed Already';
        } else{
            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on]);

            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);

            $message[] = 'Order Placed Successfully!';
        }
    }

    // Set the current page variable
    $currentPage = 'orders';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <!-- Font Awesome cdn link -->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom css file link -->
    <link rel = "stylesheet" href = "css/style.css">
</head>
<body>

    <?php include 'header.php';?>

    <section class = "display-orders">
        <?php
            $cart_grand_total = 0;
            $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart_items->execute([$user_id]);

            if ($select_cart_items->rowCount() > 0){
                while ($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
                    $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
                    $cart_grand_total += $cart_total_price;
        ?>
        <p><?= $fetch_cart_items['name']; ?> <span>(<?= '$'. $fetch_cart_items['price'] .' x '. $fetch_cart_items['quantity']; ?>)</span></p>
        <?php
                }
            } else {
                echo '<p class = "empty">Your Cart is Empty!</p>';
            }
        ?>

        <div class = "grand-total">
            <p>Grand Total: <span>$<?= $cart_grand_total; ?>/-</span></p>
        </div>
    </section>

    <section class = "checkout-orders">
        <form action = "" method = "POST">
            <h3>Place Your Order</h3>
            <div class = "flex">
                <div class = "inputBox">
                    <span>Your Name: </span>
                    <input type = "text" name = "name" placeholder = "Enter Your Name" class = "box" required>
                </div>

                <div class = "inputBox">
                    <span>Your Email: </span>
                    <input type = "text" name = "email" placeholder = "Enter Your Email" class = "box" required>
                </div>

                <div class = "inputBox">
                    <span>Your Phone Number: </span>
                    <input type = "number" name = "phone" placeholder = "Enter Your Phone Number" class = "box" required>
                </div>

                <div class = "inputBox">
                    <span>Payment Method: </span>
                    <select name = "method" class = "box" required>
                        <option value = "cash on delivery">Cash On Delivery</option>
                        <option value = "credit card">Credit Card</option>
                        <option value = "apple pay">Apple Pay</option>
                        <option value = "paypal">Paypal</option>
                    </select>
                </div>

                <div class = "inputBox">
                    <span>Address Line 01: </span>
                    <input type = "text" name = "flat" placeholder = "e.g. Flat number" class = "box" required>
                </div>

                <div class = "inputBox">
                    <span>Address Line 02: </span>
                    <input type = "text" name = "street" placeholder = "e.g. Street name" class = "box" required>
                </div>

                <div class = "inputBox">
                    <span>City: </span>
                    <input type = "text" name = "city" placeholder = "Enter City" class = "box" required>
                </div>

                <div class = "inputBox">
                    <span>State: </span>
                    <input type = "text" name = "state" placeholder = "Enter State" class = "box" required>
                </div>

                <div class = "inputBox">
                    <span>Zip Code: </span>
                    <input type = "number" min = "0" name = "zip_code" placeholder = "Enter Zip Code" class = "box" required>
                </div>

                <div class = "inputBox">
                    <span>Country: </span>
                    <input type = "text" name = "country" placeholder = "Enter Country" class = "box" required>
                </div>
            </div>

            <input type = "submit" name = "order" class = "btn <?= ($cart_grand_total > 0) ? '' : 'disabled'; ?>" value = "Place An Order">
        </form>
    </section>

    <?php include 'footer.php';?>

    <!-- Custom js file -->
    <script src = "script.js"></script>
</body>
</html>