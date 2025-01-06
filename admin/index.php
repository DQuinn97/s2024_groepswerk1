<?php
$_SERVER["admin"] = true;
include_once "../includes/css_js.inc.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN HOMEPAGE</title>
    <link rel="stylesheet" href="../dist/<?= $cssPath ?>" />
    <script type="module" src="../dist/<?= $jsPath ?>"></script>
</head>

<body>
    <?php include("includes/header.inc.php"); ?>

    <?= "php works on admin page" ?>
    <p class="icon-location2"></p>
    <img src="images/sample.jpg" alt="">

    <?php include("includes/footer.inc.php"); ?>

</body>

</html>