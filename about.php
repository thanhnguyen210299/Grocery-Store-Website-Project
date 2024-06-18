<?php
    @include 'config.php';

    session_start();

    $user_id = $_SESSION['user_id'];

    if (!isset($user_id)){
        header('location:login.php');
    }

    // Set the current page variable
    $currentPage = 'about';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>

    <!-- Font Awesome cdn link -->
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom css file link -->
    <link rel = "stylesheet" href = "css/style.css">
</head>
<body>

    <?php include 'header.php';?>

    <section class = "about">
        <div class = "row">
            <div class = "box">
                <img src = "images/about_why.jpg" alt = "">
                <h3>Why Choose Us?</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati exercitationem facere sed eligendi est vero dolorem rem, et minima, fugit rerum quibusdam hic, nihil magnam asperiores quis nostrum aut harum.</p>
                <a href = "contact.php" class = "btn">Contact Us</a>
            </div>

            <div class = "box">
                <img src = "images/about_shop.jpg" alt = "">
                <h3>What We Provide?</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati exercitationem facere sed eligendi est vero dolorem rem, et minima, fugit rerum quibusdam hic, nihil magnam asperiores quis nostrum aut harum.</p>
                <a href = "shop.php" class = "btn">Shop Now</a>
            </div>
        </div>
    </section>

    <section class = "reviews">
        <h1 class = "title">Clients Reviews</h1>
        <div class = "box-container">
            <div class = "box">
                <img src = "images/Jenny_Photographer.jpg" alt = "">
                <h3>Jenny Dion</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis quasi repudiandae, cupiditate commodi incidunt ducimus quidem illum porro labore iure!</p>
                <div class = "stars">
                <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star-half-alt"></i>
                </div>
            </div>

            <div class = "box">
                <img src = "images/jessica_alba_investor.jpg" alt = "">
                <h3>Jessica Alba</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis quasi repudiandae, cupiditate commodi incidunt ducimus quidem illum porro labore iure!</p>
                <div class = "stars">
                <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                </div>
            </div>

            <div class = "box">
                <img src = "images/david_blaine_artist.jpg" alt = "">
                <h3>David Blaine</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis quasi repudiandae, cupiditate commodi incidunt ducimus quidem illum porro labore iure!</p>
                <div class = "stars">
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                </div>
            </div>

            <div class = "box">
                <img src = "images/misty_copeland_dancer.jpg" alt = "">
                <h3>Misty Copeland</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis quasi repudiandae, cupiditate commodi incidunt ducimus quidem illum porro labore iure!</p>
                <div class = "stars">
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                </div>
            </div>

            <div class = "box">
                <img src = "images/Michael-Phelps_champion swimmer.jpg" alt = "">
                <h3>Michael Phelps</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis quasi repudiandae, cupiditate commodi incidunt ducimus quidem illum porro labore iure!</p>
                <div class = "stars">
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                </div>
            </div>

            <div class = "box">
                <img src = "images/Simone_biles_gymnast.jpg" alt = "">
                <h3>Simone Biles</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis quasi repudiandae, cupiditate commodi incidunt ducimus quidem illum porro labore iure!</p>
                <div class = "stars">
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star"></i>
                    <i class = "fas fa-star-half-alt"></i>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php';?>

    <!-- Custom js file -->
    <script src = "script.js"></script>
</body>
</html>