<?php
require_once '../inc/db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM view_list WHERE view_list_id = $id");
$view = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $film_id = (int)$_POST['film_id']; // Приведення до цілого числа
    $user_id = (int)$_POST['user_id']; // Приведення до цілого числа
    $view_date = $_POST['view_date'];

    // Валідація
    if (empty($film_id) || empty($user_id) || empty($view_date)) {
        echo "Всі поля є обов'язковими.";
        exit;
    }

    $stmt = $conn->prepare("UPDATE view_list SET film_id = ?, user_id = ?, view_date = ? WHERE view_list_id = ?");
    $stmt->bind_param("iisi", $film_id, $user_id, $view_date, $id);

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
    <title>Редагувати перегляд</title>
</head>
<body>
    <form method="post">
        <label>ID Фільму:</label>
        <input type="number" name="film_id" value="<?= $view['film_id'] ?>" required><br>
        <label>ID Користувача:</label>
        <input type="number" name="user_id" value="<?= $view['user_id'] ?>" required><br>
        <label>Дата перегляду:</label>
        <input type="date" name="view_date" value="<?= $view['view_date'] ?>" required><br>
        <button type="submit">Оновити</button>
    </form>
</body>
</html>