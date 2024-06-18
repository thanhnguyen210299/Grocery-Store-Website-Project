<?php
    @include 'config.php';

    session_start();

    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)){
        header('location:login.php');
    }

    if (isset($_POST['send'])){
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email= filter_var($email, FILTER_SANITIZE_STRING);

        $number = $_POST['number'];
        $number= filter_var($number, FILTER_SANITIZE_STRING);

        $msg = $_POST['message'];
        $msg= filter_var($msg, FILTER_SANITIZE_STRING);

        $select_message = $conn->prepare("SELECT * FROM `message` WHERE name = ? AND email = ? AND number = ? AND message = ?");
        $select_message->execute([$name, $email, $number, $msg]);
        
        if ($select_message->rowCount() > 0){
            $message[] = 'Already Sent Message!';
        } else{
            $insert_message = $conn->prepare("INSERT INTO `message`(user_id, name, email, number, message) VALUES (?, ?, ?, ?, ?)");
            $insert_message->execute([$user_id, $name, $email, $number, $msg]);

            $message[] = 'Sent Message Successfully';
        }
        
    }

    // Set the current page variable
    $currentPage = 'contact';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <!-- Font Awesome cdn link -->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom css file link -->
    <link rel = "stylesheet" href = "css/style.css">
</head>
<body>

    <?php include 'header.php';?>
    <section class = "contact">
        <h1 class = "title">Get In Touch</h1>
        <form action = "" method = "POST">
            <input type = "text" name = "name" class = "box" required placeholder = "Enter Your Name">
            <input type = "email" name = "email" class = "box" required placeholder = "Enter Your Email">
            <input type = "number" name = "number" min = "0" class = "box" required placeholder = "Enter Your Number">
            <textarea name = "message" class = "box" required placeholder = "Enter Your Message" cols = "30" rows = "10"></textarea>
            <input type = "submit" value = "Send Message" class = "btn" name = "send">
        </form>
    </section>

    <?php include 'footer.php';?>

    <!-- Custom js file -->
    <script src = "script.js"></script>
</body>
</html>