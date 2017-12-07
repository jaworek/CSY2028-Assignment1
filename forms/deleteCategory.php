<?php
listOptions($database, 'categories', ['title'], 'Delete', 'category_id');

if (isset($_GET['key'])) {
    $database->delete('categories', 'category_id', $_GET['key']);
    header("Location: index.php?title=admin&option=deleteCategory");
}
