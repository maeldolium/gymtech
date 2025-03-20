<?php
// session_start();
require_once __DIR__ . '/../core/config.php';

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? $_SESSION['user']['role'] : ''; // Si non connecté, rôle vide
?>

<!-- NAVBAR -->
<nav class="navbar">
    <!-- LOGO -->
    <a href="<?= BASE_URL ?>index.php"><img src="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" alt="Logo de GymTech" class="logo"></a>
    
    <div class="nav-container">
        <ul class="nav-links">
            <?php if ($isLoggedIn): ?>   

                <?php if ($role === 'A'): ?>
                    <li><a href="pages/add_user.php">Ajouter un utilisateur</a></li>
                    <li><a href="<?= BASE_URL ?>pages/admin.php">Admin</a></li>
                    <li><a href="<?= BASE_URL ?>pages/maintenance.php">Maintenance</a></li>
                <?php elseif ($role === 'M'): ?>
                    <li><a href="<?= BASE_URL ?>pages/maintenance.php">Maintenance</a></li>
                <?php elseif ($role === 'S'): ?>
                    <li><a href="<?= BASE_URL ?>pages/reservation.php">Réservations</a></li>
                <li><a href="<?= BASE_URL ?>pages/historique.php">Historique des séances</a></li>
                    <li><a href="<?= BASE_URL ?>pages/contact.php">Contact</a></li>
                <?php endif; ?>

                <!-- <li><a href="<?= BASE_URL ?>pages/profile.php">Mon Profil</a></li> -->
                <a href="<?= BASE_URL ?>auth/logout.php"><button id="disconnect">Déconnexion</button></a>
            <?php else: ?>
                <li class="mobile-only"><a href="<?= BASE_URL ?>pages/login.php">Se connecter</a></li>
                <li class="mobile-only"><a href="<?= BASE_URL ?>pages/register.php">S'inscrire</a></li>
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
                <a href="<?= BASE_URL ?>auth/login.php"><button id="connect">Se connecter</button></a>
                <a href="<?= BASE_URL ?>auth/register.php"><button id="register">S'inscrire</button></a>
            </div>
        <?php endif; ?>
    </div>
</nav>
