<?php

function loadCategories($database)
{
    $results = $database->findAll('categories');
    echo '<ul class="categoryList">';
    foreach ($results as $row) {
        echo '<li><a href=index.php?title=categories&option=' . $row['title'] . '>' . $row['title'] . '</a></li>';
    }
    echo '</ul>';
}

function listArticles($database, $articles)
{
    for ($i = count($articles) - 1; $i >= 0; $i--) {
        $article = $articles[$i];
        $user = $database->find('users', 'user_id', $article['user_id']);

        echo '<div class="articleLink">';
        echo '<a href="index.php?title=articles&key=' . $article['article_id'] . '">';
        echo '<div>' . $article['title'] . '</div>';
        echo '<div>Author: ' . $user['email'] . '</div>';
        echo '<div>Date: ' . $article['post_date'] . '</div>';
        echo '</a>';
        echo '</div>';
    }

}

function displayArticle($database, $key)
{
    $article = $database->find('articles', 'article_id', $key);
    $comments = $database->find('comments', 'article_id', $article['article_id'], true);
    $user = $database->find('users', 'user_id', $article['user_id']);

//    source: https://stackoverflow.com/questions/6768793/get-the-full-url-in-php, access date: 27.12.2017
    $url = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

    echo '<article class="article">';
    echo '<h3>' . $article['title'] . '</h3>';
    echo '<p>Author: ' . $user['email'] . '</p>';
    echo '<p>' . $article['content'] . '</p>';

    echo '<h4>Share: </h4>';
    require '../forms/share.php';

    echo '<h4>Comments: </h4>';

    if ($comments != null) {
        echo '<ol>';
        foreach ($comments as $comment) {
            if ($comment['approved'] == 'false') {
                echo '<li>This comment needs to be approved by the admin.</li>';
            } else {
                $user = $database->find('users', 'user_id', $comment['user_id']);
                echo '<li>' . $comment['content'] . ' by ' . $user['email'] . ' on ' . $comment['post_date'] . '</li>';
            }
        }
        echo '</ol>';
    } else {
        echo '<p>No comments.</p>';
    }

    if (isset($_SESSION['email'])) {
        echo '<form action="index.php?title=articles&key=' . $key . '" method=post>';
        echo '<input hidden type="text" name="article_id" value="' . $article['article_id'] . '">';
        echo '<textarea name="content" maxlength="500"></textarea>';
        echo '<input type="submit" name="comment">';
        echo '</form>';
    } else {
        echo '<p>You need to <a href="index.php?title=login">log-in</a> or <a href="index.php?title=register">create an account</a> to be able to comment</p>';
    }

    echo '</article>';

    if (isset($_SESSION['email'])) {
        addComment($database, $key);
    }
}

function addComment($database, $key)
{
    if (isset($_POST['comment'])) {
        if (strlen($_POST['comment']))
        {
            echo '<p>Comment cannot be empty.</p>';
        }
        else
        {
            $newComment = [
                'article_id' => $_POST['article_id'],
                'user_id' => $_SESSION['user_id'],
                'content' => $_POST['content']
            ];
            $database->insert('comments', $newComment);
            header('Location: index.php?title=articles&key=' . $key);
        }
    }
}

function addLinks()
{
    if (isset($_SESSION['logged'])) {
        if ($_SESSION['logged'] == 'admin') {
            echo '<li><a href="index.php?title=admin">Admin</a></li>';
        } else {
            echo '<li><a href="index.php?title=profile">Profile</a></li>';
        }
        echo '<li><a href="index.php?title=logout">Logout</a></li>';
    } else {
        echo '<li><a href="index.php?title=login">Login</a></li>';
        echo '<li><a href="index.php?title=register">Register</a></li>';
    }
}

// database class
class Database
{
    public $pdo;

    public function __construct()
    {
        $this->pdo = $this->connect();
    }

    public function connect()
    {
        $server = 'v.je';
        $username = 'student';
        $password = 'student';
        $schema = 'assign';
        $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        return $pdo;
    }

    public function disconnect()
    {
        $pdo = null;
    }

    // query functions
    // functions are provided by Thomas Butler with slight changes made by the author of the project, 2017
    public function find($table, $field, $value, $many = null)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $table . ' WHERE ' . $field . ' = :value');

        $criteria = [
            'value' => $value
        ];

        $stmt->execute($criteria);

        if ($many != null) {
            return $stmt->fetchAll();
        }

        return $stmt->fetch();
    }

    public function findAll($table)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $table);

        $stmt->execute();

        return $stmt->fetchall();
    }

    public function update($table, $record, $primaryKey)
    {
        $query = 'UPDATE ' . $table . ' SET ';
        $parameters = [];
        foreach ($record as $key => $value) {
            $parameters[] = $key . ' = :' . $key;
        }
        $query .= implode(', ', $parameters);
        $query .= ' WHERE ' . $primaryKey . ' = :primaryKey';
        $record['primaryKey'] = $record[$primaryKey];
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($record);
    }

    public function insert($table, $record)
    {
        $keys = array_keys($record);

        $values = implode(', ', $keys);
        $valuesWithColon = implode(', :', $keys);

        $query = 'INSERT INTO ' . $table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';

        $stmt = $this->pdo->prepare($query);

        $stmt->execute($record);
    }

    public function delete($table, $field, $value)
    {
        $stmt = $this->pdo->prepare('DELETE FROM ' . $table . ' WHERE ' . $field . ' = :value');
        $criteria = [
            'value' => $value
        ];
        $stmt->execute($criteria);
    }
}

// general functions
function isLogged()
{
    if (isset($_SESSION['logged'])) {
        header("Location: index.php");
    }
}

function checkCaptcha()
{
    $captchaKey = '6Lca2j4UAAAAAM_Z2SBGht3ZfEGJxbCchw7KGkQL';
    $checkKey = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $captchaKey . '&response=' . $_POST['g-recaptcha-response']);
    $getAnswer = json_decode($checkKey);
    return $getAnswer->success;
}

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
        } else if (!checkCaptcha()) {
            echo '<p>Confirm that you are not a robot.</p>';
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

function logout()
{
    if (isset($_SESSION['user_id'])) {
        session_destroy();
    }

    header("Location: index.php");
}

function register($database)
{
    $valuesSet = isset($_POST['email'], $_POST['email2'], $_POST['password'], $_POST['password2']);

    if ($valuesSet) {
        $exists = $database->find('users', 'email', $_POST['email']);
        $valuesEqual = $_POST['email'] == $_POST['email2'] && $_POST['password'] == $_POST['password2'];

//        email sanitization tutorial: https://www.youtube.com/watch?v=fMJw90n8M60&index=4&list=PLOYHgt8dIdox81dbm1JWXQbm2geG1V2uh, 02.01.2017
        $sanitizedEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || $_POST['email'] != $sanitizedEmail) {
            echo '<p>Entered email is not valid</p>';
            return;
        } else if (count($exists) > 1) {
            echo '<p>Account has already been created.</p>';
            return;
        } else if (!$valuesEqual) {
            echo "<p>Email or password are not matching.</p>";
            return;
        } else if (!checkCaptcha()) {
            echo '<p>Confirm that you are not a robot.</p>';
            return;
        }

        $newUser = [
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];

        $database->insert('users', $newUser);
        echo "<p>Account has been successfully created.</p>";
    }
}

// user profile functions
function changeEmail($database)
{
    echo '<h3>Change email</h3>';
    if (isset($_POST['email']) && isset($_POST['email2'])) {
        if ($_POST['email'] == $_POST['email2']) {
            $user = $database->find('users', 'user_id', $_SESSION['user_id']);
            $record = [
                'user_id' => $user['user_id'],
                'email' => $_POST['email'],
                'password' => $user['password'],
                'access_level' => $user['access_level']
            ];
            $database->update('users', $record, 'user_id');
            echo "<p>Email changed successfully</p>";
        } else {
            echo '<p>Emails do not match.</p>';
        }
    }

    echo '<form action="index.php?title=profile&option=email" method="post">';
    echo '<input type="email" name="email" placeholder="Type in your new email">';
    echo '<input type="email" name="email2" placeholder="Repeat your new email">';
    echo '<input type="submit" name="Change">';
    echo '</form>';
}

function changePassword($database)
{
    echo '<h3>Change password</h3>';

    if (isset($_POST['newPass']) && isset($_POST['newPass2'])) {
        if ($_POST['newPass'] == $_POST['newPass2']) {
            echo "Password changed successfully";
        } else {
            echo 'Passwords do not match.';
        }
        return;
    }

    echo '<form action="index.php?title=profile&option=password" method="post">';
    echo '<input type="password" name="newPass" placeholder="Type in your new password">';
    echo '<input type="password" name="newPass2" placeholder="Type in your new password again">';
    echo '<input type="submit" name="Change">';
    echo '</form>';
}

function deleteAccount($database)
{
    echo '<h3>Delete account</h3>';

    if (isset($_POST['delete'])) {
        echo '<p>Confirm deletion:</p>';
        echo '<a href="index.php?title=profile&option=delete&yes">Yes</a>';
        echo '<a href="index.php?title=profile&option=delete">No</a>';
        return;
    }

    if (isset($_GET['yes'])) {
        echo "Account deleted successfully";
        $database->delete('users', 'email', $_SESSION['email']);
        logout();
    }

    echo '<form method="post"><input type="submit" name="delete" value="Delete account"></form>';
}

// admin profile functions
function addArticle($database)
{
    if (isset($_POST['category_id'], $_POST['title'], $_POST['content'])) {
        if (strlen($_POST['title']) == 0 || strlen($_POST['content']) == 0) {
            echo '<p>Title or content cannot be empty.</p>';
        } else {
            $newArticle = [
                'category_id' => $_POST['category_id'],
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'user_id' => $_SESSION['user_id']
            ];
            $database->insert('articles', $newArticle);
        }
    }
}

function addCategory($database)
{
    if (isset($_POST['title'])) {
        $database->insert('categories', ['title' => $_POST['title']]);
    }
}

function editUser($database, $user)
{
    if (isset($_POST['email'])) {
        $record = [
            'user_id' => $user['user_id'],
            'email' => $_POST['email'],
            'password' => $user['password'],
            'access_level' => $_POST['access_level']
        ];
        $database->update('users', $record, 'user_id');
        header("Location: index.php?title=admin&option=editUser");
    }
}

function editArticle($database, $article)
{
    if (isset($_POST['title'])) {
        $record = [
            'article_id' => $article['article_id'],
            'category_id' => $_POST['category_id'],
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'user_id' => $article['user_id'],
            'post_date' => $article['post_date']
        ];
        $database->update('articles', $record, 'article_id');
        header("Location: index.php?title=admin&option=editArticle");
    }
}

function editCategory($database)
{
    if (isset($_POST['title'])) {
        $record = [
            'category_id' => $_POST['key'],
            'title' => $_POST['title']
        ];
        $database->update('categories', $record, 'category_id');
        header("Location: index.php?title=admin&option=editCategory");
    }
}

function deleteRow($database, $table, $primaryKey, $redirect)
{
    if (isset($_GET['key'])) {
        $database->delete($table, $primaryKey, $_GET['key']);
        header("Location: index.php?title=admin&option=" . $redirect);
    }
}

// function that provides list of elements with applicable option to execute, e.g. delete user, edit article
function listOptions($elements, $columns, $function, $primaryKey)
{
//    $elements = $database->findAll($table);

    echo '<table>';
    foreach ($elements as $element) {
        echo '<tr>';
        foreach ($columns as $value) {
            echo '<td>' . $element[$value] . '</td>';
        }
        echo '<td><a href="index.php?title=admin&option=' . $_GET['option'] . '&key=' . $element[$primaryKey] . '">' . $function . '</a></td></tr>';
    }
    echo '</table>';
}
