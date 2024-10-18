<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UA WEBINAIRE DEMO</title>
    <style>
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
    if (count($_POST) < 3) {
        echo "Veuillez vérifier vos informations !";
        echo "
        <br>
        <br>
        <a href='./'>
            <button>Ajouter un utilisateur</button>
        </a>
        ";
        exit();
    }

    try {
        // Connexion à la base de données avec PDO
        $pdo = new PDO('mysql:host=localhost;dbname=uadb_demo_1;charset=utf8mb4', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupérer les données du formulaire
        $nom = $_POST['nom'];
        $prenoms = $_POST['prenoms'];
        $email = $_POST['email'];

        // Préparer et exécuter la requête d'insertion
        $sql = "INSERT INTO utilisateurs (nom, prenoms, email) VALUES (:nom, :prenoms, :email)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['nom' => $nom, 'prenoms' => $prenoms, 'email' => $email]);

        echo "Nouvel enregistrement créé avec succès";
    } catch (PDOException $e) {
        echo "Erreur : L'adresse Email saisie existe déjà.";
    }
    ?>

    <a href="afficher.php">
        <button>Afficher les tilisateurs</button>
    </a>
</body>

</html>