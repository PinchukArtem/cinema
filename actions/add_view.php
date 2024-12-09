<?php 
require_once '../inc/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $film_id = (int)$_POST['film_id']; // Приведення до цілого числа 
    $user_id = (int)$_POST['user_id']; // Приведення до цілого числа 
    $view_date = $_POST['view_date']; 

    // Валідація
    if (empty($film_id) || empty($user_id) || empty($view_date)) {
        echo "Всі поля є обов'язковими.";
        exit;
    }

    // Перевірка дати
    $date_format = 'Y-m-d';
    $d = DateTime::createFromFormat($date_format, $view_date);
    if (!$d || $d->format($date_format) !== $view_date) {
        echo "Неправильний формат дати.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO view_list (film_id, user_id, view_date) VALUES (?, ?, ?)"); 
    $stmt->bind_param("iis", $film_id, $user_id, $view_date); 

    if ($stmt->execute()) { 
        header("Location: ../view_list.php"); 
        exit; 
    } else { 
        echo "Помилка: " . $stmt->error; 
    } 
} 
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Додати перегляд</title>
</head>
<body>
    <form method="post">
        <label>ID Фільму:</label>
        <input type="number" name="film_id" required><br>
        <label>ID Користувача:</label>
        <input type="number" name="user_id" required><br>
        <label>Дата перегляду:</label>
        <input type="date" name="view_date" required><br>
        <button type="submit">Додати</button>
    </form>
</body>
</html>