<?php

session_start();

unset($_SESSION['user_logged_in']);
unset($_SESSION['UUID']);
unset($_SESSION['user_is_admin']);
header("Location: index.php");
exit;
