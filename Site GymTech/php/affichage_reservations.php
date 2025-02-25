<?php
include("connexion_db.php");

$sql = "SELECT date_resa, heure_debut, heure_fin FROM reserver ORDER BY date_resa, heure_debut, heure_fin";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des réservations</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .view-resa {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2em;
        }

        .view-resa h2 {
            text-align: center;
            color: #7ed957;
            margin-bottom: 1em;
        }

        .table-resa {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table-resa th, .table-resa td {
            padding: 1em;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table-resa th {
            background-color: #7ed957;
            color: #fff;
        }

        .table-resa tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table-resa tr:hover {
            background-color: #f1f1f1;
        }

        @media screen and (max-width: 768px) {
            .table-resa {
                width: 100%;
            }
            .table-resa th, .table-resa td {
                padding: 0.5em;
            }
        }

        @media screen and (max-width: 425px) {
            .table-resa th, .table-resa td {
                padding: 0.3em;
                font-size: 0.9em;
            }
        }
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
                    <li><a href="../php/historique.php">Historique des séances</a></li>
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

        <div class="view-resa">
            
            <h2>Créneaux réservés</h2>
            <table class="table-resa">
                <tr>
                    <th>Date</th>
                    <th>Heure début</th>
                    <th>Heure fin</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['date_resa']); ?></td>
                        <td><?= htmlspecialchars($row['heure_debut']); ?></td>
                        <td><?= htmlspecialchars($row['heure_fin']); ?></td>
                    </tr>
                    <?php endwhile; ?>
            </table>
        </div>
    </main>
    <!-- FOOTER -->
    <footer>
        <ul id="footer-nav">
            <li><a href="../pages/reservation.html">Réservations</a></li>
            <li><a href="../php/historique.php">Historique des séances</a></li>
            <!-- <li><a href="#">Actualités</a></li> -->
            <li><a href="../pages/contact.html">Contact</a></li>
        </ul>
        
        <div class="link">
            <a href="#"><img src="../assets/images/logo/gymtech_logo.png" alt="Logo de GymTech"></a>
            <ul class="media">
                <li><a href="https://x.com/?lang=fr"><img src="../assets/images/logo/logo_x.png" alt=""></a></li>
                <li><a href="https://www.instagram.com/"><img src="../assets/images/logo/logo_instagram.png" alt=""></a></li>
                <li><a href="https://fr.linkedin.com/"><img src="../assets/images/logo/logo_linkedin.png" alt=""></a></li>
            </ul>
        </div>
    </footer>
    
    <script src="../assets/js/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>

