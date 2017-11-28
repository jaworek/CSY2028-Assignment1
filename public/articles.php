<?php
$articles = findTest($pdo, 'articles');

foreach ($articles as $article) {
    echo "<article><h3>" . $article['title'] . "</h3><p>" . $article['content'] . "</p></article>";
}
