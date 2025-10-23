<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Все данные</title>
</head>
<body>
    <h2>Все сохранённые подписки:</h2>
    <ul>
    <?php
    if (file_exists("data.txt")) {
        $lines = file("data.txt", FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            list($name, $period, $journal, $digital, $payment) = explode(";", $line);
            echo "<li>$name — $journal ($period мес.), Электронная: $digital, Оплата: $payment</li>";
        }
    } else {
        echo "<li>Данных нет</li>";
    }
    ?>
    </ul>

    <p><a href="index.php">На главную</a></p>
</body>
</html>
