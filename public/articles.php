<section>

<?php
$articles = $database->findAll('articles');

foreach ($articles as $article) {
    echo "<article><h3>" . $article['title'] . "</h3><p>" . $article['content'] . "</p>";
    echo '<form method=post><textarea name="name"></textarea><input type="submit" name="Comment"></form>';
    echo "</article>";
}
?>

</section>

<?php

// Ask Tom how to properly generate html within a function

// foreach ($articles as $article) {
//     ob_start();
//
//     <article>
//       <h3> $article['title'] </h3>
//       <p> $article['content'] </p>
//     </article>
//
// $article = ob_get_clean();
// echo $article;
// }
