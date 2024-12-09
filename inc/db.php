<?php
// Налаштування підключення до бази даних
$host = "localhost"; // або 127.0.0.1
$user = "root";      // ім'я користувача
$pass = "";          // пароль
$dbname = "cinema_db"; // назва бази даних

// Створення підключення
$conn = new mysqli($host, $user, $pass, $dbname);

// Перевірка підключення
if ($conn->connect_error) {
    die("Помилка підключення до бази даних: " . $conn->connect_error);
}

$conn->set_charset("utf8"); // Установка кодування
?>
