
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
        <div id="search">
            <input id="i_s" type="search">
        </div>
        <div class="container my-5">
        <h1 id="titre">welcome to packages</h1>
        <p id="list">----------list of package----------</p>
        <br>
            <div id="main">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "my_brief1";

                $connection = new mysqli($servername,$username,$password,$database);

                if($connection ->connect_error){
                    die("connection failed:".$connection->connect_error);
                }
                


                $sql ="SELECT package.nom as nomp,package.description,package.categorie ,auteur.nom ,version.numero_version FROM auteur_package

                  INNER JOIN package on auteur_package.package_id =package.id 
                  INNER JOIN auteur on auteur_package.auteur_id = auteur.id
                  INNER JOIN version on version.package_id =package.id; ";
                $result = $connection->query($sql);
                if(!$result){
                    die("invalid query:".$connection->error);
                }

                while($row = $result->fetch_assoc()){
                    echo "
                    <div id='carte'>
                    <h1>$row[nomp]</h1>
                    <h2>Auteur :</h2>
                    <p>$row[nom]</p>
                    <h2>Vertion :</h2>
                    <p>$row[numero_version]</p>
                    <h2>description :</h2>
                    <p>$row[description]</p>
                    <h2>categorie :</h2>
                    <p>$row[categorie]</p>
                </div>

                    ";
                }
                ?>
        </div>
    </div>
    
</body>
</html>
