<?php

// navigation bar functions
function createNavbar()
{
}

function loadCategories($database)
{
    $results = $database->findAll('categories');
    foreach ($results as $row) {
        echo '<li><a href=index.php?title=categories&option=' . $row['title'] . '>' . $row['title'] . '</a></li>';
    }
}

function listCategories($database)
{
    $categories = $database->findAll('categories');
    echo "<ul>";
    foreach ($categories as $category) {
        echo '<li>' . $category['title'] . '</li>';
    }
    echo "</ul>";
}

function listArticles($articles)
{
    echo '<table>';
    foreach ($articles as $article) {
        echo '<tr>';
        echo '<td><a href="index.php?title=articles&key=' . $article['article_id'] . '">' . $article['title'] . '</a></td></tr>';
    }
    echo '</table>';
}

function displayArticle($database, $key)
{
    $article = $database->find('articles', 'article_id', $key);
    $comments = $database->find('comments', 'article_id', $article['article_id'], true);

    echo '<article>';
    echo '<h3>' . $article['title'] . '</h3>';
    echo '<p>' . $article['content'] . '</p>';
    echo '<h5>Comments: </h5>';

    if ($comments != null) {
        echo '<ul>';
        foreach ($comments as $comment) {
            echo '<li>' . $comment['content'] . '</li>';
        }
        echo '</ul>';
    } else {
        echo 'No comments<br><br>';
    }

    if (isset($_SESSION['email'])) {
        echo '<form action="index.php?title=articles&key=' . $key . '" method=post>';
        echo '<input hidden type="text" name="article_id" value="' . $article['article_id'] . '">';
        echo '<textarea name="content"></textarea>';
        echo '<input type="submit" name="comment">';
        echo '</form>';
    } else {
        echo 'You need to <a href="index.php?title=login">Log-in</a> or You need to <a href="index.php?title=register">create an account</a> to be able to comment';
    }

    echo '</article>';

    if (isset($_SESSION['email'])) {
        addComment($database, $key);
    }
}

function addComment($database, $key)
{
    if (isset($_POST['comment'])) {
        $newComment = [
            'article_id' => $_POST['article_id'],
            'user_id' => $_SESSION['user_id'],
            'content' => $_POST['content']
        ];
        $database->insert('comments', $newComment);
        header('Location: index.php?title=articles&key=' . $key);
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
    // functions are based on the slides provided by Thomas Butler, 2017
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

function logout()
{
    if (isset($_SESSION['logged'])) {
        session_destroy();
    }

    header("Location: index.php");
}

function register($database)
{
    $valuesSet = isset($_POST['login'], $_POST['login2'], $_POST['password'], $_POST['password2']);

    if ($valuesSet) {
        $valuesEqual = $_POST['login'] == $_POST['login2'] && $_POST['password'] == $_POST['password2'];

        if ($valuesEqual) {
            $newUser = [
                'email' => $_POST['login'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
            ];

            $database->insert('users', $newUser);
            echo "Account has been successfully created";
        } else {
            echo "Email or password are not matching";
        }
    }
}


// user profile functions
function changeEmail()
{
    if (isset($_POST['email'])) {
        echo "Email changed successfully";
        return;
    }

    echo '<form method="post">';
    echo '<input type="email" name="email" placeholder="Type in your new email">';
    echo '<input type="email" name="email2" placeholder="Repeat your new email">';
    echo '<input type="submit" name="Change">';
    echo '</form>';
}

function changePassword()
{
    if (isset($_POST['newPass']) && isset($_POST['newPass'])) {
        echo "Password changed successfully";
        return;
    }

    echo '<form method="post">';
    echo '<input type="password" name="oldPass" placeholder="Type in your old password">';
    echo '<input type="password" name="newPass" placeholder="Type in your new password">';
    echo '<input type="password" name="newPass2" placeholder="Type in your new password again">';
    echo '<input type="submit" name="Change">';
    echo '</form>';
}

function deleteAccount($database)
{
    if (isset($_POST['delete'])) {
        echo "Account deleted successfully";
        $database->delete('users', 'email', $_SESSION['email']);
        logout();
        return;
    }

    echo '<form method="post"><input type="submit" name="delete" value="Delete account"></form>';
}

// admin profile functions
function addArticle($database)
{
    if (isset($_POST['category_id'], $_POST['title'], $_POST['content'])) {
        $newArticle = [
            'category_id' => $_POST['category_id'],
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'user_id' => $_SESSION['user_id']
        ];
        $database->insert('articles', $newArticle);
    }
}

function addCategory($database)
{
    if (isset($_POST['title'])) {
        $database->insert('categories', ['title' => $_POST['title']]);
    }
}

function editUser($database)
{
    if (isset($_GET['key'])) {
        $user = $database->find('users', 'email', $_GET['key']);
        $email = $user['email'];
        $password = $user['password'];
    }
}

function editArticle($database)
{
    if (isset($_GET['key'])) {
        $article = $database->find('articles', 'article_id', $_GET['key']);
        $category_id = $article['article_id'];
        $artTitle = $article['title'];
        $content = $article['content'];
    }
}

function editCategory($database)
{
    if (isset($_GET['key'])) {
        $category = $database->find('categories', 'category_id', $_GET['key']);
        $catTitle = $category['title'];
    }
}

function deleteRow($database, $table, $primaryKey, $redirect)
{
    if (isset($_GET['key'])) {
        $database->delete($table, $primaryKey, $_GET['key']);
        header("Location: index.php?title=admin&option=" . $redirect);
    }
}

// function that provides list of elements with aplicable option to execute, e.g. delete user, edit article
function listOptions($database, $table, $columns, $function, $primaryKey)
{
    $elements = $database->findAll($table);

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
