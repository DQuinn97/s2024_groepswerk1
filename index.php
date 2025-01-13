<?php
include_once "includes/css_js.inc.php";
include "includes/db.inc.php";
include "includes/funcs.inc.php";

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();
$UUID = @$_SESSION['UUID'];
$adult = false;
if ($UUID) checkAge($UUID);

if (isset($_POST['paginationSubmit'])) {
    $_POST = unserialize($_POST['postData']);
}

$perPage = 20;
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$startAt  = $perPage * ($page - 1);

$totalGames = getAllGamesCount();
$totalPages = ceil($totalGames / $perPage);

$games = [];
if (isset($_POST['filterSubmit'])) {
    $categoryFilters = [];
    if (isset($_POST['categoryFilter'])) $categoryFilters = $_POST['categoryFilter'];
    $platformFilters = [];
    if (isset($_POST['platformFilter'])) $platformFilters = $_POST['platformFilter'];
    $sort = 'id';
    $order = 'asc';

    if (isset($_POST['sort'])) {
        switch ($_POST['sort']) {
            case 'release_desc':
                $order = 'desc';
                $sort = 'release_date';
                break;
            case 'release_asc':
                $order = 'asc';
                $sort = 'release_date';
                break;
            case 'name_desc':
                $order = 'desc';
                $sort = 'name';
                break;
            case 'name_asc':
                $order = 'asc';
                $sort = 'name';
                break;
            case 'rating_asc':
                $order = 'asc';
                $sort = 'rating';
                break;
            case 'rating_desc':
                $order = 'desc';
                $sort = 'rating';
                break;
        }
    }
    $games = getAllGames(!$adult, $startAt, $perPage, $sort, $order, $categoryFilters, $platformFilters);
} else {
    $games = getAllGames(!$adult, $startAt, $perPage);
}


$platforms = getPlatforms();
$categories = getCategories();
$allGames = getAllGames();
$highlight = $allGames[array_rand($allGames)];
$name = $highlight["name"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SavePoint HOMEPAGE</title>
    <link rel="stylesheet" href="./dist/<?= $cssPath ?>" />
    <script type="module" src="./dist/<?= $jsPath ?>"></script>
</head>

<body>
    <?php include("includes/header.inc.php"); ?>
    <main>
        <section id="game_highlight">
            <a href="details.php?id=<?= $highlight["id"] ?>">
                <img src="<?= $highlight["image"] ?>" alt="image for highlighted game " .<?= $name ?> />
                <div class="highlight-content">
                    <h2 class="highlight-title"><?= $name ?></h2>
                    <p class="highlight-description"><?= substr($highlight['description'], 0, 300) . '(...)'; ?></p>
                </div>
            </a>
        </section>


        <section id="game_section">
            <!-- Filters -->
            <aside id="filters">
                <form method="POST" action="index.php?page=<?= $page ?>">
                    <h2>Sort</h2>
                    <select name="sort" id="sort">
                        <option value="release_desc" <?= $_POST['sort'] == "release_desc" ? 'selected' : '' ?>>Newest</option>
                        <option value="release_asc" <?= $_POST['sort'] == "release_asc" ? 'selected' : '' ?>>Oldest</option>
                        <option value="rating_desc" <?= $_POST['sort'] == "rating_desc" ? 'selected' : '' ?>>Highest rating</option>
                        <option value="rating_asc" <?= $_POST['sort'] == "rating_asc" ? 'selected' : '' ?>>Lowest rating</option>
                        <option value="name_asc" <?= $_POST['sort'] == "name_asc" ? 'selected' : '' ?>>A-Z</option>
                        <option value="name_desc" <?= $_POST['sort'] == "name_desc" ? 'selected' : '' ?>>Z-A</option>
                    </select>

                    <h2>Filters <span><a href="index.php">clear</a></span></h2>

                    <section id="filter">
                        <h3>Categories</h3>
                        <div>


                            <?php foreach ($categories as $category):
                                $name = $category['name']; ?>
                                <div class="filter">
                                    <input type="checkbox" name="categoryFilter[]" id="categoryFilter_<?= $name ?>" value="<?= $category['id'] ?>" <?= isset($_POST['categoryFilter']) && in_array($category['id'], $_POST['categoryFilter']) ? 'checked' : '' ?>>
                                    <label for="<?= $name ?>"><?= $name ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <h3>Platform</h3>
                        <div>

                            <?php foreach ($platforms as $platform):
                                $name = $platform['name']; ?>
                                <div class="filter">
                                    <input type="checkbox" name="platformFilter[]" id="platformFilter<?= $name ?>" value="<?= $platform['id'] ?>" <?= isset($_POST['platformFilter']) && in_array($platform['id'], $_POST['platformFilter']) ? 'checked' : '' ?>>
                                    <label for="<?= $name ?>"><?= $name ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <input type="submit" value="Apply Filters" id="filterSubmit" name="filterSubmit">

                    </section>
                </form>
                <section id="content">
                    <section class="game_card"><img src="" alt=""></section>
                </section>

            </aside>


            <!-- Game Grid Section -->
            <div id="games">
                <section id="game_list">
                    <?php foreach ($games as $game):
                        $name = $game["name"];
                        $releaseDate = substr($game["release_date"], 0, 4);
                        /*
                        $game_platforms = join(', ', array_map(function ($g) {
                            return $g["name"];
                        }, $game["platforms"]));
*/
                        $game_categories = array_map(function ($g) {
                            return $g["name"];
                        }, $game["categories"]);
                        $rdm_categories = [];
                        $rdm_categories_keys = array_rand($game_categories, min(5, count($game_categories)));
                        if (is_array($rdm_categories_keys)) {
                            foreach (
                                $rdm_categories_keys as $key
                            ) {
                                $rdm_categories[] = $game_categories[$key];
                            }
                        } else {
                            $rdm_categories = $game_categories;
                        }
                        $game_categories = array_map(function ($g) {
                            return "<span class='category_tag'> $g </span>";
                        }, $rdm_categories);
                        $game_categories = join('', $game_categories);


                    ?>
                        <a href="details.php?id=<?= $game["id"] ?>">
                            <div class="game_card">
                                <img src="<?= $game["image"]; ?>" alt="<?= "image for " . $name; ?>">
                                <div class="card_title"><?= $name; ?></div>
                                <div class="game_details">
                                    <p>Release Year: <?= $releaseDate; ?></p>
                                    <!-- <p>Platforms: <?= $game_platforms ?></p> -->
                                    <div class="category_tags"><?= $game_categories ?></div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>

                </section>
                <div class="pagination">
                    <span>
                        <form action="index.php?page=<?= $page - 1 ?>" method="POST">
                            <input type="hidden" name="postData" value="<?= htmlspecialchars(serialize($_POST)); ?>">
                            <input type="submit" name="paginationSubmit" value="&lt; previous">
                        </form>
                    </span><span>
                        <form action="index.php?page=<?= $page + 1 ?>" method="POST">
                            <input type="hidden" name="postData" value="<?= htmlspecialchars(serialize($_POST)); ?>">
                            <input type="submit" name="paginationSubmit" value="next &gt;">
                        </form>
                    </span>
                </div>
        </section>
        </div>

    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>

</html>