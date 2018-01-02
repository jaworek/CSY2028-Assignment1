    <?php
    $articles = $database->findAll('articles');

    if (isset($_GET['key'])) {
        displayArticle($database, $_GET['key']);
    } else {
        echo '<article>';
        echo '<h3>Articles</h3>';
        listArticles($database, $articles);
        echo '</article>';
    }
    ?>