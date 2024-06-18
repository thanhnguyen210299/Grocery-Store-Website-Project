<?php
    @include 'config.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)){
        header('location:login.php');
    }

    if (isset($_POST['update_order'])){
        $order_id = $_POST['order_id'];

        $update_payment = $_POST['update_payment'];
        $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);

        $update_orders = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
        $update_orders->execute([$update_payment, $order_id]);
        $message[] = 'Payment Has Been Updated';
    }

    if (isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        
        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
        $delete_order->execute([$delete_id]);

        header('location: admin_orders.php');
    }

    // Set the current page variable
    $currentPage = 'admin_orders';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

    <!-- Font Awesome cdn link -->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom css file link -->
    <link rel = "stylesheet" href = "css/admin_style.css">
</head>
<body>

    <?php include 'admin_header.php';?>

    <section class = "place-orders">
        <h1 class = "title">Placed Orders</h1>
        <div class = "box-container">
            <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders`");
                $select_orders->execute();

                if ($select_orders->rowCount() > 0){
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class = "box">
                <p>User ID: <span><?= $fetch_orders['user_id']; ?></span></p>
                <p>User Name: <span><?= $fetch_orders['name']; ?></span></p>
                <p>User Email: <span><?= $fetch_orders['email']; ?></span></p>
                <p>User Number: <span><?= $fetch_orders['number']; ?></span></p>
                <p>User Address: <span><?= $fetch_orders['address']; ?></span></p>
                <p>Placed On: <span><?= $fetch_orders['placed_on']; ?></span></p>
                <p>Total Products: <span><?= $fetch_orders['total_products']; ?></span></p>
                <p>Total Price: <span>$<?= $fetch_orders['total_price']; ?></span></p>
                <p>Payment Method: <span><?= $fetch_orders['method']; ?></span></p>
                <p>Order Status:</p>
                <form action = "" method = "POST">
                    <input type = "hidden" name = "order_id" value = "<?= $fetch_orders['id']; ?>">
                    <select name = "update_payment" class = "drop-down">
                        <option value = "" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                        <option value = "Pending">Pending</option>
                        <option value = "Completed">Completed</option>
                    </select>
                    <div class = "flex-btn">
                        <input type = "submit" name = "update_order" class = "option-btn" value = "Update">
                        <a href = "admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class = "delete-btn" onClick = "return confirm('Delete this Order?');">Delete</a>
                    </div>
                </form>
            </div>

            <?php
                }
            } else {
                echo '<p class = "empty">No Order Placed Yet!</p>';
            }
            ?>
        </div>
    </section>
    

    <!-- Custom js file -->
    <script src = "script.js"></script>
</body>
</html>