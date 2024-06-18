<?php
    include 'config.php';

    if (isset($_POST['submit'])){
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $pass = md5($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $cpass = md5($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/'.$image;

        $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
        $select->execute([$email]);

        if ($select->rowCount() > 0){
            $message[] = 'User email already exists!';
        } else{
            if ($pass != $cpass){
                $message[] = 'Confirm password not matched!';
            } else{
                $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
                $insert->execute([$name, $email, $pass, $image]);
                
                if ($insert){
                    if ($image_size > 2000000){
                        $messagep[] = 'Image size is too large!';
                    } else{
                        move_uploaded_file($image_tmp_name, $image_folder);
                        $message[] = 'Registered successfully!';
                        header('location:login.php');
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

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
                <h3>Register Now</h3>
                <input type = "text" name = "name" class = "box" placeholder = "Enter Your Name" required>
                <input type = "email" name = "email" class = "box" placeholder = "Enter Your Email" required>
                <input type = "password" name = "pass" class = "box" placeholder = "Enter Your Password" required>
                <input type = "password" name = "cpass" class = "box" placeholder = "Confirm Your Password" required>
                <input type = "file" name = "image" class = "box" required accept = "image/jpg, image/jpeg, image/png">
                <input type = "submit" value = "Register Now" class = "btn" name = "submit">
                <p>Already have an account? <a href = "login.php">Login Now</a></p>
            </form>
        </section>
    </div>
</body>
</html>