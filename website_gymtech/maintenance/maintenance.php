<?php
session_start();
require_once __DIR__ . '/../core/config.php';
include "../core/database.php";

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? $_SESSION['user']['role'] : ''; // Si non connecté, rôle vide

// Vérifier si l'utilisateur a le rôle 'M' (Maintenance) ou 'A' (Admin)
if (!isset($_SESSION['user']) || $role !== 'M' && $role !== 'A') {
    // Redirection vers la page d'accueil si l'utilisateur n'est pas autorisé
    header("Location: " . BASE_URL . "index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau de maintenance - GymTech</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" type="image/png">
</head>
<body>
    <header>
        <?php include __DIR__ . '/../includes/navbar.php'; ?>
    </header>

    <main>
        <h2>Panneau de maintenance</h2>
    </main>

    <footer>
        <?php include __DIR__ . '/../includes/footer.php'; ?>
    </footer>
    
</body>
</html>