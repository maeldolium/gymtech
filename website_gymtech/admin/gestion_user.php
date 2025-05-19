<?php
session_start();
require_once __DIR__ . '/../core/config.php';
include "../core/database.php";

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? $_SESSION['user']['role'] : ''; // Si non connecté, rôle vide

// Vérifier si l'utilisateur est un administrateur
if ($role !== 'A') {
    // Redirection vers la page d'accueil si l'utilisateur n'est pas un administrateur
    header("Location: " . BASE_URL . "index.php");
    exit();
}

// Récupérer la liste des utilisateurs
$stmt = $pdo->query("SELECT ID_USER, NOM_USER, PRENOM_USER, USER_NAME, ID_TYPE_USER FROM USERS");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si la requête a réussi
$successMessage = $_SESSION['success_message'] ?? null;
// Supprimer le message de succès après l'avoir affiché
unset($_SESSION['success_message']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs - GymTech</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" type="image/png">
</head>
<body>

<header>
    <?php include __DIR__ . '/../includes/navbar.php'; ?>
</header>

<main>
    <div class="gestion_user">

        <h2>Panneau de gestion des utilisateurs</h2>
        
        <!-- Affichage du message de succès -->
        <?php if ($successMessage): ?>
            <div id="success-message">
        <?= htmlspecialchars($successMessage) ?>
    </div>
<?php endif; ?>

<table class="table_users">
    <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Nom d'utilisateur</th>
                <th>Rôle</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= htmlspecialchars($user['NOM_USER']) ?></td>
                <td><?= htmlspecialchars($user['PRENOM_USER']) ?></td>
                <td><?= htmlspecialchars($user['USER_NAME']) ?></td>
                <td>
                    <form action="update_role.php" method="POST">
                        <input type="hidden" name="user_id" value="<?= $user['ID_USER'] ?>">
                        <select name="new_role">
                            <option value="S" <?= $user['ID_TYPE_USER'] === 'S' ? 'selected' : '' ?>>Abonné</option>
                            <option value="A" <?= $user['ID_TYPE_USER'] === 'A' ? 'selected' : '' ?>>Administrateur</option>
                            <option value="M" <?= $user['ID_TYPE_USER'] === 'M' ? 'selected' : '' ?>>Maintenance</option>
                        </select>
                        <button type="submit">Modifier</button>
                    </form>
                </td>
                <td>
                    <form action="delete_user.php" method="POST">
                        <input type="hidden" name="user_id" value="<?= $user['ID_USER'] ?>">
                        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')" class="delete-btn">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</main>
   

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>