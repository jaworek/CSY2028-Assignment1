<?php
session_start();
$title = 'Login';
$content = file_get_contents('../html/register.html');
require '../layout.php';
