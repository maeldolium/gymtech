<?php
require_once __DIR__ . '/../core/config.php';
// session_start();

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);
$role = $_SESSION['role'] ?? 'guest'; // Par défaut, "guest" (non connecté)
?>

<!-- NAVBAR -->
<nav class="navbar">
    <!-- LOGO -->
    <a href="./index.html"><img src="assets/images/logo/gymtech_logo.png" alt="Logo de GymTech" class="logo"></a>
    <div class="nav-container">
        <ul class="nav-links">
            <li><a href="pages/reservation.php">Réservations</a></li>
            <li><a href="pages/historique.php">Historique des séances</a></li>
            <li><a href="pages/contact.php">Contact</a></li>

            <?php if ($isLoggedIn): ?>
                <?php if ($role === 'admin'): ?>
                    <li><a href="pages/admin.php">Admin</a></li>
                <?php endif; ?>
                <li><a href="pages/profile.php">Mon Profil</a></li>
                <li><a href="pages/logout.php">Se déconnecter</a></li>
            <?php else: ?>
                <li class="mobile-only"><a href="pages/login.php">Se connecter</a></li>
                <li class="mobile-only"><a href="pages/register.php">S'inscrire</a></li>
            <?php endif; ?>
        </ul>

        <div class="burger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>

        <!-- BOUTON CONNEXION/INSCRIPTION -->
        <?php if (!$isLoggedIn): ?>
            <div class="button-connect">
                <a href="<?= BASE_URL ?>pages/login.php"><button id="connect">Se connecter</button></a>
                <a href="<?= BASE_URL ?>pages/register.php"><button id="register">S'inscrire</button></a>
            </div>
        <?php endif; ?>
    </div>
</nav>
