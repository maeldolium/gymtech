<?php
    session_start();
    require_once __DIR__ . '/core/config.php';
    include "core/database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GymTech</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" type="image/png">
</head>
<body>

    <header>
        <?php include 'includes/navbar.php'; ?>
    </header>

    <main>
        <!-- PRESENTATION -->
         <!-- A TERME SERA UN CAROUSEL -->
         <div class="presentation">
            <h1>GymTech</h1>
            <h2>Salle de sport connectée</h2>
            <button id="button-more">En savoir +</button>
        </div>

        <!-- ABOUT -->
         <!-- IMAGE COTE GAUCHE, TEXTE COTE DROIT -->
        <div class="about" id="about">
            <div class="img-part">
                <img src="<?= BASE_URL ?>assets/images/GymTech_bike_img.png" alt="Image de la salle de sport connectée">
            </div>
            <div class="text-part">
                <h2>A propos</h2>
                <p>Lorem ipsum dolor sit, beatae quis odio obcaecati maxime quisquam. Incidunt, atque! Distinctio aspernatur consequuntur accusamus quidem adipisci consequatur. Eius et eveniet delectus quam omnis neque consequuntur perferendis? Consectetur vel, blanditiis minus fugit impedit cum earum amet dolorem, deserunt reiciendis distinctio laudantium laborum officia, est magnam! Sint ipsa quam fuga inventore aliquam ipsam maxime voluptas! A quam blanditiis consequatur inventore nulla distinctio eaque esse.</p>
            </div>
        </div>
    </main>

    
    <?php include 'includes/footer.php'; ?>
    
    
</body>
</html>