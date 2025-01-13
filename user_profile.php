<?php

include_once "includes/css_js.inc.php";
include "includes/db.inc.php";
include "includes/funcs.inc.php";
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


requiredLoggedIn();

$errors = [];


$UUID = $_SESSION['UUID'];
$user = getAllUsers($UUID)[0];
$user["platforms"] = array_map(function ($p) {
    return $p["id"];
}, getUserPlatforms($UUID));

$profile_displayname = "";
$profile_dob = "";
$profile_platforms = [];

echo '<pre>';
print_r($_POST);
echo '</pre>';

if (isset($_POST["profile_submit"])) {
    $profile_displayname = $_POST["profile_displayname"];
    $profile_dob = $_POST["profile_dob"];
    $profile_platforms = $_POST["profile_platforms"] ?? [];

    if (isset($profile_displayname)) {
        if (strlen($profile_displayname) > 32) $errors[] = "Displayname cannot be longer than 32 characters...";
    }
    if (strlen($profile_dob) && preg_match("/\d{2,4}\-\d{1,2}\-\d{1,2}/", $_POST["profile_dob"])) {
        $dob = DateTime::createFromFormat("Y-m-d", $profile_dob);
        if ($dob > new DateTime()) $errors[] = "Date must be in the past...";
    } else {
        $profile_dob = '';
    }
    if (strlen($_POST["profile_oldPassword"])) {
        if (!checkPassword($_SESSION["UUID"], $_POST["profile_oldPassword"])) $errors[] = "Incorrect password...";
        elseif (!isset($_POST["profile_newPassword"])) $errors[] = "Please enter new password...";
        elseif (!passRegex($_POST['profile_newPassword'])) $errors[] = "Please enter a new valid, secure password...";
    }

    if (!count($errors)) {
        $check = updateUser($UUID, $profile_displayname, $user["email"], $profile_dob, $user["status"], $user["isAdmin"], strlen($_POST["profile_newPassword"]) ? $_POST["profile_newPassword"] : null);
        updateUserPlatforms($UUID, $profile_platforms);
        if (!$check) {
            $errors[] = "Something went wrong...";
        } else {
            header("Location: user_profile.php");
            exit;
        }
    }
} elseif (isset($_POST["profile_delete"])) {
    $deleted = deleteUser($UUID);
    if ($deleted) {
        header("Location: user_logout.php");
        exit;
    } else {
        $errors[] = "Could not delete profile...";
    }
} else {
    $profile_displayname = $user["displayname"];
    $profile_dob = $user["dateofbirth"];
    $profile_platforms = $user["platforms"];
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
                <p>Leaving this page without saving will revert changes.</p>
                <ul id="error_messages"><?php foreach ($errors as $error): ?><li><?= $error ?></li><?php endforeach; ?></ul>
                <label for="profile_displayname">Displayname:</label><input type="text" id="profile_displayname" name="profile_displayname" value="<?= $profile_displayname ?>">
                <label for="profile_dob">Date of birth <span>(required for agerestricted games)</span>:</label><input type="date" id="profile_dob" name="profile_dob" max="<?= date("Y-m-d") ?>" value="<?= $profile_dob ?? '' ?>">
                <!-- Platforms -->
                <label>Platforms:</label>
                <?php foreach (getPlatforms() as $platform): ?>
                    <div class="profile_platforms"><label for="profile_platform_<?= $platform["name"] ?>"><?= $platform["name"] ?> </label><input type="checkbox" id="profile_platform_<?= $platform["name"] ?>" name="profile_platforms[]" value="<?= $platform["id"] ?>" <?= in_array($platform["id"], $profile_platforms) ? "checked" : '' ?>></div>
                <?php endforeach; ?>
                <!-- Password -->
                <h4>Change password (optional):</h4>
                <label for="profile_oldPassword">Enter password: </label><input type="text" id="profile_oldPassword" name="profile_oldPassword">
                <label for="profile_newPassword">Enter new password: </label><input type="text" id="profile_newPassword" name="profile_newPassword">

                <input type="submit" value="save" id="profile_submit" name="profile_submit">
                <hr>
                <!-- DELETE PROFILE -->
                <h4>Delete profile: </h4>
                <p>WARNING: this is irreversible</p>
                <input type="button" value="DELETE" id="open_modal" name="profile_delete">
            </form>
        </section>
        <section id="modal" class="modal">
            <form action="user_profile.php" method="POST" class="modal-content">
                <input type="hidden" name="UUID" value="<?= $UUID ?>">
                <p>Confirm deletion of profile:</p>
                <input type="submit" value="DELETE" name="profile_delete" id="profile_delete" class="modal-delete">
                <input type="button" value="cancel" name="close_modal" id="close_modal" class="modal-cancel">
            </form>

        </section>
    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>

</html>