<?php 
require_once '../inc/db.php'; 

$id = (int)$_GET['id']; // Приведення до цілого числа

// Перевірка наявності ID перед видаленням
if ($id <= 0) {
    echo "Неправильний ID.";
    exit;
}

$stmt = $conn->prepare("DELETE FROM accounts WHERE account_id = ?"); 
$stmt->bind_param("i", $id); 

if ($stmt->execute()) { 
    header("Location: ../accounts.php"); 
    exit; 
} else { 
    echo "Error: " . $stmt->error; 
} 

$conn->close(); 
?>

$conn->close();