<?php
require("../includes/db.inc.php");
require("../includes/funcs.inc.php");
include_once "../includes/css_js.inc.php";



requiredAdmin();
$games = getAllGames();

?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="description" content="My description">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Game Management - SavePoint</title>
</head>

<body>

    <div class="container">
        <main>

            <div class="mt-3 mb-3">
                <a href="index.php">
                    <button type="button" class="btn btn-primary">Return</button>
                </a>
                <a href="add.php">
                    <button type="button" class="btn btn-outline-primary">Add new game</button>
                </a>
            </div>
            <div class="table-responsive small">
                <table class="table table-hover table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Edit Entry</th>
                            <th scope="col">#ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Developer</th>
                            <th scope="col">Age Restriction</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created</th>
                            <th scope="col">Updated</th>
                            <th scope="col">Released</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($games as $game): ?>

                            <tr>
                                <td><a href="update.php?id=<?= $game['id'] ?>"><button type="button" class="btn btn-primary">Update</button></a>
                                    <a href="delete.php?id=<?= $game['id'] ?>"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                                <td><?= $game['id']; ?></td>
                                <td><?= $game['name']; ?></td>
                                <td><?= $game['developer']; ?></td>
                                <td><?= $game['ageRestricted']; ?></td>
                                <td><?= $game['status']; ?></td>
                                <td><?= $game['created']; ?></td>
                                <td><?= $game['updated']; ?></td>
                                <td><?= $game['release_date']; ?></td>
                            </tr>

                        <?php endforeach; ?>


                    </tbody>
                </table>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>