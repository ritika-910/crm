<?php
function check_login() {
    if (empty($_SESSION['login'])) {
        header("Location: login.php");
        exit();
    }
}
?>
