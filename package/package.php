<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixed Sidebar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/home.css">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/table.css">
</head>
<body>

    <div class="sidebar">
        <div id="image" class="navbar-brand d-flex align-items-center">
            <img src="../img/Leonardo_Phoenix_A_stylized_modern_and_sleek_logo_for_ZH_a_bol_0.jpg" alt="Logo" class="me-2" style="width: 50px; height: auto;">
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
        <h1 id="titre" >LES PACKAGES</h1>
        <p id="list">----------list of PACKAGE----------</p>
        <br><br>
        <a class="btn btn-primary btn-sm" href="/brief1_php/package/p_create.php" role="button">New package</a>
        <a class="btn btn-primary btn-sm" href="/brief1_php/package/p_create_aut.php" role="button">relation enter package et auteur</a>
        <br><br>
        <div class="table-container">
            <table id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Catégorie</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "my_brief1";
        
                    // Create connection
                    $connection = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($connection->connect_error) {
                        die("Connection failed:" . $connection->connect_error);
                    }

                    // Read all rows from database table
                    $sql = "SELECT * FROM package";
                    $result = $connection->query($sql);
                    if (!$result) {
                        die("Invalid query:" . $connection->error);
                    }
        
                    // Read data of each row 
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                        <td>$row[id]</td>
                        <td>$row[nom]</td>
                        <td>$row[description]</td>
                        <td>$row[categorie]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/brief1_php/package/p_edit.php?id=$row[id]'>Edit</a>
                            <a class='btn btn-primary btn-sm' href='/brief1_php/package/p_delete.php?id=$row[id]'>Delete</a>
                        </td>
                    </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    </div>
</body>
</html>



