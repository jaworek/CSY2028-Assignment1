<?php
session_start();
$title = "Home";
$content = file_get_contents('../html/index.html');
require '../layout.php';
