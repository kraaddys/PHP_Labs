<?php
$pdo = getPDO();

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<p>Рецепт не найден.</p>";
    return;
}

$stmt = $pdo->prepare("
    SELECT recipes.*, categories.name AS category_name
    FROM recipes
    LEFT JOIN categories ON recipes.category = categories.id
    WHERE recipes.id = ?
");

$stmt->execute([$id]);
$recipe = $stmt->fetch();

if (!$recipe) {
    echo "<p>Рецепт не найден.</p>";
    return;
}
?>

<h2><?= htmlspecialchars($recipe['title']) ?></h2>

<p><strong>Категория:</strong> <?= htmlspecialchars($recipe['category_name']) ?></p>
<p><strong>Ингредиенты:</strong><br><?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
<p><strong>Описание:</strong><br><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
<p><strong>Шаги:</strong><br><?= nl2br(htmlspecialchars($recipe['steps'])) ?></p>
<p><strong>Теги:</strong> <?= htmlspecialchars($recipe['tags']) ?></p>

<p><a href="index.php">Назад</a></p>
