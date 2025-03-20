<?php
// Démarrer la session
session_start();

require_once __DIR__ . '/../core/config.php';

// Supprimer les variables de session
session_unset();
//  Détruire la session
session_destroy();
// Rediriger vers la page d'accueil
header("Location:" . BASE_URL);

exit();
?>