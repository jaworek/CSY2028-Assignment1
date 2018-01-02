<article>
  <h3>Register</h3>
<?php
register($database);
?>

<form class="login" action="index.php?title=register" method="post">
  <label for="login">Email</label>
  <input id="login" type="email" name="login" placeholder="user@email.com">
  <label for="login2">Repeat email</label>
  <input id="login2" type="email" name="login2" placeholder="user@email.com">
  <label for="password">Password</label>
  <input id="password" type="password" name="password" placeholder="********">
  <label for="password2">Repeat password</label>
  <input id="password2" type="password" name="password2" placeholder="********">
  <div class="g-recaptcha" data-sitekey="6Lca2j4UAAAAABUiGsB5g1QZy6L9XFtO9aoXK__u"></div>
  <input type="submit" name="button" value="Register">
</form>
</article>
