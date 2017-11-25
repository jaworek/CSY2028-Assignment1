<?php
$articles = $pdo->query('SELECT * FROM articles');

foreach ($articles as $article) {
  echo "<article><h3>" . $article['title'] . "</h3><p>" . $article['content'] . "</p></article>";
}
