<h3>Delete user</h3>
<?php
$users = $database->findAll('users');
listOptions( $users, ['email'], 'Delete', 'user_id');

if (isset($_GET['key']))
{
    echo '<p>Confirm deletion:</p>';
    echo '<a href="index.php?title=admin&option=deleteUser&key=' . $_GET['key'] . '&delete">Yes</a>';
    echo '<a href="index.php?title=admin&option=deleteUser">No</a>';
}

if (isset($_GET['delete']))
{
    deleteRow($database, 'users', 'user_id', 'deleteUser');
}
