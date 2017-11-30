<?php
if (!isset($_SESSION['logged'])) {
    header("Location: index.php?title=login");
}
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
    <li> <a href="index.php?title=admin&option=addCategory">Add category</a></li>
    <li><a href="index.php?title=admin&option=editCategory">Edit category</a></li>
    <li><a href="index.php?title=admin&option=deleteCategory">Remove category</a></li>
  </ul>
</nav>

<article>

<?php
if (isset($_GET['option'])) {
    switch ($_GET['option']) {
      case 'addUser':
        addUser();
        break;
      case 'editUser':
        listOptions($database, 'users', ['email'], 'Edit');
        break;
      case 'deleteUser':
        listOptions($database, 'users', ['email'], 'Delete');
        break;
      case 'addArticle':
        echo "addArticle";
        break;
      case 'editArticle':
        echo "editArticle";
        break;
      case 'deleteArticle':
        listOptions($database, 'articles', ['article_id', 'title'], 'Delete');
        break;
      case 'addCategory':
        echo "addCategory";
        break;
      case 'editCategory':
        echo "editCategory";
        break;
      case 'deleteCategory':
        listOptions($database, 'categories', ['title'], 'Delete');
        break;
      default:
        echo "Not a valid option";
        break;
    }
}
?>

</article>

<?php
function addUser()
{
    echo "<p>Create new user</p>";
    echo "<form>";
    echo '<input type="email" name="email"></input>';
    echo '<input type="password" name="password"></input>';
    echo '<input type="submit" name="button" value="Create"></input>';
    echo "</form>";
}

function listOptions($database, $table, $columns, $function)
{
    $elements = $database->findAll($table);

    echo "<table>";
    foreach ($elements as $element) {
        echo '<tr>';
        foreach ($columns as $value) {
            echo "<td>" . $element[$value] . "</td>";
        }
        echo '<td><a href="index.php?title=admin&option=' . $_GET['option'] . '&function=' . $function . '">' . $function . '</a></td></tr>';
    }
    echo "</table>";
}

if (isset($_GET['function'])) {
    if ($_GET['function'] == 'Edit') {
    }
}
