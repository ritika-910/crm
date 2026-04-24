<?php
$con = mysqli_connect("localhost", "root", "", "crm");
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}
msqli_set_charset($con, "utf8");
?>