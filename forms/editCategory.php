<h3>Edit category</h3>
<?php
$categories = $database->findAll('categories');
listOptions($categories, ['title'], 'Edit', 'category_id');

if (isset($_GET['key'])) {
    $category = $database->find('categories', 'category_id', $_GET['key']);
}

editCategory($database);

ob_start();
?>

    <form action="index.php?title=admin&option=editCategory" method="post">
        <input type="hidden" name="key" value="<?php echo $_GET['key'] ?>">
        <label for="title">Category:</label>
        <input id="title" type="text" name="title" placeholder="Category title"
               value="<?php echo $category['title']; ?>">
        <input type="submit" name="submit" value="Edit category">
    </form>

<?php
$form = ob_get_clean();
if (isset($_GET['key'])) {
    echo $form;
}
