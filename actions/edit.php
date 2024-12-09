<?php 
require_once '../inc/db.php'; 

$id = (int)$_GET['id']; 
$result = $conn->query("SELECT * FROM films WHERE film_id = $id"); 
$film = $result->fetch_assoc(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $title = trim($_POST['title']); 
    $genre = trim($_POST['genre']); 
    $release_date = $_POST['release_date']; 
    $director = trim($_POST['director']); 
    $site_id = (int)$_POST['site_id']; // Приведення до цілого числа 

    // Валідація
    if (empty($title) || empty($genre) || empty($release_date) || empty($director) || empty($site_id )) {
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

    $stmt = $conn->prepare("UPDATE films SET title = ?, genre = ?, release_date = ?, director = ?, site_id = ?, updated_at = NOW() WHERE film_id = ?"); 
    $stmt->bind_param("ssssii", $title, $genre, $release_date, $director, $site_id, $id); 

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
    <title>Редагувати фільм</title>
</head>
<body>
    <form method="post">
        <label>Назва:</label>
        <input type="text" name="title" value="<?= $film['title'] ?>" required><br>
        <label>Жанр:</label>
        <input type="text" name="genre" value="<?= $film['genre'] ?>" required><br>
        <label>Дата випуску:</label>
        <input type="date" name="release_date" value="<?= $film['release_date'] ?>" required><br>
        <label>Режисер:</label>
        <input type="text" name="director" value="<?= $film['director'] ?>" required><br>
        <label>ID Кінотеатру:</label>
        <input type="number" name="site_id" value="<?= $film['site_id'] ?>" required><br>
        <button type="submit">Оновити</button>
    </form>
</body>
</html>
