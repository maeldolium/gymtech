<?php
include("connexion_db.php");

if(isset($_POST['submit'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $identifiant_user = $_POST['identifiant_user'];
    $pswd = $_POST['pswd'];

    // Préparer la requête SQL pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO users (nom_user, prenom_user, identifiant_user, pswd) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $prenom, $identifiant_user, $pswd);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        header("Location: ../pages/connexion.html");
        exit();
    }else{
        echo "Erreur lors de l'inscription. Veuillez réessayer.";
    }
}
?>