<?php

include_once "includes/css_js.inc.php";
include "includes/db.inc.php";
include "includes/funcs.inc.php";
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


requiredLoggedIn();

$errors = [];
echo '<pre>';
print_r($_POST);
echo '</pre>';

$UUID = $_SESSION['UUID'];
if (isset($_POST["profile_submit"])) {
    if (isset($_POST["profile_displayname"])) {
        if (strlen($_POST["profile_displayname"]) > 32) $errors[] = "Displayname cannot be longer than 32 characters...";
    }
    if (strlen($_POST["profile_dob"]) && strlen($_POST["profile_dob"]) > 0 && preg_match("/\d{2,4}\-\d{1,2}\-\d{1,2}/", $_POST["profile_dob"])) {
        $dob = DateTime::createFromFormat("Y-m-d", $_POST["profile_dob"]);
        if ($dob > new DateTime()) $errors[] = "Date must be in the past...";
    }
    if (strlen($_POST["profile_oldPassword"])) {
        if (!checkPassword($_SESSION["UUID"], $_POST["profile_oldPassword"])) $errors[] = "Incorrect password...";
        elseif (!isset($_POST["profile_newPassword"])) $errors[] = "Please enter new password...";
        elseif (!passRegex($_POST['profile_newPassword'])) $errors[] = "Please enter a new valid, secure password...";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SavePoint Profile</title>
    <link rel="stylesheet" href="dist/<?= $cssPath ?>" />
</head>

<body>
    <?php include("includes/header.inc.php"); ?>
    <main>
        <section id="userprofile_edit">
            <form action="user_profile.php" method="POST">
                <h3>User <?= $UUID ?><span>(internal ID)</span></h3>
                <ul id="error_messages"><?php foreach ($errors as $error): ?><li><?= $error ?></li><?php endforeach; ?></ul>
                <label for="profile_displayname">Displayname:</label><input type="text" id="profile_displayname" name="profile_displayname" value="<?= $_POST["profile_displayname"] ?? '' ?>">
                <label for="profile_dob">Date of birth <span>(required for agerestricted games)</span>:</label><input type="date" id="profile_dob" name="profile_dob" max="<?= date("Y-m-d") ?>" value="<?= $_POST["profile_dob"] ?? '' ?>">
                <h4>Change password (optional):</h4>
                <label for="profile_oldPassword">Enter password: </label><input type="text" id="profile_oldPassword" name="profile_oldPassword">
                <label for="profile_newPassword">Enter new password: </label><input type="text" id="profile_newPassword" name="profile_newPassword">

                <input type="submit" value="save" id="profile_submit" name="profile_submit">
                <hr>
                <h4>Delete profile: </h4>
                <p>WARNING: this is irreversible</p>
                <input type="submit" value="DELETE" id="profile_delete" name="profile_delete">
            </form>
        </section>
    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>

</html>