<?php
if (!isset($_SESSION['logged'])) {
    header("Location: index.php?title=login");
}
if ($_SESSION['logged'] == 'admin') {
    header("Location: index.php?title=admin");
}
?>

<nav>
  <ul>
    <li><a href="index.php?title=profile&option=email">Change email</a></li>
    <li><a href="index.php?title=profile&option=password">Change password</a></li>
    <li><a href="index.php?title=profile&option=delete">Delete account</a></li>
  </ul>
</nav>
<article>

<?php
if (isset($_GET['option'])) {
    switch ($_GET['option']) {
    case 'email':
      echo "Change email";
      break;
    case 'password':
      echo "Change password";
      break;
    case 'delete':
      echo "Delete account";
      break;
    default:
      echo "Not a valid option";
      break;
  }
}
?>

</article>
