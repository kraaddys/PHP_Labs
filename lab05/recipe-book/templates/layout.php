<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Книга рецептов</title>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --success: #27ae60;
            --danger: #e74c3c;
            --bg-light: #f4f7f9;
            --text-dark: #333;
            --border-color: #dcdcdc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 40px;
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        h1 a {
            text-decoration: none;
            color: var(--primary);
        }

        nav {
            margin-bottom: 20px;
        }

        nav a {
            display: inline-block;
            margin-right: 15px;
            text-decoration: none;
            color: var(--secondary);
            font-weight: bold;
            padding: 6px 10px;
            border-radius: 4px;
            transition: 0.3s;
        }

        nav a:hover {
            background-color: var(--secondary);
            color: white;
        }

        a {
            color: var(--secondary);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        ul {
            padding-left: 20px;
        }

        li {
            margin-bottom: 12px;
            padding: 10px;
            background: white;
            border-left: 5px solid var(--primary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        form {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            max-width: 700px;
            margin-top: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
            background: #fcfcfc;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        button {
            background-color: var(--success);
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #219150;
        }

        .pagination {
            margin-top: 25px;
        }

        .pagination a {
            display: inline-block;
            margin: 0 5px;
            padding: 8px 14px;
            border: 1px solid var(--border-color);
            background: #fff;
            border-radius: 4px;
        }

        .pagination a:hover {
            background: var(--secondary);
            color: #fff;
        }

        .message {
            padding: 15px;
            background-color: #eafaf1;
            border-left: 5px solid var(--success);
            margin-bottom: 20px;
        }

        .danger {
            color: var(--danger);
        }

        hr {
            margin: 30px 0;
        }

        @media (max-width: 768px) {
            body {
                padding: 20px;
            }

            form {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <h1><a href="/lab05/recipe-book/public/index.php">Книга рецептов</a></h1>
    <nav>
        <a href="?page=index">Главная</a>
        <a href="?page=create">Добавить рецепт</a>
    </nav>
    <hr>
    <?= $content ?>
</body>
</html>
