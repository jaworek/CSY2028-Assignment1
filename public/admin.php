<?php
session_start();
$title = "Admin";

if (isset($_SESSION['logged'])) {
    if ($_SESSION['logged'] == 2) {
        $content = file_get_contents('../html/admin.html');
    }
    else {
      $content = "You have no access to admin area";
    }
} else {
    $content = file_get_contents('../html/login.html');
}

require '../layout.php';
