<?php
function check_login() {
    if (empty($_SESSION['alogin'])) {
        header("Location: index.php");
        exit();
    }
}
?>
