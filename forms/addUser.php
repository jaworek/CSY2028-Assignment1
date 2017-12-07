<?php
register($database);
?>

<form action="index.php?title=admin&option=addUser" method="post">
  <label for="login">Email</label>
  <input id="login" type="email" name="login" placeholder="user@email.com">
  <label for="login2">Repeat email</label>
  <input id="login2" type="email" name="login2" placeholder="user@email.com">
  <label for="password">Password</label>
  <input id="password" type="password" name="password" placeholder="********">
  <label for="password2">Repeat password</label>
  <input id="password2" type="password" name="password2" placeholder="********">
  <input type="submit" name="button" value="Register">
</form>
