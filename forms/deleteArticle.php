<h3>Delete article</h3>
<?php
$articles = $database->findAll('articles');
listOptions( $articles, ['article_id', 'title'], 'Delete', 'article_id');

if (isset($_GET['key']))
{
    echo '<p>Confirm deletion:</p>';
    echo '<a href="index.php?title=admin&option=deleteArticle&key=' . $_GET['key'] . '&delete">Yes</a>';
    echo '<a href="index.php?title=admin&option=deleteArticle">No</a>';
}

if (isset($_GET['delete']))
{
    deleteRow($database, 'articles', 'article_id', 'deleteArticle');
}
