<?php

function addLinks()
{
  if (isset($_SESSION['logged'])) {
    if ($_SESSION['logged'] == 2) {
      echo '<li><a href="admin.php">Admin</a></li>';
    }
    echo '<li><a href="logout.php">Logout</a></li>';
  } else {
    echo '<li><a href="login.php">Login</a></li>';
    echo '<li><a href="register.php">Register</a></li>';
  }
}
