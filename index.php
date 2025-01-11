<?php
include_once "includes/css_js.inc.php";
include "includes/db.inc.php";
include "includes/funcs.inc.php";
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$games = getAllGames();
$platforms = getPlatforms();
$categories = getCategories();
// echo '<pre>';
// print_r($platforms);
// echo '<pre>';
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
        <?php
        $highlight = $games[array_rand($games)];
        $name = $highlight["name"];
        ?>
        <a href="details.php?id=<?= $highlight["id"] ?>">
            <section id="game_highlight">

                <img src="<?= $highlight["image"] ?>" alt="image for highlighted game " .<?= $name ?> />
                <div class="highlight-content">
                    <h2 class="highlight-title"><?= $name ?></h2>
                    <p class="highlight-description"><?= substr($highlight['description'], 0, 300) . '(...)'; ?></p>
                </div>
            </section>
        </a>
        <!-- Filters -->
        <select name="sort" id="sort">
            <option value="rating_desc">Highest rating</option>
            <option value="rating_asc">Lowest rating</option>
            <option value="release_desc">Newest</option>
            <option value="release_asc">Oldest</option>
            <option value="name_asc">A-Z</option>
            <option value="name_desc">Z-A</option>
        </select>
        <section id="game_section">

            <aside id="filters">
                <form method="GET" action="#">
                    <h2>Filters</h2>
                    <a href="index.php">clear filters</a>
                    <section id="filter">

                        <div>
                            <h2>Categories</h2>

                            <?php foreach ($categories as $category):
                                $name = $category['name']; ?>
                                <div class="filter">
                                    <input type="checkbox" name="categoryFilter[]" id="<?= $name ?>" value="<?= $name ?>">
                                    <label for="<?= $name ?>"><?= $name ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div>
                            <h2>Platform</h2>
                            <?php foreach ($platforms as $platform):
                                $name = $platform['name']; ?>
                                <div class="filter">
                                    <input type="checkbox" name="platformFilter[]" id="<?= $name ?>" value="<?= $name ?>">
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
        </section>
        </div>

    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>

</html>