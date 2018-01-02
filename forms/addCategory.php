<h3>Add category</h3>
<?php
addCategory($database);
?>

<form action="index.php?title=admin&option=addCategory" method="post">
    <label for="title">Category: </label>
    <input id="title" type="text" name="title" placeholder="Category title">
    <input type="submit" name="submit" value="Add category">
</form>
