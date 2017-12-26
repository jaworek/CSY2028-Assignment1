<?php
listOptions($database, 'categories', ['title'], 'Delete', 'category_id');
deleteRow($database, 'categories', 'category_id', 'deleteCategory');