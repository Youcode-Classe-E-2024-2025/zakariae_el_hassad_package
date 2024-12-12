
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Sidebar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/home.css">
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>

    <div class="sidebar">
        <div id="image" class="navbar-brand d-flex align-items-center">
            <img src="./img/Leonardo_Phoenix_A_stylized_modern_and_sleek_logo_for_ZH_a_bol_0.jpg" alt="Logo" class="me-2" style="width: 50px; height: auto;">
        </div>
        <a href="/brief1_php/home.php">home</a>
        <a href="/brief1_php/package/package.php">packages</a>
        <a href="/brief1_php/auteur/auteur.php">auteurs</a>
        <a href="/brief1_php/version/version.php">version</a>
    </div>

    <div class="content">
        <form action="" method="GET" class="d-flex">
            <div class="input-group me-2">
                <input type="text" name="search" required value="<?php if (isset($_GET['search'])) { echo htmlspecialchars($_GET['search']); } ?>" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-primary me-2">Search</button>
            <a href="?reset=1" class="btn btn-secondary">Reset</a>
        </form>
        <div class="container my-5">
            <h1 id="titre">Welcome to Packages</h1>
            <p id="list">---------- List of Packages ----------</p>
            <br>
            <div id="main">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "my_brief1";

                $connection = new mysqli($servername, $username, $password, $database);

                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                // إذا كاين إعادة تعيين أو البحث فارغ
                if (isset($_GET['reset']) || empty($_GET['search'])) {
                    $sql = "
                        SELECT 
                            package.nom AS nomp, 
                            package.description, 
                            package.categorie, 
                            auteur.nom, 
                            version.numero_version 
                        FROM 
                            auteur_package
                        INNER JOIN 
                            package ON auteur_package.package_id = package.id 
                        INNER JOIN 
                            auteur ON auteur_package.auteur_id = auteur.id
                        INNER JOIN 
                            version ON version.package_id = package.id
                    ";
                } else {
                    // إذا كاين بحث
                    $filtervalues = $connection->real_escape_string($_GET['search']);
                    $sql = "
                        SELECT 
                            package.nom AS nomp, 
                            package.description, 
                            package.categorie, 
                            auteur.nom, 
                            version.numero_version 
                        FROM 
                            auteur_package
                        INNER JOIN 
                            package ON auteur_package.package_id = package.id 
                        INNER JOIN 
                            auteur ON auteur_package.auteur_id = auteur.id
                        INNER JOIN 
                            version ON version.package_id = package.id
                        WHERE 
                            package.nom LIKE '%$filtervalues%' 
                            OR auteur.nom LIKE '%$filtervalues%' 
                            OR package.categorie LIKE '%$filtervalues%'
                    ";
                }

                $result = $connection->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <div id='carte'>
                            <h1>" . htmlspecialchars($row['nomp']) . "</h1>
                            <h2>Auteur:</h2>
                            <p>" . htmlspecialchars($row['nom']) . "</p>
                            <h2>Version:</h2>
                            <p>" . htmlspecialchars($row['numero_version']) . "</p>
                            <h2>Description:</h2>
                            <p>" . htmlspecialchars($row['description']) . "</p>
                            <h2>Catégorie:</h2>
                            <p>" . htmlspecialchars($row['categorie']) . "</p>
                        </div>
                        ";
                    }
                } else {
                    echo "<p>No results found.</p>";
                }
                ?>
            </div>
        </div>
    </div>

</body>
</html>
