<?php

require_once __DIR__ . '/../src/db.php';

$page = $_GET['page'] ?? 'index';

ob_start();

switch ($page) {
    case 'create':
        require __DIR__ . '/../src/handlers/recipe/create.php';
        break;
    case 'edit':
        require __DIR__ . '/../src/handlers/recipe/edit.php';
        break;
    case 'delete':
        require __DIR__ . '/../src/handlers/recipe/delete.php';
        break;
    case 'show':
        require __DIR__ . '/../templates/recipe/show.php';
        break;
    default:
        require __DIR__ . '/../templates/index.php';
        break;
}

$content = ob_get_clean();
require __DIR__ . '/../templates/layout.php';
