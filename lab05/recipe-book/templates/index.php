<?php

$pdo = getPDO();

// Текущая страница из GET, по умолчанию — 1
$page = isset($_GET['p']) ? max((int)$_GET['p'], 1) : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Получение рецептов с учетом пагинации
$stmt = $pdo->prepare("
    SELECT recipes.*, categories.name AS category_name
    FROM recipes
    LEFT JOIN categories ON recipes.category = categories.id
    ORDER BY recipes.created_at DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Считаем общее количество рецептов
$total = $pdo->query("SELECT COUNT(*) FROM recipes")->fetchColumn();
$totalPages = ceil($total / $limit);
?>

<h2>Все рецепты</h2>

<?php if (empty($recipes)): ?>
    <p>Нет добавленных рецептов.</p>
<?php else: ?>
    <ul>
        <?php foreach ($recipes as $recipe): ?>
            <li>
                <strong><?= htmlspecialchars($recipe['title']) ?></strong> —
                <?= htmlspecialchars($recipe['category_name'] ?? 'Без категории') ?>
                |
                <a href="?page=show&id=<?= $recipe['id'] ?>">Открыть</a>
                |
                <a href="?page=edit&id=<?= $recipe['id'] ?>">Изменить</a>
                |
                <a href="?page=delete&id=<?= $recipe['id'] ?>" onclick="return confirm('Удалить рецепт?')">Удалить</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div>
        <strong>Страницы:</strong>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?p=<?= $i ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
<?php endif; ?>
