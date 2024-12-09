<?php 
require_once 'inc/db.php'; 

// Отримання даних для таблиці облікових записів
$sql = "SELECT account_id, name, email, created_at FROM accounts"; 
$result = $conn->query($sql); 
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список облікових записів</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Список облікових записів</h1>

        <!-- Таблиця з обліковими записами -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ім'я користувача</th>
                    <th>Email</th>
                    <th>Дата створення</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['account_id']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <a href="actions/edit_account.php?id=<?= $row['account_id'] ?>">Редагувати</a>
                                <a href="actions/delete_account.php?id=<?= $row['account_id'] ?>" onclick="return confirm('Ви впевнені?')">Видалити</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">Дані відсутні</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Кнопка додавання -->
        <a href="actions/add_account.php" class="btn">Додати новий обліковий запис</a>
    </div>
</body>
</html>
