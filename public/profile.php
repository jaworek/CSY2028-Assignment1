<?php
if (!isset($_SESSION['user_id'])) {
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
      changeEmail($database);
      break;
    case 'password':
      changePassword($database);
      break;
    case 'delete':
      deleteAccount($database);
      break;
    default:
      echo "Not a valid option";
      break;
  }
}
?>

</article>
