<?php
include("connexion_db.php");

$date_resa = $_POST['date_resa'];
$heure_debut = $_POST['heure_debut'];
$heure_fin = $_POST['heure_fin'];

$sql_check = "SELECT * FROM reserver WHERE date_resa = '$date_resa' AND heure_debut = '$heure_debut' AND heure_fin = '$heure_fin'";
$result = $conn->query($sql_check);

if($result->num_rows > 0){
    echo "Ce créneau est déjà réservé. Choissisez un autre créneau.";
}else{
    $sql = "INSERT INTO reserver (date_resa, heure_debut, heure_fin) VALUES ('$date_resa', '$heure_debut', '$heure_fin')";
    if($conn->query($sql) === TRUE){
        echo "Réservation effectuée avec succès.";
    }else{
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>