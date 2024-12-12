<?php 
// Connect to the database
$servername = "localhost";
$password = "";
$database = "my_brief1";
$username = "root";

$connection = new mysqli($servername, $username, $password, $database);

$nom = "";
$email = "";
$date = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $date = $_POST["date"];

    do {
        if (empty($nom) || empty($email) || empty($date)) {
            $errorMessage = "All fields are required.";
            break;
        }

        $sql = "INSERT INTO auteur (nom, email,date) VALUES ('$nom', '$email','$date')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $nom = "";
        $email = "";
        $date = "";

        $successMessage = "Student added successfully.";
        
        header("location: /brief1_php/auteur/auteur.php");
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
        <h2>New auteur</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $errorMessage; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="" method="post">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="nom">nom</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nom" value="<?php echo $nom; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="email">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="date">date</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" name="date" value="<?php echo $date; ?>">
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
                    <a class="btn btn-secondary btn-sm" href="/brief1_php/auteur/auteur.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
