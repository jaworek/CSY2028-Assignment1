<h3>Add article</h3>
<?php
addArticle($database);
$categories = $database->findAll('categories');
?>

<form action="index.php?title=admin&option=addArticle" method="post">
    <label for="category">Category: </label>
    <select id="category" name="category_id">
        <?php
            foreach ($categories as $category)
            {
                echo '<option value="' . $category['category_id'] . '">' . $category['title'] . '</option>';
            }
        ?>
    </select>
    <label for="title">Title: </label>
    <input id="title" type="text" name="title" placeholder="title">
    <label for="content">Content: </label>
    <textarea id="content" name="content" placeholder="content" maxlength="5000"></textarea>
    <input type="submit" name="submit" value="Add article">
</form>
