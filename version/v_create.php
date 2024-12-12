<?php 
// Connect to the database
$servername = "localhost";
$password = "";
$database = "my_brief1";
$username = "root";

$connection = new mysqli($servername, $username, $password, $database);

$numero_version = "";
$date_publication = "";
$package_id ="";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_version = $_POST["numero_version"];
    $date_publication = $_POST["date_publication"];
    $package_id = $_POST["package_id"];

    do {
        if (empty($numero_version) || empty($date_publication) || empty($package_id)) {
            $errorMessage = "All fields are required.";
            break;
        }

        $sql = "INSERT INTO version (numero_version, date_publication , package_id ) VALUES ('$numero_version', '$date_publication','$package_id')";
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
        $numero_version = "";
        $date_publication = "";
        $package_id = "";

        $successMessage = "version added successfully.";
        
        header("location: /brief1_php/version/version.php");
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
                <label class="col-sm-3 col-form-label" for="numero_version">numero de version</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="numero_version" value="<?php echo $numero_version; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="date_publication">date de publication</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="date_publication" value="<?php echo $date_publication; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="package_id">id de package</label>
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
                    <a class="btn btn-secondary btn-sm" href="/brief1_php/version/version.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
