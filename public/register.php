<?php
isLogged();

$valuesSet = isset($_POST['login'], $_POST['login2'], $_POST['password'], $_POST['password2']);

if ($valuesSet) {
    $valuesEqual = $_POST['login'] == $_POST['login2'] && $_POST['password'] == $_POST['password2'];

    if ($valuesEqual) {
        $newUser = [
          'email' => $_POST['login'],
          'password' => $_POST['password']
        ];

        $database->insert('users', $newUser);
        echo "account created";
    } else {
        echo "not matching";
    }
}
?>

<form action="index.php?title=register" method="post">
  <label for="login">Email</label>
  <input id="login" type="email" name="login" placeholder="user@email.com">
  <label for="login2">Repeat email</label>
  <input id="login2" type="email" name="login2" placeholder="user@email.com">
  <label for="password">Password</label>
  <input id="password" type="password" name="password" placeholder="********">
  <label for="password2">Repeat password</label>
  <input id="password2" type="password" name="password2" placeholder="********">
  <input type="submit" name="button" value="Login">
</form>
