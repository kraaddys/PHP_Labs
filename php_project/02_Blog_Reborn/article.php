<?php
define('APP_NAME', 'Blog');

require_once './data/posts.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

$post = isset($posts[$id - 1]) ? $posts[$id - 1] : null;

if (!$id || !$post) {
    header('HTTP/1.0 404 Not Found');
    exit('Пост не найден.');
}

require_once './components/header.php';

?>

<article class="container mx-auto mt-6">
    <div class="flex flex-col gap-4 px-8">
        <div id="categories" class="flex gap-2">
            <?php
            sort($post['categories']);
            foreach ($post['categories'] as $category): ?>
                <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded-md text-sm"><?php echo htmlspecialchars($category); ?></span>
            <?php endforeach; ?>
        </div>
        <h1 class="font-mono text-4xl font-bold"><?php echo htmlspecialchars($post['title']); ?></h1>
        <p><?php echo htmlspecialchars($post['content']); ?></p>
        <i class="text-gray-500"><?php echo htmlspecialchars($post['date']); ?></i>
        <div class="flex gap-2">
            <a href="article-edit.php?id=<?= urlencode($id) ?>" class="bg-blue-700 hover:bg-blue-700 text-white text-xl py-2 px-4 rounded">
                Edit Post
            </a>
            <a href="/" class="bg-blue-700 hover:bg-blue-700 text-white text-xl py-2 px-4 rounded">
                Back to Posts
            </a>
        </div>
    </div>
</article>


<?php require_once './components/footer.php'; ?>
