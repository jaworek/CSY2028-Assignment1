<?php
listOptions($database, 'articles', ['article_id', 'title'], 'Delete', 'article_id');

if (isset($_GET['key'])) {
    $database->delete('articles', 'article_id', $_GET['key']);
    header("Location: index.php?title=admin&option=deleteArticle");
}
