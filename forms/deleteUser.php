<?php
$users = $database->findAll('users');
listOptions( $users, ['email'], 'Delete', 'user_id');
deleteRow($database, 'users', 'user_id', 'deleteUser');