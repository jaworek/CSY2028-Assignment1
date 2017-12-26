<?php
addCategory($database);
?>

<form action="index.php?title=admin&option=addCategory" method="post">
    <input type="text" name="title" placeholder="Category title">
    <input type="submit" name="submit" value="Add category">
</form>
