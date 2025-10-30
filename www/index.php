<?php
session_start();
require_once 'db.php';
require_once 'Subscription.php';

// Создаем экземпляр класса Subscription
$subscription = new Subscription($pdo);

// Получаем все подписки
try {
    $subscriptions = $subscription->getAll();
} catch (\PDOException $e) {
    $error = "Ошибка при получении данных: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Система подписки на журналы</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .nav { 
            margin: 20px 0; 
            padding: 10px; 
            background: #f5f5f5; 
            border-radius: 4px;
        }
        .nav a { 
            margin-right: 15px; 
            text-decoration: none; 
            color: #0066cc;
            padding: 5px 10px;
        }
        .nav a:hover {
            background: #e0e0e0;
            border-radius: 3px;
        }
        .subscription {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            background: #fff;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #f5c6cb;
        }
        .add-button {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin: 20px 0;
        }
        .add-button:hover {
            background: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>📚 Система подписки на журналы</h1>
    
    <div class="nav">
        <a href="index.php">🏠 Главная</a>
        <a href="form.html">📝 Оформить подписку</a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="success">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <a href="form.html" class="add-button">➕ Оформить новую подписку</a>

    <?php if (!empty($subscriptions)): ?>
        <table>
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Журнал</th>
                    <th>Срок подписки</th>
                    <th>Электронная версия</th>
                    <th>Способ оплаты</th>
                    <th>Дата оформления</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subscriptions as $sub): ?>
                    <tr>
                        <td><?= htmlspecialchars($sub['name']) ?></td>
                        <td><?= htmlspecialchars($sub['magazine']) ?></td>
                        <td><?= htmlspecialchars($sub['subscription_period']) ?> мес.</td>
                        <td><?= $sub['electronic_version'] ? 'Да' : 'Нет' ?></td>
                        <td><?= htmlspecialchars($sub['payment_method']) ?></td>
                        <td><?= htmlspecialchars($sub['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Пока нет оформленных подписок.</p>
    <?php endif; ?>
</body>
</html>