<?php
require '../data/posts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';

    if (!$id || empty($title) || empty($content)) {
        exit('Ошибка: Неверные данные.');
    }

    // Обновляем пост в массиве
    if (isset($posts[$id - 1])) {
        $posts[$id - 1]['title'] = $title;
        $posts[$id - 1]['content'] = $content;

        // Сохраняем изменения в JSON
        file_put_contents('../data/posts.json', json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Перенаправляем на страницу поста
        header("Location: ../article.php?id=" . $id);
        exit;
    } else {
        exit('Ошибка: Пост не найден.');
    }
}
?>
