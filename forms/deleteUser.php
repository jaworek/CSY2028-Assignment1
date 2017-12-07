<?php
listOptions($database, 'users', ['email'], 'Delete', 'email');

if (isset($_GET['key'])) {
    $database->delete('users', 'email', $_GET['key']);
    header("Location: index.php?title=admin&option=deleteUser");
}
