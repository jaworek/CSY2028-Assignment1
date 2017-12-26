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
    <input type="text" name="title" placeholder="title">
    <textarea name="content" placeholder="content"></textarea>
    <input type="submit" name="submit" value="Add article">
</form>
