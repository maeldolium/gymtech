<?php
session_start();
require_once __DIR__ . '/../core/config.php';
include "../core/database.php";

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);
$role = $isLoggedIn ? $_SESSION['user']['role'] : ''; // Si non connecté, rôle vide

// Vérifier si l'utilisateur a le rôle 'M' (Maintenance) ou 'A' (Admin)
if (!isset($_SESSION['user']) || ($role !== 'M' && $role !== 'A')) {
    // Redirection vers la page d'accueil si l'utilisateur n'est pas autorisé
    header("Location: " . BASE_URL . "index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" width="device-width, initial-scale=1.0">
    <title>Panneau de maintenance - GymTech</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" type="image/png">
</head>
<body>
    <header>
        <?php include __DIR__ . '/../includes/navbar.php'; ?>
    </header>

    <main class="maintenance-dashboard">
        <h2>Panneau de maintenance</h2>

        <div class="dashboard-grid">
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
                <h2>Capteurs</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nom du capteur</th>
                            <th>Mesure 1</th>
                            <th>Mesure 2</th>
                            <th>Salle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("
                            SELECT 
                                c.LIBELLE_CAPTEUR,
                                c.MESURE_1,
                                c.MESURE_2,
                                s.NOM_SALLE
                            FROM CAPTEURS c
                            LEFT JOIN SALLES s ON c.ID_CAPTEUR = s.ID_CAPTEUR
                        ");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['LIBELLE_CAPTEUR']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['MESURE_1']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['MESURE_2']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['NOM_SALLE'] ?? '-') . "</td>";
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