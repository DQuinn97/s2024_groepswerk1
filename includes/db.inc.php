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
function getUserPlatforms(int $UUID): array|bool
{
    $sql = "SELECT platforms.id, platforms.name FROM platforms JOIN user_owns_platform as uop ON platforms.id = uop.platform_id WHERE uop.user_id = :UUID;";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([':UUID' => $UUID]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getGamesInList(int $id): array|bool
{
    $sql = "select * from lists JOIN game_in_list ON list_id = lists.id JOIN games on game_id = games.id  WHERE lists.id = :id";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([':id' => $id]);

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
function getUserLists(int $UUID): array|bool
{
    $sql = "SELECT lists.* FROM lists WHERE user_id = :UUID";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([':UUID' => $UUID]);
    $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($lists as $id => $list) {
        $lists[$id]["games"] = getGamesInList($list["id"]);
    }

    return $lists;
}
function getListById($id): array|bool
{
    $sql = "SELECT * FROM lists WHERE id=:id";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([':id' => $id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function updateList($id, $name, $description): int|bool
{
    $db = connectToDB();
    $sql = "UPDATE lists SET name=:name, description=:description, updated=CURRENT_TIMESTAMP WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'name' => $name,
        'description' => $description
    ]);

    return $stmt->rowCount();
}
function deleteList($id): int
{
    $db = connectToDB();

    $sql = "DELETE FROM lists WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);
    $deletedRows = $stmt->rowCount();

    return $deletedRows;
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
    $sql = "SELECT games.id, games.name, games.developer, games.ageRestricted, games.status, games.image, games.description, games.publisher, games.release_date FROM games
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
function getAvgRatingById(int $id)
{
    $sql = "SELECT AVG(rating) as rating FROM ratings WHERE game_id = :id";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([
        ":id" => $id
    ]);
    return $stmt->fetchColumn();
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


function getAllGames(bool $ageRestrict = null, int $startAt = null, int $perPage = 20, String $sort = "id", String $order = "ASC", array $categoryfilters = [], array $platformfilters = []): array
{
    $target = "games";

    if (count($categoryfilters) || count($platformfilters)) {
        if (count($categoryfilters) && !count($platformfilters)) {
            $categoryfilter = join(',', $categoryfilters);
            $target = "(SELECT games.* FROM games JOIN game_in_category ON game_id = games.id AND category_id IN (" . $categoryfilter . ") GROUP BY games.id HAVING COUNT(*)=" . count($categoryfilters) . ")";
        } elseif (!count($categoryfilters) && count($platformfilters)) {
            $platformfilter = join(',', $platformfilters);
            $target = "(SELECT games.* FROM games JOIN game_on_platform ON game_id = games.id AND platform_id IN (" . $platformfilter . ") GROUP BY games.id HAVING COUNT(*)=" . count($platformfilters) . ")";
        } else {
            $categoryfilter = join(',', $categoryfilters);
            $platformfilter = join(',', $platformfilters);
            $target = "(SELECT games.* FROM (SELECT games.* FROM games JOIN game_in_category ON game_id = games.id AND category_id IN (" . $categoryfilter . ") GROUP BY games.id HAVING COUNT(*)=" . count($categoryfilters) . ") AS games JOIN game_on_platform ON game_id = games.id AND platform_id IN (" . $platformfilter . ") GROUP BY games.id HAVING COUNT(*)=" . count($platformfilters) . ")";
        }
    }
    $sql = "SELECT * FROM " . $target . " AS games";

    if ($ageRestrict == false) {
        $sql .= " WHERE ageRestricted = false";
    }
    $sql .= " ORDER BY " . $sort . " " . $order;
    if ($startAt !== null) {
        $sql .= " LIMIT " . $startAt . ',' . $perPage;
    }

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
function getAllGamesCount(bool $ageRestrict = null, String $sort = "id", String $order = "ASC", array $categoryfilters = [], array $platformfilters = []): int
{
    $target = "games";

    if (count($categoryfilters) || count($platformfilters)) {
        if (count($categoryfilters) && !count($platformfilters)) {
            $categoryfilter = join(',', $categoryfilters);
            $target = "(SELECT games.* FROM games JOIN game_in_category ON game_id = games.id AND category_id IN (" . $categoryfilter . ") GROUP BY games.id HAVING COUNT(*)=" . count($categoryfilters) . ")";
        } elseif (!count($categoryfilters) && count($platformfilters)) {
            $platformfilter = join(',', $platformfilters);
            $target = "(SELECT games.* FROM games JOIN game_on_platform ON game_id = games.id AND platform_id IN (" . $platformfilter . ") GROUP BY games.id HAVING COUNT(*)=" . count($platformfilters) . ")";
        } else {
            $categoryfilter = join(',', $categoryfilters);
            $platformfilter = join(',', $platformfilters);
            $target = "(SELECT games.* FROM (SELECT games.* FROM games JOIN game_in_category ON game_id = games.id AND category_id IN (" . $categoryfilter . ") GROUP BY games.id HAVING COUNT(*)=" . count($categoryfilters) . ") AS games JOIN game_on_platform ON game_id = games.id AND platform_id IN (" . $platformfilter . ") GROUP BY games.id HAVING COUNT(*)=" . count($platformfilters) . ")";
        }
    }
    $sql = "SELECT COUNT(*) FROM " . $target . " AS games";

    if ($ageRestrict == false) {
        $sql .= " WHERE ageRestricted = false";
    }
    $sql .= " ORDER BY " . $sort . " " . $order;

    $stmt = connectToDB()->prepare($sql);
    $stmt->execute();
    $games = $stmt->fetchColumn();
    return $games;
}

function insertGame(String $name, String $developer, int $ageRestricted = 0, int $status = 1, String $image = null, String $description = null, String $publisher = null, String $release_date = null): bool|int
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

function updateGame(int $id, String $name, String $developer, int $ageRestricted = 0, int $status = 1, String $image = null, String $description = null, String $publisher = null, String $release_date = null): bool|int
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

function deleteGame(int $id): bool|int
{
    $db = connectToDB();
    $sql = "DELETE FROM games WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);

    return $db->lastInsertId();
}

function deleteUser(int $id): int
{
    $db = connectToDB();

    $sql = "DELETE FROM users WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);
    $deletedRows = $stmt->rowCount();

    return $deletedRows;
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
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user;
}

function updateUser(int $id, String $displayname, String $email, String $dateofbirth, int $status, int $isAdmin, String $password = null): bool|int
{
    $db = connectToDB();
    $optional = "";
    $options = [
        'id' => $id,
        'displayname' => $displayname ?: null,
        'email' => $email,
        'dateofbirth' => $dateofbirth ?: null,
        'status' => $status,
        'isAdmin' => $isAdmin,
    ];
    if ($password !== null) {
        $optional = " password=:password,";
        $options['password'] = md5($password);
    }

    $sql = "UPDATE users SET displayname=:displayname," . $optional . " email=:email, dateofbirth=:dateofbirth, status=:status, isAdmin=:isAdmin, updated=CURRENT_TIMESTAMP WHERE id = :id";

    $stmt = $db->prepare($sql);
    $stmt->execute($options);

    return $stmt->rowCount();
}
function updateUserPlatforms(int $UUID, array $platforms)
{
    $db = connectToDB();
    $sql = "DELETE FROM user_owns_platform as uop WHERE user_id = :UUID";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':UUID' => $UUID
    ]);

    $deleted = $stmt->rowCount();

    $sql = "INSERT INTO user_owns_platform(user_id, platform_id) VALUES ";
    foreach ($platforms as $index => $platform) {
        $platforms[$index] = "(" . $UUID . "," . $platform . ")";
    }
    $sql .= join(",", $platforms);
    $stmt = $db->prepare($sql);
    $stmt->execute();

    return $stmt->rowCount() - $deleted;
}


/* USER LOGIN / REGISTRATION */
function checkEmail(String $email): bool
{
    $sql = "SELECT id FROM users WHERE email = :email AND status=1;";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([':email' => $email]);
    $exists = $stmt->fetch(PDO::FETCH_ASSOC);
    return $exists ? true : false;
}
function register(String $email, String $password): bool|int
{
    $db = connectToDB();
    $sql = "INSERT INTO users(email, password) VALUES (:email, :password);";
    $stmt = $db->prepare($sql);
    $stmt->execute([':email' => $email, ':password' => md5($password)]);
    return $db->lastInsertId();
}
function checkUser(String $email, String $password): bool | int
{
    $sql = "SELECT id FROM users WHERE email = :email AND password = :password AND status=1;";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([':email' => $email, ':password' => md5($password)]);
    return $stmt->fetchColumn();
}
function checkAdmin(int $UUID): bool
{
    $sql = "SELECT isAdmin FROM users WHERE id = :UUID;";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([':UUID' => $UUID]);
    return $stmt->fetchColumn();
}
function checkPassword(int $UUID, String $password): bool
{
    $sql = "SELECT id FROM users WHERE id = :UUID AND password = :password;";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([':UUID' => $UUID, ':password' => md5($password)]);
    return $stmt->fetchColumn();
}
function checkAge(int $UUID): bool
{
    $sql = "SELECT id FROM users WHERE id = :UUID AND TIMESTAMPDIFF(YEAR, dateofbirth, NOW()) > 18";
    $stmt = connectToDB()->prepare($sql);
    $stmt->execute([':UUID' => $UUID]);
    $col = $stmt->fetch(PDO::FETCH_ASSOC);
    return count($col) > 0;
}
function createList($UUID, $name = null, $description = null): int|bool
{
    $db = connectToDB();
    $sql = "INSERT INTO lists(user_id, name, description) VALUES (:UUID, :name, :description)";
    $stmt = $db->prepare($sql);
    $stmt->execute([':UUID' => $UUID, ':name' => $name, ':description' => $description]);

    return $db->lastInsertId();
}
function addGameToList($game, $list): int|bool
{
    $db = connectToDB();
    $sql = "INSERT INTO game_in_list(game_id, list_id) VALUES (:game, :list);";
    $stmt = $db->prepare($sql);
    $stmt->execute([':game' => $game, ':list' => $list]);
    return $db->lastInsertId();
}
function removeGameFromList($game, $list): int
{
    $db = connectToDB();

    $sql = "DELETE FROM game_in_list WHERE game_id = :game AND list_id= :list";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'game' => $game,
        'list' => $list
    ]);
    $deletedRows = $stmt->rowCount();

    return $deletedRows;
}
function insertRating(int $user_id, int $game_id, int $userRating, String $userReview): bool|int
{
    $db = connectToDB();
    $sql = "INSERT INTO ratings(user_id, game_id, rating, review) VALUES (:user_id, :game_id, :rating, :review)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        'user_id' => $user_id,
        'game_id' => $game_id,
        'rating' => $userRating,
        'review' => $userReview,
    ]);

    return $db->lastInsertId();
}
