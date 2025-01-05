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
                <h2>Filters</h2>
                <p>Clear all</p>
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

            </aside>


            <!-- Game Grid Section -->
            <div id="games">
                <section id="game_list">
                    <!-- DIT AANPASSEN NAAR PHP DB data -->
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 1</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                    <div class="game_card">
                        <img src="/images/Chayka-Mario.webp" alt="Game 1">
                        <div class="card_title">Game Title 2</div>
                        <div class="game_details">
                            <p>Platform: PC</p>
                            <p>Release Year: 2022</p>
                            <p>Type: Adventure</p>
                        </div>
                    </div>
                </section>
        </section>
        </div>

    </main>
    <?php include("includes/footer.inc.php"); ?>
</body>

</html>