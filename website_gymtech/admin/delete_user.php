<?php
require_once __DIR__ . '/../core/config.php';
include "../core/database.php";
session_start();

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? $_SESSION['user']['role'] : ''; // Si non connecté, rôle vide

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'A') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];

    $stmt = $pdo->prepare("DELETE FROM users WHERE ID_USER = ?");
    $stmt->execute([$user_id]);

    header("Location: gestion_user.php");
    exit();
}
?>
