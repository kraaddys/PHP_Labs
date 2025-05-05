<?php
$pdo = getPDO();
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<p>ID рецепта не указан.</p>";
    return;
}

$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->execute([$id]);
$recipe = $stmt->fetch();

if (!$recipe) {
    echo "<p>Рецепт не найден.</p>";
    return;
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<h2>Редактировать рецепт</h2>

<form action="?page=edit&id=<?= $id ?>" method="post">
    <label>Название:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($recipe['title']) ?>" required><br><br>

    <label>Категория:</label><br>
    <select name="category">
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $recipe['category'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Ингредиенты:</label><br>
    <textarea name="ingredients"><?= htmlspecialchars($recipe['ingredients']) ?></textarea><br><br>

    <label>Описание:</label><br>
    <textarea name="description"><?= htmlspecialchars($recipe['description']) ?></textarea><br><br>

    <label>Шаги:</label><br>
    <textarea name="steps"><?= htmlspecialchars($recipe['steps']) ?></textarea><br><br>

    <label>Теги:</label><br>
    <input type="text" name="tags" value="<?= htmlspecialchars($recipe['tags']) ?>"><br><br>

    <button type="submit">Сохранить изменения</button>
</form>
