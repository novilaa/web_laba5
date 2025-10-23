<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
</head>
<body>
    <h2>Главная страница</h2>

    <?php if(isset($_SESSION['errors'])): ?>
    <ul style="color:red;">
        <?php foreach($_SESSION['errors'] as $error): ?>
        <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
    <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['username'])): ?>
    <p><b>Данные последней подписки:</b></p>
    <ul>
        <li>Имя: <?= $_SESSION['username'] ?></li>
        <li>Срок подписки: <?= $_SESSION['period'] ?> мес.</li>
        <li>Журнал: <?= $_SESSION['journal'] ?></li>
        <li>Электронная версия: <?= $_SESSION['digital'] ?></li>
        <li>Оплата: <?= $_SESSION['payment'] ?></li>
    </ul>
    <?php else: ?>
    <p>Данных пока нет.</p>
    <?php endif; ?>

    <p>
    <a href="form.html">Заполнить форму</a> |
    <a href="view.php">Посмотреть все данные</a>
    </p>
</body>
</html>
