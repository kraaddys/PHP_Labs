<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = getPDO();

    $stmt = $pdo->prepare("
        INSERT INTO recipes (title, category, ingredients, description, steps, tags)
        VALUES (:title, :category, :ingredients, :description, :steps, :tags)
    ");

    $stmt->execute([
        'title' => $_POST['title'],
        'category' => $_POST['category'],
        'ingredients' => $_POST['ingredients'],
        'description' => $_POST['description'],
        'steps' => $_POST['steps'],
        'tags' => $_POST['tags'],
    ]);

    header("Location: index.php");
    exit;
}

require __DIR__ . '/../../../templates/recipe/create.php';
