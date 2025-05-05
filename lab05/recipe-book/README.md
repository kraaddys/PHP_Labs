# Лабораторная работа №5. Работа с базой данных

## Цель работы

Цель данной лабораторной работы — научиться разрабатывать веб-приложение на PHP с использованием базы данных MySQL, реализовать архитектуру с единой точкой входа, подключением шаблонов для визуального оформления страниц, а также выполнить переход от хранения данных в файлах к работе с реляционной БД. Дополнительно — закрепить навыки по работе с PDO, защите от SQL-инъекций, созданию и редактированию записей (CRUD), а также применить стилизацию для улучшения интерфейса пользователя.

## Ход выполнения работы

### 1. Подготовка среды

Была установлена среда XAMPP, запущены модули Apache и MySQL. Через phpMyAdmin создана база данных `recipe_book`, а также таблицы `categories` и `recipes`. Таблицы имеют связь «один ко многим»: каждая категория может содержать несколько рецептов.

```sql
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE recipes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  category INT NOT NULL,
  ingredients TEXT,
  description TEXT,
  tags TEXT,
  steps TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category) REFERENCES categories(id) ON DELETE CASCADE
);
```

### 2. Структура проекта

Была создана следующая файловая структура с единым входом `index.php` и MVC-подобным разделением логики:

```
recipe-book/
├── public/index.php         — точка входа
├── src/
│   ├── db.php               — подключение к БД
│   ├── helpers.php          — вспомогательные функции
│   └── handlers/recipe/     — обработчики действий CRUD
├── config/db.php            — конфигурация БД
├── templates/
│   ├── layout.php           — базовый шаблон
│   ├── index.php            — главная страница (список рецептов)
│   └── recipe/              — представления: create, edit, show
└── README.md
```

### 3. Подключение к базе данных (PDO)

Файл `config/db.php` содержит массив с параметрами подключения:

```php
return [
    'host' => 'localhost',
    'dbname' => 'recipe_book',
    'username' => 'root',
    'password' => '',
];
```

В `src/db.php` реализована функция `getPDO()`, которая создаёт подключение к MySQL и выбрасывает исключение в случае ошибки:

```php
function getPDO(): PDO {
    $config = require __DIR__ . '/../config/db.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
    return new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
```

### 4. Архитектура и маршрутизация

Все HTTP-запросы обрабатываются через `public/index.php`, который анализирует параметр `page` и подключает нужный обработчик:

```php
$page = $_GET['page'] ?? 'index';
switch ($page) {
    case 'create': require 'src/handlers/recipe/create.php'; break;
    case 'edit': require 'src/handlers/recipe/edit.php'; break;
    case 'delete': require 'src/handlers/recipe/delete.php'; break;
    case 'show': require 'templates/recipe/show.php'; break;
    default: require 'templates/index.php';
}
```

### 5. Реализация CRUD-операций

#### Добавление рецепта

* `templates/recipe/create.php` содержит форму ввода рецепта.
* `src/handlers/recipe/create.php` обрабатывает POST-запрос и сохраняет данные через `prepare()` и `execute()`.

#### Отображение рецептов

* `templates/index.php` отображает список рецептов с кнопками «Изменить», «Удалить», «Открыть».
* Данные выбираются через JOIN из `recipes` и `categories`:

```php
SELECT recipes.*, categories.name AS category_name FROM recipes JOIN categories ON recipes.category = categories.id
```

#### Редактирование рецепта

* `templates/recipe/edit.php` — форма с заполненными полями.
* `src/handlers/recipe/edit.php` — обновление рецепта по ID.

#### Удаление рецепта

* `src/handlers/recipe/delete.php` удаляет запись по ID.

### 6. Шаблонизация

Главный шаблон `templates/layout.php` содержит общую структуру сайта: заголовки, меню, стили и контейнер для вставки `$content`.

```php
<?= $content ?>
```

Все представления (index, create, edit, show) рендерятся с помощью `ob_start()` и подставляются в шаблон.

### 7. Стилизация

В файл `layout.php` встроены адаптивные стили:

* переменные цвета через `:root`
* оформление ссылок, кнопок, форм, списков
* плавные hover-эффекты
* адаптация под мобильные устройства

### 8. Пагинация

На главной странице реализована пагинация по 5 рецептов:

```php
$page = $_GET['p'] ?? 1;
$limit = 5;
$offset = ($page - 1) * $limit;
```

Общее количество страниц рассчитывается и выводится внизу.

### 9. PHPDoc-документация

Функции снабжены PHPDoc-комментариями:

```php
/**
 * Подключение к базе данных
 * @return PDO
 */
```

---

## Ответы на контрольные вопросы

### 1. Какие преимущества даёт использование единой точки входа?

* Централизация логики приложения
* Простота маршрутизации
* Возможность централизованной авторизации/валидации
* Упрощённая защита от прямого доступа к внутренним файлам

### 2. Какие преимущества даёт использование шаблонов?

* Разделение логики и представления (MVC-подход)
* Повторное использование layout (например, меню, стили)
* Удобство поддержки интерфейса

### 3. Какие преимущества даёт хранение данных в базе по сравнению с файлами?

| Файлы              | База данных                        |
| ------------------ | ---------------------------------- |
| Сложный доступ     | Быстрые SQL-запросы                |
| Нет индексов       | Индексация по ключам               |
| Нет связей         | Внешние ключи и JOIN               |
| Мало масштабируемо | Масштабирование под большие данные |

### 4. Что такое SQL-инъекция? Как предотвратить?

SQL-инъекция — это уязвимость, при которой злоумышленник может вставить вредоносный SQL-код в поле формы или URL.

**Пример атаки** (небезопасно):

```php
$query = "SELECT * FROM recipes WHERE title = '$title'";
```

Если пользователь введёт `' OR 1=1 --`, будут возвращены все записи.

**Как мы защитились:**

```php
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE title = ?");
$stmt->execute([$title]);
```

Использование `prepare()` и `execute()` полностью защищает от инъекций.

---

## Вывод

В ходе лабораторной работы был создан полноценный мини-фреймворк на PHP:

* Архитектура с единой точкой входа
* Работа с базой данных через PDO
* CRUD-функциональность
* Адаптивный дизайн интерфейса
* Защита от SQL-инъекций
* Пагинация и шаблонизация

Проект пригоден для масштабирования — можно добавлять регистрацию пользователей, расширенные фильтры, API, комментарии и т.д.

## Источники

* [Официальная документация PHP по расширению PDO, которое предоставляет универсальный интерфейс для работы с базами данных.](https://www.php.net/manual/en/book.pdo.php)
* [Учебный материал, объясняющий наглядно работу с подготовленными выражениями в PHP с использованием MySQLi и PDO.](https://www.w3schools.com/php/php_mysql_prepared_statements.asp)
* [Подробное введение в уязвимость SQL-инъекций, примеры атак и способы защиты. MDN (Mozilla Developer Network) объясняет, почему важно использовать безопасные методы работы с БД, и как именно вредоносный ввод может повлиять на приложение, если не применяются подготовленные выражения.](https://developer.mozilla.org/en-US/docs/Learn/Server-side/SQL_injection)
* [Официальная справка по функции htmlspecialchars, которая используется для защиты от XSS-атак.](https://www.php.net/manual/en/function.htmlspecialchars.php)
