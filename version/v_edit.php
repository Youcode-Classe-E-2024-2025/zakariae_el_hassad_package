<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "my_brief1";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$id = ""; // أضف تعريف المتغير id
$numero_version = "";
$date_publication = "";
$package_id = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET["id"])) {
        header("Location: /brief1_php/version/version.php");
        exit;
    }

    $id = $_GET["id"];
    $sql = "SELECT * FROM version WHERE id = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $connection->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: /brief1_php/version/version.php");
        exit;
    }

    $numero_version = $row["numero_version"];
    $date_publication = $row["date_publication"];
    $package_id = $row["package_id"];
} else {
    // Retrieve ID from the hidden input field
    $id = $_POST["id"];
    $numero_version = trim($_POST["numero_version"]);
    $date_publication = trim($_POST["date_publication"]);
    $package_id = trim($_POST["package_id"]);

    do {
        if (empty($numero_version) || empty($date_publication) || empty($package_id)) {
            $errorMessage = "All fields are required.";
            break;
        }

        // Update query using prepared statements
        $sql = "UPDATE version SET numero_version = ?, date_publication = ?, package_id = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);

        if (!$stmt) {
            $errorMessage = "Prepare failed: " . $connection->error;
            break;
        }

        $stmt->bind_param("sssi", $numero_version, $date_publication, $package_id, $id);

        if (!$stmt->execute()) {
            $errorMessage = "Error updating record: " . $stmt->error;
            break;
        }

        $successMessage = "Version updated successfully!";
        header("Location: /brief1_php/version/version.php");
        exit;
    } while (true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Version</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Version</h2>

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
                <label class="col-sm-3 col-form-label" for="numero_version">Numero de Version</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="numero_version" value="<?php echo htmlspecialchars($numero_version); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="date_publication">Date de Publication</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="date_publication" value="<?php echo htmlspecialchars($date_publication); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="package_id">ID de Package</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="package_id" value="<?php echo htmlspecialchars($package_id); ?>">
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
                    <a class="btn btn-secondary btn-sm" href="/brief1_php/version/version.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
