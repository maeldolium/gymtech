<?php
// session_start();
require_once __DIR__ . '/../core/config.php';

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? $_SESSION['user']['role'] : ''; // Si non connecté, rôle vide

if ($role == 'A') {
    header("Location:" . BASE_URL . "admin/add_user.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur - GymTech</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" type="image/png">
</head>
<body>

<header>
    <?php include BASE_URL .'includes/navbar.php'; ?>
</header>

<main>
    <form action="add_user.php" method="post" class="form-login">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" required>
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" required>
        <label for="identifiant">Identifiant</label>
        <input type="text" name="identifiant" id="identifiant" required>
        
    </form>
</main>
    
</body>
</html>