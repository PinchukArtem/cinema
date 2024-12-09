<?php 
require_once '../inc/db.php'; 

$id = (int)$_GET['id']; // Приведення до цілого числа

// Перевірка наявності ID перед видаленням
if ($id <= 0) {
    echo "Неправильний ID.";
    exit;
}

$sql = "DELETE FROM view_list WHERE view_list_id = $id"; 

if ($conn->query($sql) === TRUE) { 
    header("Location: ../view_list.php"); 
    exit; 
} else { 
    echo "Error: " . $conn->error; 
} 

$conn->close(); 
?>

$conn->close();