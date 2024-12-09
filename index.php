<?php 
require_once 'inc/db.php'; 

// Отримання даних для таблиці
$sql = "SELECT films.film_id, films.title, films.genre, films.release_date, 
               films.director, site.name AS site_name 
        FROM films 
        JOIN site ON films.site_id = site.site_id"; 
$result = $conn->query($sql); 
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управління фільмами</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Управління фільмами</h1>
        <nav>
            <a href="accounts.php">Облікові записи</a>
            <a href="view_list.php">Перегляди</a>
            <a href="actions/add.php" class="btn">Дод ати новий фільм</a>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Список фільмів</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Назва</th>
                        <th>Жанр</th>
                        <th>Дата випуску</th>
                        <th>Режисер</th>
                        <th>Кінотеатр</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['film_id']) ?></td>
                                <td><?= htmlspecialchars($row['title']) ?></td>
                                <td><?= htmlspecialchars($row['genre']) ?></td>
                                <td><?= htmlspecialchars($row['release_date']) ?></td>
                                <td><?= htmlspecialchars($row['director']) ?></td>
                                <td><?= htmlspecialchars($row['site_name']) ?></td>
                                <td>
                                    <a href="actions/edit.php?id=<?= $row['film_id'] ?>">Редагувати</a>
                                    <a href="actions/delete.php?id=<?= $row['film_id'] ?>" onclick="return confirm('Ви впевнені?')">Видалити</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7">Дані відсутні</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Кінтеатр Прометей. Всі права захищені.</p>
    </footer>
</body>
</html>
