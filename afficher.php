<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UA WEBINAIRE DEMO</title>
    <style>
        table {
            border-collapse: collapse;
            /* Ensures borders are merged */
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            /* Adds border to table, header, and cells */
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }


        button {
            width: 240px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>

</head>

<body>
    <?php
    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO('mysql:host=localhost;dbname=uadb_demo_1;charset=utf8mb4', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour récupérer les utilisateurs
        $sql = "SELECT id, nom, prenoms, email FROM utilisateurs";
        $stmt = $pdo->query($sql);

        echo "<table>";
        echo "<thead><td>ID</td><td>Nom de famille</td><td>Prénoms</td><td>Email (Punycode)</td><td>Email (UTF8)</td></thead>";
        echo "<tbody>";
        // Afficher les résultats
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $email = $row['email'];
            $domain = explode('@', $email)[1]; // Extraire le domaine
            $username = explode('@', $email)[0];
            $decodedDomain = idn_to_utf8($domain); // Décoder le domaine en Punycode

            $decodedEmail = "$username@$decodedDomain"; // Reconstituer l'adresse email
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["nom"] . "</td>";
            echo "<td>" . $row["prenoms"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $decodedEmail . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } catch (PDOException $e) {
        echo "Erreur : Impossible d'afficher la liste des utilisateurs";
    }
    ?>
    <br>
    <a href="./">
        <button>Ajouter un utilisateur</button>
    </a>

</body>

</html>