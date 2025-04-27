<?php
session_start();
require_once __DIR__ . '/../core/config.php';
include "../core/database.php";

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user']);
$id_user = $isLoggedIn ? $_SESSION['user']['id'] : ''; // Si non connecté, ID vide

if (!$isLoggedIn) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: ' . BASE_URL . 'index.php');
    exit;
}

// Récupération des cours
$stmtCours = $pdo->query("SELECT ID_COURS, TYPE_COURS FROM COURS");
$cours = $stmtCours->fetchAll(PDO::FETCH_ASSOC);

// Récupération des équipements
$stmtEquip = $pdo->query("SELECT ID_EQUIPEMENT, NOM_EQUIPEMENT FROM EQUIPEMENTS");
$equipements = $stmtEquip->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - GymTech</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="shortcut icon" href="<?= BASE_URL ?>assets/images/logo/gymtech_logo.png" type="image/png">
</head>
<body>
    <header>
        <?php include '../includes/navbar.php'; ?>
    </header>

    <main>
        <div class="reservation">
            <h2>Réservation</h2>

            <form action="reservation_handler.php" method="POST">
            <input type="hidden" name="id_user" value="<?= $id_user ?>">

            <label for="type">Je souhaite réserver :</label><br>
            <input type="radio" name="type" value="cours" id="cours" required onclick="toggleOptions()"> <label for="cours">Un cours</label>
            <input type="radio" name="type" value="equipement" id="equipement" required onclick="toggleOptions()"> <label for="equipement">Un équipement</label>

            <div id="coursOptions" style="display:none;">
                <label for="cours_id">Cours :</label>
                <select name="cours_id">
                    <option value="">-- Sélectionner un cours --</option>
                    <?php foreach ($cours as $c) : ?>
                        <option value="<?= $c['ID_COURS'] ?>"><?= $c['TYPE_COURS'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="equipementOptions" style="display:none;">
                <label for="equipement_id">Équipement :</label>
                <select name="equipement_id">
                    <option value="">-- Sélectionner un équipement --</option>
                    <?php foreach ($equipements as $e) : ?>
                        <option value="<?= $e['ID_EQUIPEMENT'] ?>"><?= $e['NOM_EQUIPEMENT'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <label for="date">Date :</label>
            <input type="date" name="date" required>

            <label for="heure_debut">Heure de début :</label>
            <input type="time" name="heure_debut" required>

            <label for="heure_fin">Heure de fin :</label>
            <input type="time" name="heure_fin" required>

            <button type="submit">Réserver</button>
        </form>

        <script>
        function toggleOptions() {
            const cours = document.getElementById('cours').checked;
            const equipement = document.getElementById('equipement').checked;
            document.getElementById('coursOptions').style.display = cours ? 'block' : 'none';
            document.getElementById('equipementOptions').style.display = equipement ? 'block' : 'none';
        }
        </script>
            
        </div>
    </main>

    <footer>
        <?php include '../includes/footer.php'; ?>
    </footer>
    
</body>
</html>