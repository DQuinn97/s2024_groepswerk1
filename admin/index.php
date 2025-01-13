<?php
require("../includes/db.inc.php");
require("../includes/funcs.inc.php");
include_once "../includes/css_js.inc.php";

requiredAdmin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SavePoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-3 mb-3">
        <main>
            <a href="../index.php"><button type="button" class="btn btn-primary">Return</button></a>
            <div class="d-grid gap-2 col-6 mx-auto">
                <a href="users.php"><button type="button" class="btn btn-outline-primary btn-lg">User Management</button></a><a href="games.php"><button type="button" class="btn btn-outline-primary btn-lg">Game Management</button></a>
            </div>
        </main>
    </div>
</body>

</html>