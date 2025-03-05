<?php
require 'data/posts.php';
require_once './components/button.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

// Проверяем, есть ли ID и пост с таким ID
if (!$id || !isset($posts[$id - 1])) {
    exit('Ошибка: Пост не найден.');
}

$post = $posts[$id - 1];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование поста</title>
    <link rel="stylesheet" href="assets/styles/output.css"> <!-- Tailwind -->
</head>
<body class="bg-gray-100 font-sans">

<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">Change post</h2>

    <form action="handlers/post-update.php" method="post" class="flex flex-col gap-4">
    <input type="hidden" name="id" value="<?= $id ?>">

    <div>
        <label class="block font-medium">Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>"
               class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    <div>
        <label class="block font-medium">Content:</label>
        <textarea name="content" rows="5"
                  class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required><?= htmlspecialchars($post['content']) ?></textarea>
    </div>

    <div class="flex gap-2">
        <?php renderButton("#", "Save changes", "bg-blue-700", "normal", "cursor-pointer", true); ?>
        <?php renderButton("article.php?id=$id", "Cancel", "bg-gray-500", "cursor-pointer", "normal"); ?>
    </div>
</form>

</div>

</body>
</html>
