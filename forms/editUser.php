<?php
listOptions($database, 'users', ['email'], 'Edit', 'email');
$address = "index.php?title=admin&option=editUser";

if (isset($_GET['key'])) {
  $user = $database->find('users', 'email', $_GET['key']);
  $email = $user['email'];
  $password = $user['password'];
}
?>

<form action="<?php echo $address ?>" method="post">
  <input type="text" name="email" value="<?php if(isset($email)) echo $email; ?>">
  <input type="text" name="password" value="<?php if(isset($password)) echo $password; ?>">
  <select name="accessLevel">
    <option value="user">User</option>
    <option value="user">Admin</option>
  </select>
  <input type="submit" name="submit">
</form>
