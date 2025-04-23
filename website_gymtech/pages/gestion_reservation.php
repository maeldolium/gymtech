<?php
session_start();
require_once __DIR__ . '/../core/config.php';
include "../core/database.php";

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);
$id_user = $isLoggedIn ? $_SESSION['user']['id'] : ''; // Si non connecté, ID vide

if(!$isLoggedIn) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: ' . BASE_URL . 'index.php');
    exit;
}

$stmtReservation = $pdo->prepare("
    SELECT 
        r.ID_RESERVATION,
        r.DATE,
        r.HEURE_DEBUT,
        r.HEURE_FIN,
        c.TYPE_COURS AS NOM_COURS,
        e.NOM_EQUIPEMENT AS NOM_EQUIPEMENT
    FROM RESERVATION r
    LEFT JOIN COURS c ON r.ID_COURS = c.ID_COURS
    LEFT JOIN EQUIPEMENTS e ON r.ID_EQUIPEMENT = e.ID_EQUIPEMENT
    WHERE r.ID_USER = ?
");
$stmtReservation->execute([$id_user]);
$reservations = $stmtReservation->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des réservation - GymTech</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" type="image/png">
</head>
<body>
    <header>
        <?php include '../includes/navbar.php'; ?>
    </header>

    <main>
        <div class="gestion-reservation">
            <h2>Gestion des réservations</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID Réservation</th>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Heure de début</th>
                        <th>Heure de fin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?= htmlspecialchars($reservation['ID_RESERVATION']) ?></td>
                            <td>
                                <?= htmlspecialchars($reservation['NOM_COURS'] ?? $reservation['NOM_EQUIPEMENT']) ?>
                            </td>
                            <td><?= htmlspecialchars($reservation['DATE']) ?></td>
                            <td><?= htmlspecialchars($reservation['HEURE_DEBUT']) ?></td>
                            <td><?= htmlspecialchars($reservation['HEURE_FIN']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
        <script>
            function toggleOptions() {
                const coursOptions = document.getElementById('coursOptions');
                const equipementOptions = document.getElementById('equipementOptions');
                const typeCours = document.getElementById('cours').checked;
                const typeEquipement = document.getElementById('equipement').checked;

                if (typeCours) {
                    coursOptions.style.display = 'block';
                    equipementOptions.style.display = 'none';
                } else if (typeEquipement) {
                    equipementOptions.style.display = 'block';
                    coursOptions.style.display = 'none';
                }
            }
    </main>
    
</body>
</html>