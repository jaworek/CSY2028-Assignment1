<h3>Edit user</h3>
<?php
$users = $database->findAll('users');
listOptions( $users, ['email'], 'Edit', 'user_id');

if (isset($_GET['key'])) {
  $user = $database->find('users', 'user_id', $_GET['key']);
  editUser($database, $user);
}

ob_start();
?>

<form action="index.php?title=admin&option=editUser&key=<?php echo $_GET['key'] ?>" method="post">
    <label for="email">Email</label>
    <input id="email" type="text" name="email" value="<?php echo $user['email']; ?>">
    <label for="access_level">Access level</label>
    <select id="access_level" name="access_level">
    <option <?php if ($user['access_level'] == 'user') { echo 'selected'; } ?> value="user">User</option>
    <option <?php if ($user['access_level'] == 'admin') { echo 'selected'; } ?> value="admin">Admin</option>
  </select>
  <input type="submit" name="submit">
</form>

<?php
$form = ob_get_clean();

if (isset($_GET['key'])) {
    echo $form;
}
