<?php
    @include 'config.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)){
        header('location:login.php');
    }

    if (isset($_POST['add_product'])){
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $category = $_POST['category'];
        $category = filter_var($category, FILTER_SANITIZE_STRING);

        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);

        $details = $_POST['details'];
        $details = filter_var($details, FILTER_SANITIZE_STRING);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/'.$image;

        $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
        $select_products->execute([$name]);

        if ($select_products->rowCount() > 0){
            $message[] = "Product Name Already Exits.";
        } else {
            $insert_product = $conn->prepare("INSERT INTO `products` (name, category, details, price, image) VALUES (?, ?, ?, ?, ?)");
            $insert_product->execute([$name, $category, $details, $price, $image]);

            if ($insert_product){
                if ($image_size > 2000000){
                    $message[] = 'Image size is too large!';
                } else {
                    move_uploaded_file($image_tmp_name, $image_folder);
                    $message[] = 'A new product added.';
                }
            }
        }
    }

    if (isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        $select_delete_image = $conn->prepare("SELECT image FROM `products` WHERE id = ?");
        $select_delete_image->execute([$delete_id]);
        $fetch_delete_image = $select_delete_image->fetch(PDO::FETCH_ASSOC);
        unlink('uploaded_img/'.$fetch_delete_image['image']);
        $delete_product = $conn->prepare("DELETE * FROM `products` WHERE id = ?");
        $delete_product->execute([$delete_id]);

        $delete_wishlist = $conn->prepare("DELETE * FROM `wishlist` WHERE pid = ?");
        $delete_wishlist->execute([$delete_id]);

        $delete_cart = $conn->prepare("DELETE * FROM `cart` WHERE pid = ?");
        $delete_cart->execute([$delete_id]);

        header('location: admin_products.php');
    }

    // Set the current page variable
    $currentPage = 'admin_products';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <!-- Font Awesome cdn link -->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom css file link -->
    <link rel = "stylesheet" href = "css/admin_style.css">
</head>
<body>

    <?php include 'admin_header.php';?>

    <section class = "add-products">
        <h1 class = "title">Add New Product</h1>

        <form action = "" method = "POST" enctype = "multipart/form-data">
            <div class = "flex">
                <div class = "input-box">
                    <input type = "text" name = "name" class = "box" required placeholder = "Enter Product Name">
                    <select name = "category" class = "box" required>
                        <option value = "" selected disabled>Select Category</option>
                        <option value = "vegetables">Vegetables</option>
                        <option value = "fruit">Fruit</option>
                        <option value = "meat">Meat</option>
                        <option value = "fish">Fish</option>
                    </select>
                </div>

                <div class = "input-box">
                    <input type = "number" min = "0" name = "price" class = "box" required placeholder = "Enter Product Price">
                    <input type = "file" name = "image" class = "box" required accept = "image/jpg, image/jpeg, image/png">
                </div>
                
                <textarea name = "details" class = "box" required placeholder = "Enter Product Details" cols = "30" rows = "10"></textarea>

                <input type = "submit" class = "btn" value = "Add Product" name = "add_product">
                
            </div>
        </form>
    </section>
    
    <section class = "show-products">
        <h1 class = "title">Products Added</h1>
        <div class = "box-container">
            <?php
                $show_products = $conn->prepare("SELECT * FROM `products`");
                $show_products->execute();

                if ($show_products->rowCount() > 0){
                    while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class = "box">
                <div class = "price">$<?= $fetch_products['price']; ?>/-</div>
                <img src = "uploaded_img/<?= $fetch_products['image']; ?>" alt = "">
                <div class = "name"><?= $fetch_products['name']; ?></div>
                <div class = "category"><?= $fetch_products['category']; ?></div>
                <div class = "details">
                    <div class = "short-details"><?= substr($fetch_products['details'], 0, 100); ?>...</div>
                    <div class = "full-details" style = "display: none;"><?= $fetch_products['details']; ?></div>
                    <a href = "#" class = "read-more">Read more <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class = "flex-btn">
                    <a href = "admin_update_product.php?update=<?= $fetch_products['id']; ?>" class = "option-btn">Update</a>
                    <a href = "admin_products.php?delete=<?= $fetch_products['id']; ?>" class = "delete-btn" onClick = "return confirm('Delete This Product?');">Delete</a>
                </div>
            </div>
            <?php
                    }
                } else {
                    echo '<p class = "empty">No Product Added Yet!</p>';
                }
            ?>
        </div>
    </section>
    <!-- Custom js file -->
    <script src = "script.js"></script>
</body>
</html>