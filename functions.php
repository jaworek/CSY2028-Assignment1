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
            return $stmt->fetchall();
        }

        return $stmt->fetch();
    }

    public function findTest($table, $field = null, $value = null)
    {
        $query = 'SELECT * FROM ' . $table;
        if ($field != null && $value != null) {
            $query .= ' WHERE ' . $field . ' = :value';

            $criteria = [
              'value' => $value
            ];

            $stmt = $this->pdo->prepare($query);
            $stmt->execute($criteria);
            return $stmt->fetch();
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchall();
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
            $parameters[] = $key . ' = :' .$key;
            $query .= implode(', ', $parameters);
            $query .= ' WHERE ' . $primaryKey . ' = :primaryKey';
            $record['primaryKey'] = $record[$primaryKey];
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($record);
        }
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


// user profile functions
function changeEmail()
{
    if (isset($_POST['email'])) {
        echo "Email changed successfully";
        return;
    }
    echo '<form method="post"><input type="email" name="email" placeholder="Type in your new email"></input><input type="submit" name="Change"></input></form>';
}

function changePassword()
{
    if (isset($_POST['newPass']) && isset($_POST['newPass'])) {
        echo "Password changed successfully";
        return;
    }
    echo '<form method="post"><input type="password" name="oldPass" placeholder="Type in your old password"></input><input type="password" name="newPass" placeholder="Type in your new password"></input><input type="submit" name="Change"></input></form>';
}

function deleteAccount($database)
{
    if (isset($_POST['delete'])) {
        echo "Account deleted successfully";
        $database->delete('users', 'email', $_SESSION['email']);
        logout();
        return;
    }
    echo '<form method="post"><input type="submit" name="delete" value="Delete account"></input></form>';
}

// admin profile functions
