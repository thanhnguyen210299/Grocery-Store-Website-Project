<?php
    @include 'config.php';

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)){
        header('location:login.php');
    }

    if (isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
        
        $delete_message = $conn->prepare("DELETE FROM `message` WHERE id = ?");
        $delete_message->execute([$delete_id]);

        header('location: admin_contacts.php');
    }

    // Set the current page variable
    $currentPage = 'admin_contacts';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>

    <!-- Font Awesome cdn link -->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom css file link -->
    <link rel = "stylesheet" href = "css/admin_style.css">
</head>
<body>

    <?php include 'admin_header.php';?>
    
    <section class = "messages">
        <h1 class = "title">Messages</h1>
        <div class = "box-container">
            <?php
                $select_message = $conn->prepare("SELECT * FROM `message`");
                $select_message->execute();

                if ($select_message->rowCount() > 0){
                    while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class = "box">
                <p>User ID: <span><?= $fetch_message['user_id']; ?></span></p>
                <p>User Name: <span><?= $fetch_message['name']; ?></span></p>
                <p>User Email: <span><?= $fetch_message['email']; ?></span></p>
                <p>User Number: <span><?= $fetch_message['number']; ?></span></p>
                <p>Message: <span><?= $fetch_message['message']; ?></span></p>
                <a href = "admin_contacts.php?delete=<?= $fetch_message['id']; ?>" class = "delete-btn" onClick = "return confirm('Delete this Message?');">Delete</a>
            </div>

            <?php
                }
            } else {
                echo '<p class = "empty">You Have No Message!</p>';
            }
            ?>
        </div>
    </section>

    <!-- Custom js file -->
    <script src = "script.js"></script>
</body>
</html>