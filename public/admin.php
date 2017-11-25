<?php
ob_start();
?>
<nav>
  <ul>
    <li><a href="index.php?title=admin&option=addUser">Add user</a></li>
    <li><a href="index.php?title=admin&option=editUser">Edit user</a></li>
    <li><a href="index.php?title=admin&option=deleteUser">Remove user</a></li>
    <li><a href="index.php?title=admin&option=addArticle">Add article</a></li>
    <li><a href="index.php?title=admin&option=editArticle">Edit article</a></li>
    <li><a href="index.php?title=admin&option=deleteArticle">Remove article</a></li>
    <li> <a href="index.php?title=admin&option=addCategory">Add category</a></li>
    <li><a href="index.php?title=admin&option=editCategory">Edit category</a></li>
    <li><a href="index.php?title=admin&option=deleteCategory">Remove category</a></li>
  </ul>
</nav>

<article>

<?php
$admin = ob_get_clean();

if (isset($_SESSION['logged'])) {
    if ($_SESSION['logged'] == 'admin') {
        echo $admin;
    } else {
        header("Location: index.php?title=home");
    }
} else {
    header("Location: index.php?title=login");
}

if (isset($_GET['option'])) {
    switch ($_GET['option']) {
      case 'addUser':
        echo "addUser";
        break;
      case 'editUser':
        echo "editUser";
        break;
      case 'deleteUser':
        echo "deleteUser";
        break;
      case 'addArticle':
        echo "addArticle";
        break;
      case 'editArticle':
        echo "editArticle";
        break;
      case 'deleteArticle':
        echo "deleteArticle";
        break;
      case 'addCategory':
        echo "addCategory";
        break;
      case 'editCategory':
        echo "editCategory";
        break;
      case 'deleteCategory':
        echo "deleteCategory";
        break;
      default:
        echo "bob";
        break;
    }
}
?>

</article>
