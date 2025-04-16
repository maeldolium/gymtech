<?php
session_start();
require_once __DIR__ . '/../core/config.php';
include "../core/database.php";

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? $_SESSION['user']['role'] : ''; // Si non connecté, rôle vide

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'A') {
    header("Location: admin/gestion_user.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    $stmt = $pdo->prepare("UPDATE USERS SET ID_TYPE_USER = ? WHERE ID_USER = ?");
    $stmt->execute([$new_role, $user_id]);

    // Définir un message de succès dans la session
    $_SESSION['success_message'] = "Le rôle de l'utilisateur a été mis à jour avec succès.";

    header("Location: gestion_user.php"); // Redirection vers le panneau admin
    exit();
}
?>
