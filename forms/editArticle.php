<h3>Edit article</h3>
<?php
$articles = $database->findAll('articles');
listOptions( $articles, ['article_id', 'title'], 'Edit', 'article_id');
$categories = $database->findAll('categories');

if (isset($_GET['key'])) {
    $article = $database->find('articles', 'article_id', $_GET['key']);
    editArticle($database, $article);
}

ob_start();
?>

    <form action="index.php?title=admin&option=editArticle&key=<?php echo $_GET['key']; ?>" method="post">
        <label for="category">Category: </label>
        <select id="category" name="category_id">
            <?php
            foreach ($categories as $category) {
                echo '<option ';
                if ($category['category_id'] == $article['category_id']) {
                    echo 'selected ';
                }
                echo 'value="' . $category['category_id'] . '">' . $category['title'] . '</option>';
            }
            ?>
        </select>
        <input type="text" name="title" placeholder="title" value="<?php echo $article['title']; ?>">
        <textarea name="content" placeholder="content" maxlength="5000"><?php echo $article['content']; ?></textarea>
        <input type="submit" name="submit" value="Edit article">
    </form>

<?php
$form = ob_get_clean();

if (isset($_GET['key'])) {
    echo $form;
}
?>
