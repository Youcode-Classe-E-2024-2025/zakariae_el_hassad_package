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
$email = "";
$date = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["id"])) {
        header("Location: /brief1_php/auteur/auteur.php");
        exit;
    }

    $id = $_GET["id"];
    $sql = "SELECT * FROM auteur WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: /brief1_php/auteur/auteur.php");
        exit;
    }

    $nom = $row["nom"];
    $email = $row["email"];
    $date = $row["date"];
} else {
    // Retrieve ID from the hidden input field
    $id = $_POST["id"];
    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    $date = trim($_POST["date"]);

    do {
        if (empty($nom) || empty($email) || empty($date)) {
            $errorMessage = "All fields are required.";
            break;
        }

        // Update query using prepared statements
        $sql = "UPDATE auteur SET nom = ?, email = ?, date = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssi", $nom, $email, $date, $id);

        if (!$stmt->execute()) {
            $errorMessage = "Error updating record: " . $stmt->error;
            break;
        }

        $successMessage = "Auteur updated successfully!";
        header("Location: /brief1_php/auteur/auteur.php");
        exit;
    } while (true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Auteur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Auteur</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo htmlspecialchars($errorMessage); ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <!-- Include the hidden ID input -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="nom">Nom</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nom" value="<?php echo htmlspecialchars($nom); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="email">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="date">Date</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="date" value="<?php echo htmlspecialchars($date); ?>">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-secondary" href="/brief1_php/auteur/auteur.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
