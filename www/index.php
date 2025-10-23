<?php
session_start();
require_once 'vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Библиотека - Главная</title>
    <style>
        .api-data, .user-info, .session-data {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .api-data { background-color: #f0f8ff; }
        .user-info { background-color: #fff0f5; }
        .session-data { background-color: #f0fff0; }
        .article { background-color: #fffacd; padding: 10px; margin: 10px 0; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>📚 Библиотечная система + Космические новости 🚀</h1>
    
    <!-- Вывод ошибок -->
    <?php if(isset($_SESSION['errors'])): ?>
        <div class="error">
            <h3>❌ Ошибки:</h3>
            <ul>
                <?php foreach($_SESSION['errors'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <!-- Вывод успешного сообщения -->
    <?php if(isset($_SESSION['success'])): ?>
        <div class="success">
            <p>✅ <?= htmlspecialchars($_SESSION['success']) ?></p>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Вывод данных из сессии -->
    <?php if(isset($_SESSION['form_data'])): ?>
        <div class="session-data">
            <h3>📋 Последняя заявка:</h3>
            <p><strong>👤 Имя:</strong> <?= htmlspecialchars($_SESSION['form_data']['username']) ?></p>
            <p><strong>🎟️ Номер билета:</strong> <?= htmlspecialchars($_SESSION['form_data']['ticket_number']) ?></p>
            <p><strong>📚 Жанр книги:</strong> <?= htmlspecialchars($_SESSION['form_data']['book_genre']) ?></p>
            <p><strong>💻 Электронная версия:</strong> <?= $_SESSION['form_data']['electronic_version'] ? 'Да' : 'Нет' ?></p>
            <p><strong>🗓️ Срок аренды:</strong> <?= htmlspecialchars($_SESSION['form_data']['rental_period']) ?></p>
        </div>
    <?php endif; ?>

    <!-- 🔥 ВЫВОД ДАННЫХ ИЗ API -->
    <?php if(isset($_SESSION['api_data'])): ?>
        <div class="api-data">
            <h3>🚀 Космические новости (из API):</h3>
            <p><strong>Всего статей:</strong> <?= $_SESSION['api_data']['count'] ?? 'Неизвестно' ?></p>
            
            <?php if(isset($_SESSION['random_article']) && !isset($_SESSION['random_article']['error'])): 
                $article = $_SESSION['random_article'];
            ?>
                <div class="article">
                    <h4>📰 Случайная статья:</h4>
                    <p><strong>Заголовок:</strong> <?= htmlspecialchars($article['title'] ?? 'Без названия') ?></p>
                    <p><strong>Источник:</strong> <?= htmlspecialchars($article['news_site'] ?? 'Неизвестно') ?></p>
                    <p><strong>Дата публикации:</strong> <?= htmlspecialchars($article['published_at'] ?? 'Неизвестно') ?></p>
                    <p><strong>URL:</strong> <a href="<?= htmlspecialchars($article['url'] ?? '#') ?>" target="_blank">Читать статью</a></p>
                    <?php if(isset($article['image_url'])): ?>
                        <p><img src="<?= htmlspecialchars($article['image_url']) ?>" alt="Изображение статьи" style="max-width: 200px;"></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <details>
                <summary>📊 Показать полные данные API (JSON)</summary>
                <pre><?= htmlspecialchars(print_r($_SESSION['api_data'], true)) ?></pre>
            </details>
        </div>
        <?php unset($_SESSION['api_data']); ?>
        <?php unset($_SESSION['random_article']); ?>
    <?php endif; ?>

    <!-- Вывод ошибки API -->
    <?php if(isset($_SESSION['api_error'])): ?>
        <div class="error">
            <h3>❌ Ошибка API:</h3>
            <p><?= htmlspecialchars($_SESSION['api_error']) ?></p>
        </div>
        <?php unset($_SESSION['api_error']); ?>
    <?php endif; ?>

    <!-- 🔥 ИНФОРМАЦИЯ О ПОЛЬЗОВАТЕЛЕ -->
    <div class="user-info">
        <h3>👤 Информация о пользователе:</h3>
        <?php
        $userInfo = UserInfo::getInfo();
        foreach ($userInfo as $key => $val): 
            $displayKey = [
                'ip' => 'IP-адрес',
                'user_agent' => 'Браузер',
                'time' => 'Текущее время',
                'referer' => 'Источник перехода',
                'method' => 'HTTP метод'
            ][$key] ?? $key;
        ?>
            <p><strong><?= htmlspecialchars($displayKey) ?>:</strong> <?= htmlspecialchars($val) ?></p>
        <?php endforeach; ?>

        <!-- Куки -->
        <h4>🍪 Информация из cookies:</h4>
        <p><strong>Последняя отправка формы:</strong> <?= $_COOKIE['last_submission'] ?? 'Еще не было' ?></p>
        
        <?php 
        $cookieUserInfo = UserInfo::getFromCookie();
        if (!empty($cookieUserInfo)): 
        ?>
            <p><strong>Предыдущее посещение:</strong> <?= htmlspecialchars($cookieUserInfo['time'] ?? 'Неизвестно') ?></p>
        <?php endif; ?>
    </div>

    <!-- Навигация -->
    <div style="margin: 20px 0;">
        <a href="form.html" style="margin-right: 15px;">📝 Создать заявку</a>
        <a href="view.php" style="margin-right: 15px;">👁️ Просмотреть все заявки</a>
    </div>

    <!-- Информация о системе -->
    <div style="margin-top: 20px;">
        <p><strong>🔄 Сессия:</strong> <?= session_id() ?></p>
        <p><strong>🐘 PHP версия:</strong> <?= phpversion() ?></p>
        <p><strong>📦 Composer:</strong> <?= file_exists('vendor/autoload.php') ? 'Подключен' : 'Не подключен' ?></p>
    </div>
</body>
</html>