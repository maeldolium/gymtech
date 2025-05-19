<?php
session_start();
require_once __DIR__ . '/../core/config.php';
include "../core/database.php";

if (!isset($pdo)) {
    die("La base de données n'est pas disponible.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        // Préparer la requête pour récupérer l'utilisateur
        $stmt = $pdo->prepare("SELECT * FROM users WHERE IDENTIFIANT_USER = :username");
        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['MOT_DE_PASSE_USER'])) {
            // Stocker les informations utilisateur en session
            $_SESSION['user'] = [
                'id' => $user['ID_USER'],  // ID de l'utilisateur
                'name' => $user['NOM_USER'],  // Nom de l'utilisateur
                'username' => $user['IDENTIFIANT_USER'],  // Nom d'utilisateur
                'role' => $user['ID_TYPE_USER'],  // Rôle de l'utilisateur
            ];

            // Redirection après connexion réussie
            header("Location:" . BASE_URL . "index.php");
            exit();
        } else {
            echo "Identifiants incorrects.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" type="image/png">
</head>
<body class="login">
    <div class="container-login">
        <h1>Connexion</h1>
        <form action="login.php" method="post" class="form-login">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
