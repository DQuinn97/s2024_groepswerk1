<?php
include_once "includes/css_js.inc.php";
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
            <img src="/images/Chayka-Mario.webp" alt="Game Highlight" />
            <div class="highlight-content">
                <h2 class="highlight-title">Game Title</h2>
                <p class="highlight-description">This is the game description that appears on hover.</p>
            </div>
        </section>
        <!-- Filters -->
        <section id="game_section">

            <aside id="filters">
                <section>
                    <h2>Filters</h2>
                    <p>Clear all</p>
                    <select name="sort" id="sort">
                        <option value="rating_desc">highest rating</option>
                        <option value="rating_asc">lowest rating</option>
                        <option value="release_desc">newest</option>
                        <option value="release_asc">oldest</option>
                        <option value="name_asc">A-Z</option>
                        <option value="name_desc">Z-A</option>
                    </select>
                </section>
                <section>
                    <section id="filter">
                        <div>
                            <h2>Category</h2>
                            <p>*fill using db*</p>
                        </div>
                        <div>
                            <h2>Platform</h2>
                            <p>*fill using db*</p>
                        </div>
                    </section>
                    <section id="content">
                        <section class="game_card"><img src="" alt=""></section>
                    </section>
                </section>
        </section>
        </section>


        <!-- Game Grid Section -->
        <section id="game_list">
            <!-- DIT AANPASSEN NAAR PHP DB data -->
            <div class="game_card">
                <img src="/images/Chayka-Mario.webp" alt="Game 1">
                <div class="card_title">Game Title 1</div>
            </div>
            <div class="game_card">
                <img src="/images/Chayka-Mario.webp" alt="Game 1">
                <div class="card_title">Game Title 1</div>
            </div>
            <div class="game_card">
                <img src="/images/Chayka-Mario.webp" alt="Game 1">
                <div class="card_title">Game Title 1</div>
            </div>
            <div class="game_card">
                <img src="/images/Chayka-Mario.webp" alt="Game 1">
                <div class="card_title">Game Title 1</div>
            </div>
            <div class="game_card">
                <img src="/images/Chayka-Mario.webp" alt="Game 1">
                <div class="card_title">Game Title 1</div>
            </div>
            <div class="game_card">
                <img src="/images/Chayka-Mario.webp" alt="Game 1">
                <div class="card_title">Game Title 1</div>
            </div>
            <div class="game_card">
                <img src="/images/Chayka-Mario.webp" alt="Game 1">
                <div class="card_title">Game Title 1</div>
            </div>
        </section>


    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>

</html>