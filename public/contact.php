<?php
session_start();
$title = "Contact";
$content = file_get_contents('../html/contact.html');
require '../layout.php';
