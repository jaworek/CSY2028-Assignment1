<article>
<?php
if (isset($_GET['option'])) {
    $category = $database->find('categories', 'title', $_GET['option']);
    $articles = $database->find('articles', 'category_id', $category['category_id'], true);

    echo '<h3>' . $_GET['option'] . '</h3>';

    if (isset($_GET['key'])) {
        displayArticle($database, $articles);
    } else {
        listArticles($database, $articles);
    }

} else {
    echo '<h3>Categories</h3>';
    loadCategories($database);
}
?>
</article>
