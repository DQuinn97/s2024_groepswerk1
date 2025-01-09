<?php

function connectToDB()
{
    $env = parse_ini_file('.env');
    $db_host = $env["DB_HOST"];
    $db_user = $env["DB_USER"];
    $db_password = $env["DB_PASSWORD"];
    $db_db = $env["DB_DB"];
    $db_port = $env["DB_PORT"];

    try {
        $db = new PDO('mysql:host=' . $db_host . '; port=' . $db_port . '; dbname=' . $db_db, $db_user, $db_password);
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        die();
    }
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    return $db;
}
function getPlatforms(int $game_id = 0): array|bool
{
    $sql = "SELECT platforms.id, platforms.name FROM platforms";
    if ($game_id) $sql .= " JOIN game_on_platform as gop ON platforms.id = gop.platform_id WHERE gop.game_id = :game_id;";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute($game_id ? [':game_id' => $game_id] : []);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getCategories(int $game_id = 0): array|bool
{
    $sql = "SELECT categories.id, categories.name FROM categories";
    if ($game_id) $sql .= " JOIN game_in_category as gic ON categories.id = gic.category_id WHERE gic.game_id = :game_id;";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute($game_id ? [':game_id' => $game_id] : []);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getGameById(int $id): array|bool
{
    $sql = "SELECT games.id, games.name, games.developer, games.image, games.description, games.publisher, games.release_date FROM games
    WHERE games.id = :id;";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ":id" => $id
    ]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);
    $p = getPlatforms($game['id']);
    $game['platforms'] = $p ?: [];

    $c = getCategories($game['id']);
    $game['categories'] = $c ?: [];

    return $game;
}

function getRatingsById(int $id): array|bool
{
    $sql = "SELECT games.id, ratings.user_id, ratings.game_id, ratings.rating, ratings.review, users.id, users.displayname FROM ratings
    JOIN games ON ratings.game_id = games.id
    JOIN users ON ratings.user_id = users.id
    WHERE games.id = :id;";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ":id" => $id
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function formatDateTime($datetime)
{
    $date = new DateTime($datetime);
    return $date->format('d F Y');
}

function getAllUsers($allUsers = 0): array
{
    $sql = "SELECT users.id, users.displayname, users.email, users.dateofbirth, users.status, users.isAdmin, users.created, users.updated FROM users";

    if ($allUsers > 0)
        $sql .= " WHERE users.id = $allUsers";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllGames($allGames = 0): array
{
    $sql = "SELECT * FROM games";

    if ($allGames > 0)
        $sql .= " WHERE games.id = $allGames";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute();
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $games = array_map(function ($game): array {
        $p = getPlatforms($game['id']);
        $game['platforms'] = $p ?: [];

        $c = getCategories($game['id']);
        $game['categories'] = $c ?: [];

        return $game;
    }, $games);

    return $games;
}

function insertGame(String $name, String $developer, int $ageRestricted = 0, int $status = 1, String $image, String $description, String $publisher, String $release_date): bool|int
{
    $db = connectToDB();
    $sql = "INSERT INTO games(name, developer, ageRestricted, status, image, description, publisher, release_date) VALUES (:name, :developer, :ageRestricted, :status, :image, :description, :publisher, :release_date)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'developer' => $developer,
        'ageRestricted' => $ageRestricted,
        'status' => $status,
        'image' => $image,
        'description' => $description,
        'publisher' => $publisher,
        'release_date' => $release_date,
    ]);

    return $db->lastInsertId();
}

function updateGame(int $id, String $name, String $developer, int $ageRestricted = 0, int $status = 1, String $image, String $description, String $publisher, String $release_date): bool|int
{
    $db = connectToDB();
    $sql = "UPDATE games SET name=:name, developer=:developer, ageRestricted=:ageRestricted, status=:status, image=:image, description=:description, publisher=:publisher, release_date=:release_date WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'name' => $name,
        'developer' => $developer,
        'ageRestricted' => $ageRestricted,
        'status' => $status,
        'image' => $image,
        'description' => $description,
        'publisher' => $publisher,
        'release_date' => $release_date
    ]);

    return $db->lastInsertId();
}

function insertUser(String $displayname, String $email, String $password, String $dateofbirth, int $status = 1, int $isAdmin = 0): bool|int
{
    $db = connectToDB();
    $sql = "INSERT INTO users(displayname, email, password, dateofbirth, status, isAdmin) VALUES (:displayname, :email, :password, :dateofbirth, :status, :isAdmin)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'displayname' => $displayname,
        'email' => $email,
        'password' => md5($password),
        'dateofbirth' => $dateofbirth,
        'status' => $status,
        'isAdmin' => $isAdmin,
    ]);

    return $db->lastInsertId();
}

function getUserById(int $id): array|bool
{
    $sql = "SELECT users.id, users.displayname, users.email, users.dateofbirth, users.status, users.isAdmin FROM users
    WHERE users.id = :id;";

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ":id" => $id
    ]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);

    return $game;
}

function updateUser(int $id, String $displayname, String $email, String $dateofbirth, int $status, int $isAdmin): bool|int
{
    $db = connectToDB();
    $sql = "UPDATE users SET displayname=:displayname, email=:email, dateofbirth=:dateofbirth, status=:status, isAdmin=:isAdmin WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'displayname' => $displayname,
        'email' => $email,
        'dateofbirth' => $dateofbirth,
        'status' => $status,
        'isAdmin' => $isAdmin,
    ]);

    return $db->lastInsertId();
}
