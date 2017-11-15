<?php
session_start();
$title = "Latest Articles";
$content = file_get_contents('../html/articles.html');
require '../layout.php';
