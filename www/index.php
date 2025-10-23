<?php
session_start();
require_once 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Библиотека - Главная</title>
    <style>
        .nav { margin: 20px 0; padding: 10px; background: #f5f5f5; }
        .nav a { margin-right: 15px; text-decoration: none; color: blue; }
        .info { border: 1px solid #ccc; padding: 15px; margin: 10px 0; }
        .api-data { background: #f0f8ff; padding: 15px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>📚 Библиотечная система + API 🚀</h1>
    
    <div class="nav">
    <a href="index.php">🏠 Главная</a>
    <a href="form.php">📝 Форма заявки</a>
    <a href="view.php">👁️ Просмотр заявок</a>
</div>

    <?php if(isset($_SESSION['form_data'])): ?>
    <div class="info">
        <h3>📋 Последняя заявка:</h3>
        <p><strong>👤 Имя:</strong> <?= htmlspecialchars($_SESSION['form_data']['username']) ?></p>
        <p><strong>🎟️ Номер билета:</strong> <?= htmlspecialchars($_SESSION['form_data']['ticket_number']) ?></p>
        <p><strong>📚 Жанр книги:</strong> <?= htmlspecialchars($_SESSION['form_data']['book_genre']) ?></p>
        <p><strong>💻 Электронная версия:</strong> <?= $_SESSION['form_data']['electronic_version'] ? 'Да' : 'Нет' ?></p>
        <p><strong>🗓️ Срок аренды:</strong> <?= htmlspecialchars($_SESSION['form_data']['rental_period']) ?></p>
    </div>
    <?php endif; ?>

    <?php if(isset($_SESSION['api_data'])): ?>
    <div class="api-data">
        <h3>🚀 Космические новости:</h3>
        <p><strong>Всего статей:</strong> <?= $_SESSION['api_data']['count'] ?? '0' ?></p>
        <?php unset($_SESSION['api_data']); ?>
    </div>
    <?php endif; ?>

    <!-- Информация о пользователе -->
    <div class="info">
        <h3>👤 Информация о пользователе:</h3>
        <?php
        $userInfo = UserInfo::getInfo();
        foreach ($userInfo as $key => $val) {
            echo "<p><strong>$key:</strong> " . htmlspecialchars($val) . "</p>";
        }
        ?>
    </div>

    <p><strong>📦 Composer:</strong> ✅ Установлен и работает!</p>
</body>
</html>