<form action="index.php?title=login" method="post">
  <label for="login">Email</label>
  <input id="login" type="email" name="login" placeholder="user@email.com">
  <label for="password">Password</label>
  <input id="password" type="password" name="password" placeholder="********">
  <input type="submit" name="button" value="Login">
</form>

<?php
isLogged();

if (isset($_POST['login']) && isset($_POST['password'])) {
    $row = $database->find('users', 'email', $_POST['login']);

    if ($_POST['login'] == $row['email'] && password_verify($_POST['password'], $row['password'])) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['email'] = $row['email'];
        if ($row['access_level'] == 'admin') {
            $_SESSION['logged'] = 'admin';
            header("Location: index.php?title=admin");
            exit();
        } else {
            $_SESSION['logged'] = 'user';
            header("Location: index.php?title=home");
            exit();
        }
    }
}
