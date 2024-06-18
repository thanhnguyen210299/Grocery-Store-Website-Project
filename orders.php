<?php
    @include 'config.php';

    session_start();

    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)){
        header('location:login.php');
    }

    // Set the current page variable
    $currentPage = 'orders';
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
    <link rel = "stylesheet" href = "css/style.css">
</head>
<body>

    <?php include 'header.php';?>

    <section class = "placed-orders">
        <h1 class = "title">Placed Orders</h1>
        <div class = "box-container">
            <?php
                $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
                $select_orders->execute([$user_id]);

                if ($select_orders->rowCount() > 0){
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
            ?>
        <div class = "box">
            <p>Placed on: <span><?= $fetch_orders['placed_on'] ?></span></p>
            <p>Name: <span><?= $fetch_orders['name'] ?></span></p>
            <p>Phone number: <span><?= $fetch_orders['number'] ?></span></p>
            <p>Email: <span><?= $fetch_orders['email'] ?></span></p>
            <p>Address: <span><?= $fetch_orders['address'] ?></span></p>
            <p>Payment method: <span><?= $fetch_orders['method'] ?></span></p>
            <p>Your orders: <span><?= $fetch_orders['total_products'] ?></span></p>
            <p>Total price: <span>$<?= $fetch_orders['total_price'] ?></span></p>
            <p>Payment status: <span style = "color: <?php if ($fetch_orders['payment_status'] == 'Pending'){ echo 'red'; } else { echo 'green';} ?>"><?= $fetch_orders['payment_status'] ?></span></p>
        </div>
        <?php
                }
            } else {
                echo '<p class = "empty">You Have Not Placed Any Order Yet!</p>';
            }
        ?>
    </section>

    <?php include 'footer.php';?>

    <!-- Custom js file -->
    <script src = "script.js"></script>
</body>
</html>