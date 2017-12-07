<section>

<?php
$articles = $database->findAll('articles');

foreach ($articles as $article) {
    try {
        $comments = $database->find('comments', 'article_id', $article['article_id'], true);
    } catch (Exception $e) {
        // $comments = "No comments";
        echo "No comments";
    }

    echo '<article>';
    echo '<h3>' . $article['title'] . '</h3>';
    echo '<p>' . $article['content'] . '</p>';
    echo '<h5>Comments: </h5>';
    if (isset($comments)) {
      echo '<ul>';
        foreach ($comments as $comment) {
            echo '<li>' . $comment['content'] . '</li>';
        }
      echo '</ul>';
    }
    echo '<form method=post>';
    echo '<textarea name="name"></textarea><input type="submit" name="Comment">';
    echo '</form>';
    echo '</article>';
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
