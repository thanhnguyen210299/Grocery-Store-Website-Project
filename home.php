<?php
    @include 'config.php';

    session_start();

    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)){
        header('location:login.php');
    }

    if (isset($_POST['add_to_wishlist'])){
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);

        $p_name = $_POST['p_name'];
        $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);

        $p_price = $_POST['p_price'];
        $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);

        $p_image = $_POST['p_image'];
        $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

        $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
        $check_wishlist_numbers->execute([$p_name, $user_id]);

        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
        $check_cart_numbers->execute([$p_name, $user_id]);

        if ($check_wishlist_numbers->rowCount() > 0){
            $message[] = 'Already Added to Wishlist!';
        } elseif ($check_cart_numbers->rowCount() > 0){
            $message[] = 'Already Added to Cart!';
        } else{
            $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES (?, ?, ?, ?, ?)");
            $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
            $message[] = 'Added to Wishlist!';
        }
    }

    if (isset($_POST['add_to_cart'])){
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);

        $p_name = $_POST['p_name'];
        $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);

        $p_price = $_POST['p_price'];
        $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);

        $p_qty = $_POST['p_qty'];
        $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

        $p_image = $_POST['p_image'];
        $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
        $check_cart_numbers->execute([$p_name, $user_id]);

        if ($check_cart_numbers->rowCount() > 0){
            $message[] = 'Already Added to Cart!';
        } else{
            $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
            $check_wishlist_numbers->execute([$p_name, $user_id]);

            if ($check_wishlist_numbers->rowCount() > 0){
                $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
                $delete_wishlist->execute([$p_name, $user_id]);
            }

            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
            $message[] = 'Added to Cart!';
        }
    }

    // Set the current page variable
    $currentPage = 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    <!-- Font Awesome cdn link -->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom css file link -->
    <link rel = "stylesheet" href = "css/style.css">
</head>
<body>
    <?php include 'header.php';?>

    <div class = "home-bg">
        <section class = "home">
            <div class = "content">
                <span> Don't panic, go organic </span>
                <h3>Reach for a Healthier You with Organic Foods</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo odio enim consequuntur vitae reprehenderit at veniam ipsam inventore ipsum non.</p>
                <a href = "about.php" class = "btn">About Us</a>
            </div>
        </section>
    </div>

    <section class = "home-category">
        <h1 class = "title">Shop by Category</h1>
        <div class = "box-container">
            <div class = "box">
                <img src = "images/cate_fruits.jpg" alt = "">
                <h3>Fruits</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, fugit?</p>
                <a href = "category.php?category=fruit" class = "btn">Fruits</a>
            </div>

            <div class = "box">
                <img src = "images/cate_meat.png" alt = "">
                <h3>Meat</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, fugit?</p>
                <a href = "category.php?category=meat" class = "btn">Meat</a>
            </div>

            <div class = "box">
                <img src = "images/cate_vege.jpg" alt = "">
                <h3>Vegetables</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, fugit?</p>
                <a href = "category.php?category=vegetables" class = "btn">Vegetables</a>
            </div>

            <div class = "box">
                <img src = "images/cate_fish.jpg" alt = "">
                <h3>Fish</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, fugit?</p>
                <a href = "category.php?category=fish" class = "btn">Fish</a>
            </div>
        </div>
    </section>

    <section class = "products">
        <h1 class = "title">Latest Products</h1>
        <div class = "box-container">
            <?php
                $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
                $select_products->execute();

                if ($select_products->rowCount() > 0){
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
            ?>
            <form action = "" class = "box" method = "POST">
                <div class = "price">$<span><?= $fetch_products['price']; ?></span>/-</div>
                <a href = "view_page.php?pid=<?= $fetch_products['id']; ?>" class = "fas fa-eye"></a>
                <img src = "uploaded_img/<?= $fetch_products['image']; ?>" alt = "">
                <div class = "name"><?= $fetch_products['name']; ?></div>
                <input type = "hidden" name = "pid" value = "<?= $fetch_products['id']; ?>">
                <input type = "hidden" name = "p_name" value = "<?= $fetch_products['name']; ?>">
                <input type = "hidden" name = "p_price" value = "<?= $fetch_products['price']; ?>">
                <input type = "hidden" name = "p_image" value = "<?= $fetch_products['image']; ?>">
                <input type = "number" min = "1" value = "1" name = "p_qty" class = "qty">
                <input type = "submit" value = "Add to Wishlist" class = "option-btn" name = "add_to_wishlist">
                <input type = "submit" value = "Add to Cart" class = "btn" name = "add_to_cart">
            </form>
            <?php
                    }
                } else {
                    echo '<p class = "empty">No Product Added Yet!</p>';
                }
            ?>
        </div>
    </section>

    <?php include 'footer.php';?>

    <!-- Custom js file -->
    <script src = "script.js"></script>
</body>
</html>