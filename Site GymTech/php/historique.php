<?php
include("connexion_db.php");

$pdo = new PDO("mysql:host=localhost;dbname=gymtech", "root", "");
$requete = $pdo->prepare("SELECT date_seance, id_equipement, energie_produite FROM seances WHERE id_user = 1 ORDER BY date_seance DESC");
$requete->execute();
$seances = $requete->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des séances</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .timeline { position: relative; max-width: 600px; margin: auto; }
        .timeline::after { content: ''; position: absolute; width: 6px; background: #ddd; top: 0; bottom: 0; left: 50%; margin-left: -3px; }
        .container { padding: 10px 40px; position: relative; background: white; width: 50%; }
        .left { left: 0; }
        .right { left: 50%; }
        .content { padding: 10px; background: #f1f1f1; border-radius: 5px; }
    </style>
</head>


<body>
    <!-- HEADER -->
    <header>
           <!-- NAVBAR -->
           <nav class="navbar">
               <!-- LOGO -->
               <a href="../pages/index.html"><img src="../assets/images/logo/gymtech_logo.png" alt="Logo de GymTech" class="logo"></a>
               <div class="nav-container">
                   <ul class="nav-links">
                       <li><a href="../pages/reservation.html">Réservations</a></li>
                       <li><a href="../pages/historique.html">Historique des séances</a></li>
                       <!-- <li><a href="./actus.html">Actualités</a></li> -->
                       <li><a href="../pages/contact.html">Contact</a></li>
                       <li class="mobile-only"><a href="#">Se connecter</a></li>
                       <li class="mobile-only"><a href="#">S'inscrire</a></li>
                   </ul>
                   <div class="burger">
                       <div class="bar"></div>
                       <div class="bar"></div>
                       <div class="bar"></div>
                   </div>
                   <!-- BOUTON CONNEXION/INSCRIPTION -->
                   <div class="button-connect">
                       <button id="connect">Se connecter</button>
                       <button id="register">S'inscrire</button>
                   </div>
               </div>
           </nav>
       </header>
    <main>

        <h2>⏳ Historique des séances</h2>
        <div class="timeline">
            <?php foreach ($seances as $index => $seance): ?>
                <div class="container <?= $index % 2 == 0 ? 'left' : 'right' ?>">
                    <div class="content">
                        <h3><?= htmlspecialchars($seance["date_seance"]) ?></h3>
                        <p>🏋️‍♂️ Équipement : <?= htmlspecialchars($seance["id_equipement"]) ?></p>
                        <p>⚡ Énergie : <?= htmlspecialchars($seance["energie_produite"]) ?> kWh</p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </body>
</html>