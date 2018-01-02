<?php
// if user has logged in, if not they are redirected to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?title=login");
}
// if user does not have admin rights, they will be redirected to home page
if ($_SESSION['logged'] != 'admin') {
    header("Location: index.php?title=home");
}
?>

<nav>
    <ul>
        <li><a href="index.php?title=admin&option=addUser">Add user</a></li>
        <li><a href="index.php?title=admin&option=editUser">Edit user</a></li>
        <li><a href="index.php?title=admin&option=deleteUser">Remove user</a></li>
        <li><a href="index.php?title=admin&option=addArticle">Add article</a></li>
        <li><a href="index.php?title=admin&option=editArticle">Edit article</a></li>
        <li><a href="index.php?title=admin&option=deleteArticle">Remove article</a></li>
        <li><a href="index.php?title=admin&option=addCategory">Add category</a></li>
        <li><a href="index.php?title=admin&option=editCategory">Edit category</a></li>
        <li><a href="index.php?title=admin&option=deleteCategory">Remove category</a></li>
        <li><a href="index.php?title=admin&option=approveComments">Approve comments</a></li>
    </ul>
</nav>

<article>

    <?php
    if (isset($_GET['option'])) {
        switch ($_GET['option']) {
            case 'addUser':
                require '../forms/addUser.php';
                break;
            case 'editUser':
                require '../forms/editUser.php';
                break;
            case 'deleteUser':
                require '../forms/deleteUser.php';
                break;
            case 'addArticle':
                require '../forms/addArticle.php';
                break;
            case 'editArticle':
                require '../forms/editArticle.php';
                break;
            case 'deleteArticle':
                require '../forms/deleteArticle.php';
                break;
            case 'addCategory':
                require '../forms/addCategory.php';
                break;
            case 'editCategory':
                require '../forms/editCategory.php';
                break;
            case 'deleteCategory':
                require '../forms/deleteCategory.php';
                break;
            case 'approveComments':
                require '../forms/approveComments.php';
                break;
            default:
                echo "Not a valid option";
                break;
        }
    }
    else {
      echo '<h3>Admin</h3>';
      echo '<p>Choose one of the options to make changes in the database.</p>';
    }
    ?>

</article>
