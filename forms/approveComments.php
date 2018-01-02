<h3>Approve comments</h3>
<?php
$comments = $database->find('comments', 'approved', 'false', true);

if (count($comments) == 0) {
  echo '<p>There are no comments for approval.</p>';
} else {
   listOptions($comments, ['comment_id' ,'content'], 'Approve', 'comment_id');
}

if (isset($_GET['key']))
{
    $comment = $database->find('comments', 'comment_id', $_GET['key']);
    $record = [
        'comment_id' => $comment['comment_id'],
        'article_id' => $comment['article_id'],
        'user_id' => $comment['user_id'],
        'post_date' => $comment['post_date'],
        'content' => $comment['content'],
        'approved' => 'true',
    ];

    $database->update('comments', $record, 'comment_id');
    header("Location: index.php?title=admin&option=approveComments");
}
