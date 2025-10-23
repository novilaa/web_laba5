<?php
session_start();

// Получаем и очищаем данные
$username = htmlspecialchars($_POST['username'] ?? '');
$period   = intval($_POST['period'] ?? 0);
$journal  = htmlspecialchars($_POST['journal'] ?? '');
$digital  = isset($_POST['digital']) ? 'Да' : 'Нет';
$payment  = htmlspecialchars($_POST['payment'] ?? '');

$errors = [];

// Проверка данных
if (empty($username)) $errors[] = "Имя не может быть пустым";
if ($period < 1 || $period > 24) $errors[] = "Срок подписки должен быть от 1 до 24 месяцев";
if (empty($payment)) $errors[] = "Выберите способ оплаты";

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: index.php");
    exit();
}

// Сохраняем данные в сессию
$_SESSION['username'] = $username;
$_SESSION['period'] = $period;
$_SESSION['journal'] = $journal;
$_SESSION['digital'] = $digital;
$_SESSION['payment'] = $payment;

// Сохраняем данные в файл
$line = "$username;$period;$journal;$digital;$payment\n";
file_put_contents("data.txt", $line, FILE_APPEND);

// Перенаправление на главную
header("Location: index.php");
exit();
?>
