<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Просмотр заявок</title>
    <style>
        .nav { margin: 20px 0; padding: 10px; background: #f5f5f5; }
        .nav a { margin-right: 15px; text-decoration: none; color: blue; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .empty { color: #666; font-style: italic; }
    </style>
</head>
<body>
    <h1>👁️ Просмотр всех заявок</h1>
    
    <div class="nav">
        <a href="index.php">🏠 Главная</a>
        <a href="form.php">📝 Форма заявки</a>
        <a href="view.php">👁️ Просмотр заявок</a>
    </div>

    <?php 
    $data_file = 'data.txt';
    if (file_exists($data_file) && filesize($data_file) > 0): 
        $lines = file($data_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $lines = array_reverse($lines); // Новые сверху
    ?>
        <table>
            <thead>
                <tr>
                    <th>Дата и время</th>
                    <th>👤 Имя</th>
                    <th>🎟️ Номер билета</th>
                    <th>📚 Жанр</th>
                    <th>💻 Эл. версия</th>
                    <th>🗓️ Срок аренды</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lines as $line): 
                    $data = explode(' | ', $line);
                    // Проверяем что все поля есть
                    if (count($data) >= 6):
                ?>
                    <tr>
                        <td><?= htmlspecialchars($data[0] ?? '') ?></td>
                        <td><?= htmlspecialchars($data[1] ?? '') ?></td>
                        <td><?= htmlspecialchars($data[2] ?? '') ?></td>
                        <td>
                            <?php
                            $genres = [
                                'fantasy' => 'Фэнтези',
                                'science_fiction' => 'Научная фантастика', 
                                'detective' => 'Детектив',
                                'romance' => 'Роман',
                                'historical' => 'Исторический',
                                'technical' => 'Техническая литература'
                            ];
                            echo $genres[$data[3] ?? ''] ?? ($data[3] ?? '');
                            ?>
                        </td>
                        <td><?= ($data[4] ?? '') === 'yes' ? '✅ Да' : '❌ Нет' ?></td>
                        <td>
                            <?php
                            $periods = [
                                '1week' => '1 неделя',
                                '2weeks' => '2 недели', 
                                '1month' => '1 месяц'
                            ];
                            echo $periods[$data[5] ?? ''] ?? ($data[5] ?? '');
                            ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty">⚠️ Неполная запись: <?= htmlspecialchars($line) ?></td>
                    </tr>
                <?php endif; endforeach; ?>
            </tbody>
        </table>
        
        <p><strong>Всего заявок:</strong> <?= count($lines) ?></p>
    <?php else: ?>
        <p class="empty">📭 Заявок пока нет.</p>
    <?php endif; ?>
    
    <div style="margin-top: 20px;">
        <a href="index.php">← На главную</a>
    </div>
</body>
</html>