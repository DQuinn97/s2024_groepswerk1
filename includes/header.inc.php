<header>
    <a href="index.php">
        <div><img src="images/logo70px.webp" alt="logo">
            <h1>SavePoint</h1>
        </div>
    </a>
    <nav>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon-containter">
            <div id="menu-icon"></div>
        </label>
        <ul id="navigation">
            <li><a href="#">New Releases</a></li>
            <li><a href="#">Categories</a></li>
            <?php if (isLoggedIn()): ?>
                <li><a href="user_mylists.php">My Lists</a></li>
            <?php endif; ?>
        </ul>
        <div id="profile">
            <section>
                <ul>
                    <?php if (isLoggedIn()):
                        if (isAdmin()): ?>
                            <li><a href="admin/">admin panel</a></li>
                        <?php endif; ?>
                        <li><a href="user_profile.php">profile</a></li>
                        <li><a href="user_mylists.php">my lists</a></li>
                        <li><a href="user_logout.php">log out</a></li>
                    <?php else: ?>
                        <li><a href="user_login.php">log in</a></li>
                        <li><a href="user_register.php">register</a></li>
                    <?php endif; ?>
                </ul>
            </section>
        </div>

    </nav>

</header>