<?php 
require_once '../inc/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $title = trim($_POST['title']); 
    $genre = trim($_POST['genre']); 
    $release_date = $_POST['release_date']; 
    $director = trim($_POST['director']); 
    $site_id = (int)$_POST['site_id']; // Приведення до цілого числа 

    // Валідація
    if (empty($title) || empty($genre) || empty($release_date) || empty($director) || empty($site_id)) {
        echo "Всі поля є обов'язковими.";
        exit;
    }

    // Фільтрація
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $genre = filter_var($genre, FILTER_SANITIZE_STRING);
    $director = filter_var($director, FILTER_SANITIZE_STRING);
    
    // Перевірка дати
    $date_format = 'Y-m-d';
    $d = DateTime::createFromFormat($date_format, $release_date);
    if (!$d || $d->format($date_format) !== $release_date) {
        echo "Неправильний формат дати.";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO films (title, genre, release_date, director, site_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())"); 
    $stmt->bind_param("ssssi", $title, $genre, $release_date, $director, $site_id); 

    if ($stmt->execute()) { 
        header("Location: ../index.php"); 
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
    <title>Додати фільм</title>
</head>
<body>
    <form method="post">
        <label>Назва:</label>
        <input type="text" name="title" required><br>
        <label>Жанр:</label>
        <input type="text" name="genre" required><br>
        <label>Дата випуску:</label>
        <input type="date" name="release_date" required><br>
        <label>Режисер:</label>
        <input type="text" name="director" required><br>
        <label>ID Кінотеатру:</label>
        <input type="number" name="site_id" required><br>
        <button type="submit">Додати</button>
    </form>
</body>
</html>
