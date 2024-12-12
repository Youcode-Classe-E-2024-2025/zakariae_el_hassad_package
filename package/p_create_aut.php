<?php 
// Connect to the database
$servername = "localhost";
$password = "";
$database = "my_brief1";
$username = "root";

$connection = new mysqli($servername, $username, $password, $database);

$auteur_id = "";
$package_id = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auteur_id = $_POST["auteur_id"];
    $package_id = $_POST["package_id"];

    do {
        if (empty($auteur_id) || empty($package_id)) {
            $errorMessage = "All fields are required.";
            break;
        }

        $sql = "INSERT INTO auteur_package (auteur_id, package_id) VALUES ('$auteur_id', '$package_id')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        

        // if ($connection->connect_error) {
        //     die("Connection failed: " . $connection->connect_error);
        // }

        // Insert data into the database
        

        // Clear the form fields
        $auteur_id = "";
        $package_id = "";

        $successMessage = "Student added successfully.";
        
        header("location: /brief1_php/package/package.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>New Student</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $errorMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="auteur_id">auteur_id</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="auteur_id" value="<?php echo $auteur_id; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="package_id">package_id</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="package_id" value="<?php echo $package_id; ?>">
                </div>
            </div>

            </div>

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?php echo $successMessage; ?></strong>
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
