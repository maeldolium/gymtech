<?php
require_once __DIR__ . '/../core/config.php';
include "../core/database.php";
session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php');
    exit;
}

$id_user = $_POST['id_user'];
$type = $_POST['type'];
$date = $_POST['date'];
$heure_debut = $_POST['heure_debut'];
$heure_fin = $_POST['heure_fin'];

$id_cours = $type === 'cours' ? $_POST['cours_id'] : null;
$id_equipement = $type === 'equipement' ? $_POST['equipement_id'] : null;

// Validation simple
if (($id_cours && $id_equipement) || (!$id_cours && !$id_equipement)) {
    die("Vous devez sélectionner un seul type de réservation.");
}

// Récupération de l'ID de réservation (auto-incrément si tu veux, sinon calcule-le toi-même)
$stmtMaxId = $pdo->query("SELECT MAX(ID_RESERVATION) FROM RESERVATION");
$id_reservation = $stmtMaxId->fetchColumn() + 1;

// Insertion
$stmt = $pdo->prepare("INSERT INTO RESERVATION (ID_RESERVATION, ID_COURS, ID_EQUIPEMENT, ID_USER, DATE, HEURE_DEBUT, HEURE_FIN)
                       VALUES (?, ?, ?, ?, ?, ?, ?)");

$stmt->execute([
    $id_reservation,
    $id_cours,
    $id_equipement,
    $id_user,
    $date,
    $heure_debut,
    $heure_fin
]);

header('Location: reservation.php?success=1');
exit;
?>
