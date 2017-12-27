<section>
    <h3>Articles</h3>
    <?php
    $articles = $database->findAll('articles');

    if (isset($_GET['key'])) {
        displayArticle($database, $_GET['key']);
    } else {
        listArticles($articles);
    }
    ?>

</section>
