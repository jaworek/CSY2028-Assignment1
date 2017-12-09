<?php
listOptions($database, 'users', ['email'], 'Edit', 'email');

if (isset($_GET['key'])) {
  $user = $database->find('users', 'email', $_GET['key']);
  $email = $user['email'];
  $password = $user['password'];
}
?>

<form action="index.php?title=admin&option=editUser" method="post">
  <input type="text" name="email" value="<?php if(isset($email)) echo $email; ?>">
  <input type="text" name="password" value="<?php if(isset($password)) echo $password; ?>">
  <select name="accessLevel">
    <option value="user">User</option>
    <option value="user">Admin</option>
  </select>
  <input type="submit" name="submit">
</form>
