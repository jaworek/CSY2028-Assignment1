<?php

function createNavbar()
{
}

function loadCategories($pdo)
{
    $results = $pdo->query('SELECT title FROM categories;');
    foreach ($results as $row) {
        echo '<li><a href=categories.php?title="' . $row['title'] . '">' . $row['title'] . '</a></li>';
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

function connect()
{
    $server = 'v.je';
    $username = 'student';
    $password = 'student';
    $schema = 'assign';
    $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    return $pdo;
}

function disconnect($pdo)
{
    $pdo = null;
}

// function based on the slides provided by Thomas Butler, 2017
function find($pdo, $table, $field, $value)
{
    $stmt = $pdo->prepare('SELECT * FROM ' . $table . ' WHERE ' . $field . ' = :value');
    $criteria = [
    'value' => $value
  ];
    $stmt->execute($criteria);

    return $stmt->fetch();
}

function findAll($pdo, $table)
{
  $stmt = $pdo->prepare('SELECT * FROM ' . $table);

  $stmt->execute();

  return $stmt->fetch();
}

function update($pdo, $table, $record, $primaryKey)
{
    $query = 'UPDATE ' . $table . ' SET ';
    $parameters = [];
    foreach ($record as $key => $value) {
        $parameters[] = $key . ' = :' .$key;
        $query .= implode(', ', $parameters);
        $query .= ' WHERE ' . $primaryKey . ' = :primaryKey';
        $record['primaryKey'] = $record[$primaryKey];
        $stmt = $pdo->prepare($query);
        $stmt->execute($record);
    }
}

function insert($pdo, $table, $record)
{
    $keys = array_keys($record);

    $values = implode(', ', $keys);
    $valuesWithColon = implode(', :', $keys);

    $query = 'INSERT INTO ' . $table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';

    $stmt = $pdo->prepare($query);

    $stmt->execute($record);
}

function delete($pdo, $table, $record)
{
    $stmt = $pdo->prepare('DELETE FROM ' . $table . ' WHERE ' . $field . ' = :value');
    $criteria = [
    'value' => $value
  ];
    $stmt->execute($criteria);

    return $stmt->fetch();
}
