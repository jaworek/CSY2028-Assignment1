<h3>Delete category</h3>
<?php
$categories = $database->findAll('categories');
listOptions($categories, ['title'], 'Delete', 'category_id');

if (isset($_GET['key']))
{
    echo '<p>Confirm deletion:</p>';
    echo '<a href="index.php?title=admin&option=deleteCategory&key=' . $_GET['key'] . '&delete">Yes</a>';
    echo '<a href="index.php?title=admin&option=deleteCategory">No</a>';
}

if (isset($_GET['delete']))
{
    deleteRow($database, 'categories', 'category_id', 'deleteCategory');
}
