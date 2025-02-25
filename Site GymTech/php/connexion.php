<?php
include("connexion_db.php");

if(isset($_POST['submit'])){
    $identifiant_user = $_POST['identifiant_user'];
    $pswd = $_POST['pswd'];

    // Préparer la requête SQL pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT * FROM users WHERE identifiant_user = ? AND pswd = ?");
    $stmt->bind_param("ss", $identifiant_user, $pswd);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if($row){
        session_start();
        $_SESSION['identifiant_user'] = $row['identifiant_user'];
        $_SESSION['pswd'] = $row['pswd'];
        header("Location: ../pages/index.html");
        exit();
    }else{
        echo "Identifiant ou mot de passe incorrect";
    }
}
?>