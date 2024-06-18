<?php
    @include 'config.php';

    session_start();

    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)){
        header('location:login.php');
    }

    if (isset($_POST['update_profile'])){
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email= filter_var($email, FILTER_SANITIZE_STRING);

        $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
        $update_profile->execute([$name, $email, $user_id]);

        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/'.$image;
        $old_image = $_POST['old_image'];

        if (!empty($image)){
            if ($image_size > 2000000){
                $message[] = 'Image size is too large';
            } else{
                $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
                $update_image->execute([$image, $user_id]);
                if ($update_image){
                    move_uploaded_file($image_tmp_name, $image_folder);
                    unlink('uploaded_img/'.$old_image);
                    $message[] = 'Image updated successfully!';
                }
            }
        }

        $old_pass = $_POST['old_pass'];
        $empty_pass = md5('');

        $update_pass = md5($_POST['update_pass']);
        $update_pass = filter_var($update_pass, FILTER_SANITIZE_STRING);

        $new_pass = md5($_POST['new_pass']);
        $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

        $confirm_pass = md5($_POST['confirm_pass']);
        $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

        if (($update_pass != $empty_pass) AND ($new_pass != $empty_pass) AND ($confirm_pass != $empty_pass)){
            if ($update_pass != $old_pass){
                $message[] = 'Old password not matched!';
            } elseif ($new_pass != $confirm_pass){
                $message[] = 'Confirm password not matched!';
            } else {
                $update_pass_query = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                $update_pass_query->execute([$new_pass, $user_id]);
                $message[] = 'Password updated successfully!';
            }
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Profile</title>

    <!-- Font Awesome cdn link -->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom css file link -->
    <link rel = "stylesheet" href = "css/style.css">
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
        <?php include 'header.php';?>

        <section class = "update-profile">
            <h1 class = "title">Update Profile</h1>

            <form action = "" method = "POST" enctype ="multipart/form-data">
                <img src = "uploaded_img/<?= $fetch_profile['image']; ?>" alt = "">
                <div class = "flex">
                    <div class = "input-box">
                        <span>Username:</span>
                        <input type = "text" name = "name" value = "<?= $fetch_profile['name']; ?>" placeholder = "Update username" required class = "box">
                        
                        <span>Email:</span>
                        <input type = "email" name = "email" value = "<?= $fetch_profile['email']; ?>" placeholder = "Update email" required class = "box">
                        
                        <span>Profile Picture:</span>
                        <input type = "file" name = "image" class = "box" accept = "image/jpg, image/jpeg, image/png">

                        <input type = "hidden" name = "old_image" value = "<?= $fetch_profile['image']; ?>">
                    </div>
                    <div class = "input-box">
                        <input type = "hidden" name = "old_pass" value = "<?= $fetch_profile['password']; ?>">
                    
                        <span>Old Password:</span>
                        <input type = "password" name = "update_pass" placeholder = "Enter previous password" class = "box">
                        
                        <span>New Password:</span>
                        <input type = "password" name = "new_pass" placeholder = "Enter new password" class = "box">
                        
                        <span>Confirm Password:</span>
                        <input type = "password" name = "confirm_pass" placeholder = "Confirm new password" class = "box">
                    </div>
                </div>
                <div class = "flex-btn">
                    <input type = "submit" class = "btn" value = "Update Profile" name = "update_profile">
                    <a href = "home.php" class = "option-btn">Go Back</a>
                </div>
            </form>
        </section>
    </div>
    

    <!-- Custom js file -->
    <script src = "script.js"></script>
</body>
</html>