<?php
require("../includes/db.inc.php");
include_once "../includes/css_js.inc.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errors = [];
$success = false;

$displayname = "";
$email = "";
$password = null;
$dateofbirth = "";
$status = 1;
$isAdmin = null;

if (isset($_POST['formSubmit'])) {
    $displayname = $_POST['inputDisplayname'];
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
    $dateofbirth = $_POST['inputDateOfBirth'];
    $status = 1;
    $isAdmin = $_POST['inputAdmin'];

    if (strlen($displayname) == 0) {
        $errors[] = "Please enter a display name.";
    }

    if (strlen($displayname) > 31) {
        $errors[] = "Display name is too long.";
    }

    if (strlen($email) == 0) {
        $errors[] = "Please enter the email for this user.";
    }

    if (strlen($email) > 255) {
        $errors[] = "Email is too long.";
    }

    if (strlen($password) < 5) {
        $errors[] = "Password is too short.";
    }

    if (strlen($dateofbirth) == 0) {
        $errors[] = "Please enter date of birth: YYYY-MM-DD";
    }

    if (count($errors) == 0) {
        $success = insertUser(
            $displayname,
            $email,
            $password,
            $dateofbirth,
            $status,
            $isAdmin
        );
        header("Location: users.php");
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <link rel="icon" href="https://via.placeholder.com/70x70">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css">

    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Creation - SavePoint</title>
</head>

<body>

    <div class="container">
        <main>
            <h2>Create user</h2>
            <hr />

            <a href="users.php"><button type="button" class="btn btn-primary">Return</button></a>

            <?php if (count($errors) > 0): ?>
                <div class="alert alert-danger" role="alert">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif ?>

            <form method="post" action="create.php">

                <div class="form-group mt-3">
                    <label for="inputDisplayname" class="col-sm-2 col-form-label">Display Name: *</label>
                    <div>
                        <input type="text" class="form-control" id="inputDisplayname" name="inputDisplayname" placeholder="Display Name" value="<?php echo isset($displayname) ? $displayname : ''; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email Address: *</label>
                    <div>
                        <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" value="<?php echo isset($email) ? $email : ''; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password: *</label>
                    <div>
                        <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" value="<?php echo isset($password) ? $password : ''; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputDateOfBirth" class="col-sm-2 col-form-label">Date of Birth: *</label>
                    <div>
                        <input type="text" class="form-control" id="inputDateOfBirth" name="inputDateOfBirth" placeholder="Date of Birth" value="<?php echo isset($dateofbirth) ? $dateofbirth : ''; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputAdmin" class="col-sm-2 col-form-label">Admin: *</label>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="inputAdmin" id="inputAdmin1" value="1">
                            <label class="form-check-label" for="inputAdmin1">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="inputAdmin" id="inputAdmin2" value="0" checked>
                            <label class="form-check-label" for="inputAdmin2">
                                No
                            </label>
                        </div>

                    </div>

                </div>

                <div class="form-group mt-5">
                    <div>
                        <button type="submit" class="btn btn-primary" name="formSubmit" style="width: 100%">Create</button>
                    </div>
                </div>
            </form>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>