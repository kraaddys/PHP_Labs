<?php

/**
 * Получает подключение к базе данных.
 *
 * @return PDO объект подключения к БД
 */
function getPDO(): PDO {
    $config = require __DIR__ . '/../config/db.php';

    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $config['username'], $config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
}
