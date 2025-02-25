<?php
include("./connexion_db.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $sujet = htmlspecialchars($_POST['sujet']);
    $message = htmlspecialchars($_POST['message']);

    if($email === false) {
        die("Adresse email invalide");
    }

    $to = "maeldolium@gmail.com";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content Type: text/plain; charset=UTF-8\r\n";

    $message_body = "Nom: $nom\n";
    $message_body .= "Email: $email\n";
    $message_body .= "Message: \n$message\n";

    if(mail($to, $sujet, $message_body, $headers)) {
        echo "Votre message a bien été envoyé.";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
} else {
    echo "Accès non autorisé.";
}