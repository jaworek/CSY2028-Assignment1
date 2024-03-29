<?php
session_start();
require '../functions.php';
$database = new Database();

ob_start();

if (isset($_GET['title'])) {
    $title = $_GET['title'];

    switch ($title) {
    case 'admin':
      require 'admin.php';
      break;
    case 'articles':
      require 'articles.php';
      break;
    case 'categories':
      require 'categories.php';
      break;
    case 'contact':
      require 'contact.php';
      break;
    case 'login':
      require 'login.php';
      break;
    case 'register':
      isLogged();
      require 'register.php';
      break;
    case 'logout':
      logout();
      break;
    case 'profile':
      require 'profile.php';
      break;
    default:
      $title = 'Home';
      require 'home.php';
      break;
  }
} else {
    $title = 'Home';
    require 'home.php';
}

$content = ob_get_clean();
require '../layout.php';
