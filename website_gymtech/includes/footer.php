<?php

require_once __DIR__ . '/../core/config.php';

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? $_SESSION['user']['role'] : ''; // Si non connecté, rôle vide
?>

<!-- FOOTER -->
 <footer>
    <ul class="footer-nav">
    <?php if ($isLoggedIn): ?>   

        <?php if ($role === 'A'): ?>
            <li><a href="<?= BASE_URL ?>admin/gestion_user.php">Gestion des utilisateurs</a></li>
                    <li><a href="<?= BASE_URL ?>admin/admin.php">Admin</a></li>
                    <li><a href="<?= BASE_URL ?>maintenance/maintenance.php">Maintenance</a></li>
        <?php elseif ($role === 'M'): ?>
            <li><a href="<?= BASE_URL ?>pages/maintenance.php">Maintenance</a></li>
        <?php elseif ($role === 'S'): ?>
            <li><a href="<?= BASE_URL ?>pages/reservation.php">Réservations</a></li>
        <li><a href="<?= BASE_URL ?>pages/historique.php">Historique des séances</a></li>
            <li><a href="<?= BASE_URL ?>pages/contact.php">Contact</a></li>
        <?php endif; ?>
    <?php endif; ?>
    </ul>
    
    <div class="links">
        <a href="#"><img src="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" alt="Logo de GymTech"></a>
        <ul class="media">
            <li><a href="https://x.com/?lang=fr"><img src="../assets/images/logo/logo_x.png" alt=""></a></li>
            <li><a href="https://www.instagram.com/"><img src="../assets/images/logo/logo_instagram.png" alt=""></a></li>
            <li><a href="https://fr.linkedin.com/"><img src="../assets/images/logo/logo_linkedin.png" alt=""></a></li>
        </ul>
    </div>

    <div class="copyright">
        <p>&copy; 2025 GymTech - Tous droits réservés</p>
    </div>
</footer>