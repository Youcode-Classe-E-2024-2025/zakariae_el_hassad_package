<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "my_brief1";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$id = "";
$nom = "";
$description = "";
$categorie = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["id"])) {
        header("Location: /brief1_php/package/package.php");
        exit;
    }

    $id = $_GET["id"];
    $sql = "SELECT * FROM package WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: /brief1_php/package/package.php");
        exit;
    }

    $nom = $row["nom"];
    $description = $row["description"];
    $categorie = $row["categorie"];
} else {
    $id = $_POST["id"];
    $nom = trim($_POST["nom"]);
    $description = trim($_POST["description"]);
    $categorie = trim($_POST["categorie"]);

    do {
        if (empty($nom) || empty($description) || empty($categorie)) {
            $errorMessage = "All fields are required.";
            break;
        }

        $sql = "UPDATE package SET nom = ?, description = ?, categorie = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssi", $nom, $description, $categorie, $id);

        if (!$stmt->execute()) {
            $errorMessage = "Error updating record: " . $stmt->error;
            break;
        }

        $successMessage = "Package updated successfully!";
        header("Location: /brief1_php/package/package.php");
        exit;
    } while (true);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Package</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo htmlspecialchars($errorMessage); ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="nom">Nom</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nom" value="<?php echo htmlspecialchars($nom); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="description">Description</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="description" value="<?php echo htmlspecialchars($description); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="categorie">Categorie</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="categorie" value="<?php echo htmlspecialchars($categorie); ?>">
                </div>
            </div>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?php echo htmlspecialchars($successMessage); ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-secondary btn-sm" href="/brief1_php/package/package.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
