<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to FoodStore</title>
    <link rel="stylesheet" href="intro-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="bg-container"></div>

    <div class="intro-overlay">
        <div class="intro-container">
            <div class="intro-logo">
                <img src="image/logo-new.png" alt="FoodStore Logo">
            </div>
            <h1 class="intro-title">Welcome to FoodStore</h1>
            <p class="intro-subtitle">Delicious selections just a click away.</p>

            <div class="intro-buttons">
                <a href="home.php" class="intro-button">
                    <i class="fa fa-arrow-right"></i> Start Shopping
                </a>
                <button id="aboutBtn" class="intro-button alt">
                    <i class="fa fa-info-circle"></i> About
                </button>
            </div>

            <div id="aboutSection" class="about-section">
                <h2>About FoodStore</h2>
                <p>
                    FoodStore is your one-stop shop for the freshest and tastiest food products online.
                    We bring quality, speed, and satisfaction straight to your screen.
                </p>
                <button id="closeAbout" class="button">Close</button>
            </div>
        </div>
    </div>
<script src="script.js"></script>
</body>

</html>
