<?php 
require_once '../inc/db.php'; 

$id = (int)$_GET['id']; 
$result = $conn->query("SELECT * FROM accounts WHERE account_id = $id"); 
$account = $result->fetch_assoc(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $name = trim($_POST['name']); 
    $password = $_POST['password']; 
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); 

    // Валідація
    if (empty($name) || empty($email) || empty($password)) {
        echo "Всі поля є обов'язковими.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Неправильний формат email.";
        exit;
    }

    // Хешування пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 

    $stmt = $conn->prepare("UPDATE accounts SET name = ?, password = ?, email = ? WHERE account_id = ?"); 
    $stmt->bind_param("sssi", $name, $hashedPassword, $email, $id); 

    if ($stmt->execute()) { 
        header("Location: ../accounts.php"); 
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
    <title>Редагувати обліковий запис</title>
</head>
<body>
    <form method="post">
        <label>Ім'я користувача:</label>
        <input type="text" name="name" value="<?= $account['name'] ?>" required><br>
        <label>Пароль:</label>
        <input type="password" name="password" value="<?= $account['password'] ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?= $account['email'] ?>" required><br>
        <button type="submit">Оновити</button>
    </form>
</body>
</html>
