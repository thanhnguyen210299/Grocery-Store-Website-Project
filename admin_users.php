<?php
    @include 'config.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)){
        header('location:login.php');
    }

    if (isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        
        $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
        $delete_user->execute([$delete_id]);

        header('location: admin_users.php');
    }

    // Set the current page variable
    $currentPage = 'admin_users';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>

    <!-- Font Awesome cdn link -->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom css file link -->
    <link rel = "stylesheet" href = "css/admin_style.css">
</head>
<body>

    <?php include 'admin_header.php';?>

    <section class = "user-accounts">
        <h1 class = "title">User Accounts</h1>
        <div class = "box-container">
            <?php
                $select_users = $conn->prepare("SELECT * FROM `users`");
                $select_users->execute();

                if ($select_users->rowCount() > 0){
                    while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class = "box">
                <img src = "uploaded_img/<?= $fetch_users['image']; ?>" alt = "">
                <p>User ID: <span><?= $fetch_users['id']; ?></span></p>
                <p>Name: <span><?= $fetch_users['name']; ?></span></p>
                <p>Email: <span><?= $fetch_users['email']; ?></span></p>
                <p>User Type: <span style = "color: <?php if ($fetch_users['user_type'] == 'admin'){echo '#009042'; }; ?>"><?= $fetch_users['user_type']; ?></span></p>
                <a href = "admin_users.php?delete=<?= $fetch_users['id']; ?>" class = "delete-btn" onClick = "return confirm('Delete this Account?');">Delete</a>
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