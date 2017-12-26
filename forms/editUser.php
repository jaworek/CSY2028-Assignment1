<?php
listOptions($database, 'users', ['email'], 'Edit', 'user_id');

if (isset($_GET['key'])) {
  $user = $database->find('users', 'user_id', $_GET['key']);
}

if (isset($_POST['email'])) {
    echo 'bob';
    $record = [
        'user_id' => $user['user_id'],
        'email' => $_POST['email'],
        'password' => $user['password'],
        'access_level' => $_POST['access_level']
    ];
    $database->update('users', $record, 'user_id');
    header("Location: index.php?title=admin&option=editUser");
}

ob_start();
?>

<form action="index.php?title=admin&option=editUser" method="post">
  <input type="text" name="email" value="<?php echo $user['email']; ?>">
  <select name="access_level">
    <option <?php if ($user['access_level'] == 'user') { echo 'selected';} ?> value="user">User</option>
    <option <?php if ($user['access_level'] == 'admin') { echo 'selected';} ?> value="admin">Admin</option>
  </select>
  <input type="submit" name="submit">
</form>

<?php
$form = ob_get_clean();

if (isset($_GET['key'])) {
    echo $form;
}