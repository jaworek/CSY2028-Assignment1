<?php
session_start();
$title = 'Login';
$content = file_get_contents('../html/login.html');
require '../layout.php';

if (isset($_POST['login']) && isset($_POST['password'])) {
  if ($_POST['login'] == 'admin@admin.com' && $_POST['password'] == 'admin') {
      $_SESSION['logged'] = 2;
      header("Location: admin.php");
      exit();
  }
  else if ($_POST['login'] == 'user@user.com' && $_POST['password'] == 'user') {
    $_SESSION['logged'] = 1;
    header("Location: index.php");
    exit();
  }
}
