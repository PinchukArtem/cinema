<?php
require_once 'inc/db.php';

// Отримання даних для таблиці переглядів
$sql = "SELECT view_list_id, view_date, films.title, accounts.name 
        FROM view_list 
        JOIN films ON view_list.film_id = films.film_id 
        JOIN accounts ON view_list.user_id = accounts.account_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список переглядів</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Список переглядів</h1>

        <!-- Таблиця з переглядами -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Дата перегляду</th>
                    <th>Фільм</th>
                    <th>Користувач</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['view_list_id'] ?></td>
                            <td><?= $row['view_date'] ?></td>
                            <td><?= $row['title'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td>
                                <a href="actions/edit_view.php?id=<?= $row['view_list_id'] ?>">Редагувати</a>
                                <a href="actions/delete_view.php?id=<?= $row['view_list_id'] ?>" onclick="return confirm('Ви впевнені?')">Видалити</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">Дані відсутні</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Кнопка додавання -->
        <a href="actions/add_view.php" class="btn">Додати новий перегляд</a>
    </div>
</body>
</html>