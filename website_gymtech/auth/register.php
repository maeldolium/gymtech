<?php
require_once __DIR__ . '/../core/config.php'; // Inclusion du fichier de configuration du lien de base
include "../core/database.php"; // Inclusion du fichier de connexion à la base de données
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données du formulaire
    $nom = trim($_POST["nom"]);
    $prenom = trim($_POST["prenom"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $genre = $_POST["genre"];
    
    // Vérification que tous les champs sont remplis
    if (empty($nom) || empty($prenom) || empty($password) || empty($confirmPassword) || empty($genre)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($password !== $confirmPassword) {
        // Vérification que les mots de passe correspondent
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Définition des règles de validation des mots de passe (ANSSI)
        $minLength = 12; // Longueur minimale
        $requiresSpecialChar = (strlen($password) < 14); // Si < 14 caractères, un caractère spécial est requis
        $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)" . ($requiresSpecialChar ? "(?=.*[\W])" : "") . ".{" . $minLength . ",}$/";

        if (!preg_match($regex, $password)) {
            // Message d'erreur spécifique selon la contrainte non respectée
            $error = "Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule et un chiffre." . 
                     ($requiresSpecialChar ? " Un caractère spécial est requis si le mot de passe fait moins de 14 caractères." : "");
        } else {
            try {
                
                // Génération automatique du nom d'utilisateur sous le format "j.doe"
                $usernameBase = strtolower(substr($prenom, 0, 1) . '.' . $nom);
                $username = $usernameBase;

                // Vérification si le nom d'utilisateur est déjà pris
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM USERS WHERE IDENTIFIANT_USER LIKE ?");
                $index = 1;
                while (true) {
                    $stmt->execute(["$username%"]);
                    $count = $stmt->fetchColumn();
                    if ($count == 0) break; // Sortir de la boucle si le nom d'utilisateur est unique
                    $username = $usernameBase . $index; // Ajouter un numéro en cas de doublon
                    $index++;
                }

                // Hachage sécurisé du mot de passe avec bcrypt
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Insertion de l'utilisateur dans la base de données
                $stmt = $pdo->prepare("INSERT INTO USERS (ID_TYPE_USER, NOM_USER, PRENOM_USER, IDENTIFIANT_USER, MOT_DE_PASSE_USER, GENRE_USER, CREATED_AT) 
                                        VALUES (?, ?, ?, ?, ?, ?, NOW())");

                $stmt->execute([ 'S', $nom, $prenom, $username, $hashedPassword, $genre]);

                // Redirection vers la page de connexion après inscription réussie
                header("Location: login.php");
                exit();
            } catch (PDOException $e) {
                // Gestion des erreurs liées à la base de données
                $error = "Erreur : " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - GymTech</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" type="image/png">
    <script>
        // Fonction pour générer automatiquement le nom d'utilisateur au format "j.doe"
        function generateUsername() {
            let prenom = document.getElementById("prenom").value.trim().toLowerCase();
            let nom = document.getElementById("nom").value.trim().toLowerCase();
            if (prenom && nom) {
                let username = prenom.charAt(0) + "." + nom;
                document.getElementById("username").value = username;
            }
        }

        // Vérification de la complexité du mot de passe et affichage d'un message d'aide
        function checkPasswordStrength() {
            let password = document.getElementById("password").value;
            let strengthMessage = document.getElementById("password-strength");

            let minLength = 12;
            let hasLower = /[a-z]/.test(password); // Vérifie la présence d'une minuscule
            let hasUpper = /[A-Z]/.test(password); // Vérifie la présence d'une majuscule
            let hasDigit = /\d/.test(password); // Vérifie la présence d'un chiffre
            let hasSpecial = /[\W]/.test(password); // Vérifie la présence d'un caractère spécial
            let requiresSpecial = password.length < 14;

            if (password.length < minLength) {
                strengthMessage.innerHTML = "Le mot de passe doit contenir au moins 12 caractères.";
                strengthMessage.style.color = "red";
            } else if (!hasLower || !hasUpper || !hasDigit) {
                strengthMessage.innerHTML = "Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.";
                strengthMessage.style.color = "red";
            } else if (requiresSpecial && !hasSpecial) {
                strengthMessage.innerHTML = "Un caractère spécial est requis si le mot de passe fait moins de 14 caractères.";
                strengthMessage.style.color = "red";
            } else {
                strengthMessage.innerHTML = "Mot de passe sécurisé.";
                strengthMessage.style.color = "green";
            }
        }
    </script>
</head>
<body class="register">
    <div class="container-login">
        <h2>Créer un compte</h2>

        <!-- Affichage du message d'erreur en cas de problème -->
        <?php if (isset($error)) : ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="form-login">
            <label>Nom :</label>
            <input type="text" id="nom" name="nom" required oninput="generateUsername()">

            <label>Prénom :</label>
            <input type="text" id="prenom" name="prenom" required oninput="generateUsername()">

            <label>Nom d'utilisateur (automatique) :</label>
            <input type="text" id="username" name="username" readonly> <!-- Généré automatiquement -->

            <label>Mot de passe :</label>
            <input type="password" id="password" name="password" required oninput="checkPasswordStrength()">
            <p id="password-strength" style="color: red;"></p>

            <label>Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" required>

            <label>Genre :</label>
            <select name="genre">
                <option value="M">Homme</option>
                <option value="F">Femme</option>
            </select>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>
