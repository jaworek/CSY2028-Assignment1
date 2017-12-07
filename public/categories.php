<?php
if (isset($_GET['option'])) {
    echo "<h3>" . $_GET['option'] . "</h3>";
    $category = $database->find('categories', 'title', $_GET['option']);
    $articles = $database->find('articles', 'category_id', $category['category_id'], true); ?>

<section>

<?php
    foreach ($articles as $article) {
        echo "<article><h3>" . $article['title'] . "</h3><p>" . $article['content'] . "</p>";
        echo '<form method=post><textarea name="name"></textarea><input type="submit" name="Comment"></form>';
        echo "</article>";
    }
} else {
    $categories = $database->findAll('categories');
    echo "<ul>";
    foreach ($categories as $category) {
        echo '<li>' . $category['title'] . '</li>';
    }
    echo "</ul>";
}
?>

</section>
