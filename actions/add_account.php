<?php 
require_once '../inc/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $name = trim($_POST['name']); 
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); 
    $password = $_POST['password']; 

    // Валідація
    if (empty($name) || empty($email) || empty($password)) {
        echo "Всі поля є обов'язковими.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Неправильний формат email.";
        exit;
    }

    // Перевірка наявності облікового запису з таким же email 
    $checkEmail = $conn->prepare("SELECT * FROM accounts WHERE email = ? "); 
    $checkEmail->bind_param("s", $email); 
    $checkEmail->execute(); 
    $result = $checkEmail->get_result(); 

    if ($result->num_rows > 0) { 
        echo "Обліковий запис з таким email вже існує."; 
    } else { 
        $stmt = $conn->prepare("INSERT INTO accounts (name, password, email, created_at) VALUES (?, ?, ?, NOW())"); 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Хешуємо пароль 
        $stmt->bind_param("sss", $name, $hashedPassword, $email); 

        if ($stmt->execute()) { 
            header("Location: ../accounts.php"); 
            exit; 
        } else { 
            echo "Помилка: " . $stmt->error; 
        } 
    } 
} 
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Додати обліковий запис</title>
</head>
<body>
    <form method="post">
        <label>Ім'я користувача:</label>
        <input type="text" name="name" required><br>
        <label>Пароль:</label>
        <input type="password" name="password" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <button type="submit">Додати</button>
    </form>
</body>
</html>