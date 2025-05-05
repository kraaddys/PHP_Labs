<?php

$pdo = getPDO();
$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM recipes WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
