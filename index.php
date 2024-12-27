<?php
include_once "includes/css_js.inc.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEBSITE HOMEPAGE</title>
    <link rel="stylesheet" href="./dist/<?= $cssPath ?>" />
    <script type="module" src="./dist/<?= $jsPath ?>"></script>
</head>

<body>
    <header><img src="" alt="logo">
        <nav>
            <ul>
                <li><a href="#">New Releases</a></li>
                <li><a href="#">Categories</a></li>
                <li><a href="#">My Lists</a></li>
            </ul>
            <div id="notification"></div>
            <div id="profile"></div>
        </nav>
    </header>
    <main>
        <section id="game_highlight"></section>
        <section id="game_list">
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
    </main>
    <footer>
        <section>
            <p>SavePoint Gaming Database</p>
            <ul>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </section>
        <section>
            <p>Stay in touch! Subscribe to our Newsletter!</p>
            <form action=""><input type="text" name="sub_email" id="sub_email"><input type="submit" value="sub_submit" id="sub_submit"></form>
        </section>
    </footer>
</body>

</html>