<?php
$articles = $database->findAll('articles');
listOptions( $articles, ['article_id', 'title'], 'Delete', 'article_id');
deleteRow($database, 'articles', 'article_id', 'deleteArticle');
