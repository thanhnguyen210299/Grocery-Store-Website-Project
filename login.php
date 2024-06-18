<?php
    include 'config.php';

    session_start();

    if (isset($_POST['submit'])){
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $pass = md5($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $select = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
        $select->execute([$email, $pass]);
        $row = $select->fetch(PDO::FETCH_ASSOC);

        if ($select->rowCount() > 0){
            if ($row['user_type'] == 'admin'){
                $_SESSION['admin_id'] = $row['id'];
                header('location:admin_page.php');
            } elseif ($row['user_type'] == 'user'){
                $_SESSION['user_id'] = $row['id'];
                header('location:home.php');
            } else{
                $message[] = 'No user found!';
            }
        } else{
            $message[] = 'Incorrect email or password';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Font Awesome cdn link -->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom css file link -->
    <link rel = "stylesheet" href = "css/components.css">

</head>
<body>
    <div class = "background-gradient">
        <div class = "background-animation">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <?php
            if (isset($message)){
                foreach ($message as $message){
                    echo '
                        <div class = "message">
                            <span>'.$message.'</span>
                            <i class="fas fa-times" onClick = "this.parentElement.remove();"></i>
                        </div>
                    ';
                }
            }
        ?>

        <section class = "form-container">
            <form action = "" enctype ="multipart/form-data" method = "POST">
                <h3>Login Now</h3>
                <input type = "email" name = "email" class = "box" placeholder = "Enter Your Email" required>
                <input type = "password" name = "pass" class = "box" placeholder = "Enter Your Password" required>
                <input type = "submit" value = "Login" class = "btn" name = "submit">
                <p>Don't have an account? <a href = "register.php">Register Now</a></p>
            </form>
        </section>
     </div>
</body>
</html>