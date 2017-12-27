<?php
$categories = $database->findAll('categories');
listOptions($categories, ['title'], 'Delete', 'category_id');
deleteRow($database, 'categories', 'category_id', 'deleteCategory');