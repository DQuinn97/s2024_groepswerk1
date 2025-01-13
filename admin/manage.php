<?php
require("../includes/db.inc.php");
require("../includes/funcs.inc.php");
include_once "../includes/css_js.inc.php";

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

requiredAdmin();

$errors = [];
$success = false;

if (isset($_GET['id'])) {
    $id = (int)@$_GET['id'];
}
$user = getUserById($id);

if (isset($_POST['formUpdate'])) {
    $displayname = $_POST['inputDisplayname'];
    $email = $_POST['inputEmail'];
    $dateofbirth = $_POST['inputDateOfBirth'];
    $status = $_POST['inputStatus'];
    $isAdmin = $_POST['inputAdmin'];

    if (strlen($displayname) > 31) {
        $errors[] = "Display name is too long.";
    }

    if (strlen($email) == 0) {
        $errors[] = "Please enter the email for this user.";
    }

    if (strlen($email) > 255) {
        $errors[] = "Email is too long.";
    }

    if (strlen($dateofbirth) == 0) {
        $errors[] = "Please enter date of birth: YYYY-MM-DD";
    }

    if (count($errors) == 0) {
        $success = updateUser(
            $id,
            $displayname,
            $email,
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage User - SavePoint</title>
</head>

<body>

    <div class="container">
        <main>
            <h2>Manage user</h2>
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

            <form method="post" action="manage.php?id=<?= $id ?>">

                <input type="hidden" name="id" value="<?= $user['id']; ?>">

                <div class="form-group mt-3">
                    <label for="inputDisplayname" class="col-sm-2 col-form-label">Display Name:</label>
                    <div>
                        <input type="text" class="form-control" id="inputDisplayname" name="inputDisplayname" placeholder="Display Name" value="<?= $user['displayname']; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email Address:</label>
                    <div>
                        <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" value="<?= $user['email']; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputDateOfBirth" class="col-sm-2 col-form-label">Date of Birth:</label>
                    <div>
                        <input type="text" class="form-control" id="inputDateOfBirth" name="inputDateOfBirth" placeholder="Date of Birth" value="<?= $user['dateofbirth']; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputStatus" class="col-sm-2 col-form-label">Status:</label>
                    <div>
                        <input type="text" class="form-control" id="inputStatus" name="inputStatus" placeholder="Status" value="<?= $user['status']; ?>">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label for="inputAdmin" class="col-sm-2 col-form-label">Admin:</label>
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
                        <button type="submit" class="btn btn-primary" name="formUpdate" style="width: 100%">Update</button>
                    </div>
                </div>
            </form>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>