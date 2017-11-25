<form action="index.php?title=login" method="post">
  <label for="login">Email</label>
  <input id="login" type="email" name="login" placeholder="user@email.com">
  <label for="password">Password</label>
  <input id="password" type="password" name="password" placeholder="********">
  <input type="submit" name="button" value="Login">
</form>

<?php
if (isset($_POST['login']) && isset($_POST['password'])) {
    $row = find($pdo, 'users', 'email', $_POST['login']);

    if ($_POST['login'] == $row['email'] && $_POST['password'] == $row['password']) {
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
