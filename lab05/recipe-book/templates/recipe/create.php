<?php
$pdo = getPDO();
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<h2>Добавить рецепт</h2>

<form action="?page=create" method="post">
    <label>Название:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Категория:</label><br>
    <select name="category" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Ингредиенты:</label><br>
    <textarea name="ingredients"></textarea><br><br>

    <label>Описание:</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Шаги приготовления:</label><br>
    <textarea name="steps"></textarea><br><br>

    <label>Теги:</label><br>
    <input type="text" name="tags"><br><br>

    <button type="submit">Сохранить</button>
</form>
