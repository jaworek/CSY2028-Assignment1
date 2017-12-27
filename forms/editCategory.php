<?php
$categories = $database->findAll('categories');
listOptions($categories, ['title'], 'Edit', 'category_id');

if (isset($_GET['key'])) {
    $category = $database->find('categories', 'category_id', $_GET['key']);
    $catTitle = $category['title'];
}

if (isset($_POST['title'])) {
    $record = [
        'category_id' => $_POST['key'],
        'title' => $_POST['title']
    ];
    $database->update('categories', $record, 'category_id');
    header("Location: index.php?title=admin&option=editCategory");
}

ob_start();
?>

    <form action="index.php?title=admin&option=editCategory" method="post">
        <input type="hidden" name="key" value="<?php echo $_GET['key'] ?>">
        <label for="title">Category:</label>
        <input id="title" type="text" name="title" placeholder="Category title"
               value="<?php echo $catTitle; ?>">
        <input type="submit" name="submit" value="Edit category">
    </form>

<?php
$form = ob_get_clean();
if (isset($_GET['key'])) {
    echo $form;
}
