<?php
listOptions($database, 'users', ['email'], 'Delete', 'email');
deleteRow($database, 'users', 'email', 'deleteUser');