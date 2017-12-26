<?php
if (isset($_GET['option'])) {
    $category = $database->find('categories', 'title', $_GET['option']);
    $articles = $database->find('articles', 'category_id', $category['category_id'], true);

    echo '<section>';

    echo '<h3>' . $_GET['option'] . '</h3>';

    if (isset($_GET['key'])) {
        displayArticle($database, $articles);
    } else {
        listArticles($articles);
    }

} else {
    listCategories($database);
}
?>

</section>
