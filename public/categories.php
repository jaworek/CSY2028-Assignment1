<?php
session_start();
$title = "Select Category";
$content = file_get_contents('../html/categories.html');
require '../layout.php';
