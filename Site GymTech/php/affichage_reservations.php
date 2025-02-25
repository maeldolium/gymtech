<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sport_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM reservations ORDER BY date_resa, heure_debut, heure_fin";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des réservations</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Créneaux réservés</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Date</th>
            <th>Heure début</th>
            <th>Heure fin</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['nom']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><?= $row['date_resa']; ?></td>
            <td><?= $row['heure_debut']; ?></td>
            <td><?= $row['heure_fin']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>

