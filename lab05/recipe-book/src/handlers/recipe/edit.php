<?php

$pdo = getPDO();
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<p>ID рецепта не указан.</p>";
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("
        UPDATE recipes SET
            title = :title,
            category = :category,
            ingredients = :ingredients,
            description = :description,
            steps = :steps,
            tags = :tags
        WHERE id = :id
    ");

    $stmt->execute([
        'title' => $_POST['title'],
        'category' => $_POST['category'],
        'ingredients' => $_POST['ingredients'],
        'description' => $_POST['description'],
        'steps' => $_POST['steps'],
        'tags' => $_POST['tags'],
        'id' => $id
    ]);

    header("Location: index.php");
    exit;
}

require __DIR__ . '/../../../templates/recipe/edit.php';
