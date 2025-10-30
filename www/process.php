<?php
session_start();
require_once 'db.php';
require_once 'Subscription.php';

$subscription = new Subscription($pdo);

// Получаем данные из формы
$name = htmlspecialchars($_POST['name'] ?? '');
$subscription_period = htmlspecialchars($_POST['subscription_period'] ?? '');
$magazine = htmlspecialchars($_POST['magazine'] ?? '');
$electronic_version = isset($_POST['electronic_version']) ? 1 : 0;
$payment_method = htmlspecialchars($_POST['payment_method'] ?? '');

// Валидация данных
$errors = [];
if (empty($name)) {
    $errors[] = "Имя обязательно для заполнения";
}
if (empty($subscription_period)) {
    $errors[] = "Выберите срок подписки";
}
if (empty($magazine)) {
    $errors[] = "Выберите журнал";
}
if (empty($payment_method)) {
    $errors[] = "Выберите способ оплаты";
}

// Если есть ошибки, сохраняем их в сессию и возвращаемся к форме
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header("Location: form.html");
    exit();
}

try {
    // Добавляем подписку в базу данных
    $subscription->add($name, $subscription_period, $magazine, $electronic_version, $payment_method);
    
    // Сохраняем сообщение об успехе
    $_SESSION['success'] = "Подписка успешно оформлена!";
    
    // Перенаправляем на главную страницу
    header("Location: index.php");
    exit();
} catch (\PDOException $e) {
    // В случае ошибки БД
    $_SESSION['errors'] = ["Ошибка при сохранении данных: " . $e->getMessage()];
    $_SESSION['form_data'] = $_POST;
    header("Location: form.html");
    exit();
}
?>