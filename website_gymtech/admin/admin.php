<?php
session_start();
require_once __DIR__ . '/../core/config.php';
include "../core/database.php";

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? $_SESSION['user']['role'] : ''; // Si non connecté, rôle vide

if (!$isLoggedIn || $role !== 'A') {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté ou n'est pas admin
    header('Location: ' . BASE_URL . 'index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau administrateur - GymTech</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" type="image/png">
</head>
<body>
    <header>
        <?php include __DIR__ . '/../includes/navbar.php'; ?>
    </header>

    <main class="admin-dashboard">
        <h2>Panneau administrateur</h2>
        

            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h2>Utilisateurs</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Identifiant</th>
                                <th>Rôle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        // Récupérer les utilisateurs depuis la base de données
                        $stmt = $pdo->query("SELECT NOM_USER, PRENOM_USER, USER_NAME, ID_TYPE_USER FROM users");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['NOM_USER']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['PRENOM_USER']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['USER_NAME']) . "</td>";
                            if ($row['ID_TYPE_USER'] == 'A') {
                                echo "<td>Administrateur</td>";
                            } elseif ($row['ID_TYPE_USER'] == 'M') {
                                echo "<td>Maintenance</td>";
                            } elseif ($row['ID_TYPE_USER'] == 'S') {
                                echo "<td>Abonné</td>";
                            } else {
                                echo "<td>Inconnu</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="dashboard-card">
                <h2>Equipements</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Récupérer les équipements depuis la base de données
                        $stmt = $pdo->query("SELECT NOM_EQUIPEMENT, TYPE_EQUIPEMENT FROM equipements");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['NOM_EQUIPEMENT']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['TYPE_EQUIPEMENT']) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <div class="dashboard-card">
                <h2>Cours</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Récupérer les cours depuis la base de données
                        $stmt = $pdo->query("SELECT TYPE_COURS, NOMBRE_PLACES FROM cours");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['TYPE_COURS']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['NOMBRE_PLACES']) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        
        </div>



    </main>

    
        <?php include __DIR__ . '/../includes/footer.php'; ?>
    
    
</body>
</html>