<?php
function requiredLoggedIn()
{
    if (!isLoggedIn()) {
        header("Location: user_login.php");
        exit;
    }
}
function requiredLoggedOut()
{
    if (isLoggedIn()) {
        header("Location: index.php");
        exit;
    }
}
function requiredAdmin()
{
    if (!isAdmin()) {
        header("Location: ../index.php");
        exit;
    }
}
function isLoggedIn(): bool
{
    session_start();

    $loggedin = FALSE;

    if (isset($_SESSION['user_logged_in'])) {
        if ($_SESSION['user_logged_in'] > time()) {
            $loggedin = TRUE;
            logIn($_SESSION['UUID']);
        }
    }

    return $loggedin;
}
function isAdmin(): bool
{
    session_start();

    $isAdmin = FALSE;

    if (isset($_SESSION['user_is_admin'])) {
        if ($_SESSION['user_is_admin']) $isAdmin = TRUE;
    } else {
        if (isLoggedIn() && checkAdmin($_SESSION['UUID'])) {
            $isAdmin = TRUE;
            $_SESSION['user_is_admin'] = TRUE;
        }
    }

    return $isAdmin;
}
function logIn($UUID)
{
    $_SESSION['UUID'] = $UUID;
    $_SESSION['user_logged_in'] = time() + 3600;
}
function passRegex(String $password): bool
{
    $passwordRegex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
    return preg_match($passwordRegex, $password);
}
