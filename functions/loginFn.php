<?php
function login($database)
{
    if (isset($_POST['submit'])) {
        $row = $database->find('users', 'email', $_POST['login']);

        if ($_POST['login'] != $row['email']) {
            echo '<p>Incorrect email.</p>';
            return;
        } else if (!password_verify($_POST['password'], $row['password'])) {
            echo '<p>Incorrect password.</p>';
            return;
        }

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

function register($database)
{
    $valuesSet = isset($_POST['login'], $_POST['login2'], $_POST['password'], $_POST['password2']);

    if ($valuesSet) {
        $exists = $database->find('users', 'email', $_POST['login']);
        $valuesEqual = $_POST['login'] == $_POST['login2'] && $_POST['password'] == $_POST['password2'];

        if (count($exists) > 1) {
            echo '<p>Account has already been created.</p>';
            return;
        } else if (!$valuesEqual) {
            echo "<p>Email or password are not matching.</p>";
            return;
        }

        $newUser = [
            'email' => $_POST['login'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];

        $database->insert('users', $newUser);
        echo "<p>Account has been successfully created.</p>";
    }
}