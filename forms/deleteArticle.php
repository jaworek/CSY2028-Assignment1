<?php
listOptions($database, 'articles', ['article_id', 'title'], 'Delete', 'article_id');
deleteRow($database, 'articles', 'article_id', 'deleteArticle');
