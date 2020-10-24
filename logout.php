<?php
Session_start();

if (isset($_COOKIE["userId"])) {
    unset($_SESSION[$_COOKIE["userId"]]);
    session_destroy();
    setcookie("userId", "", time() - 3600);
    header("Location: index.php");
    return true;
    exit;
} else {
    return false;
}
