<?php
session_start();
require_once 'vendor/autoload.php';

// Временная загрузка классов если autoload не работает
if (!class_exists('UserInfo')) {
    require_once 'UserInfo.php';
}
if (!class_exists('ApiClient')) {
    require_once 'ApiClient.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные формы
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $ticket_number = htmlspecialchars(trim($_POST['ticket_number'] ?? ''));
    $book_genre = htmlspecialchars(trim($_POST['book_genre'] ?? ''));
    $electronic_version = isset($_POST['electronic_version']) ? 'yes' : 'no';
    $rental_period = htmlspecialchars(trim($_POST['rental_period'] ?? ''));
    
    // Сохраняем в сессию
    $_SESSION['form_data'] = [
        'username' => $username,
        'ticket_number' => $ticket_number,
        'book_genre' => $book_genre,
        'electronic_version' => $electronic_version === 'yes',
        'rental_period' => $rental_period
    ];
    
    // 🔥 ПОЛУЧАЕМ ДАННЫЕ ИЗ API
    try {
        $api = new ApiClient();
        $apiData = $api->getSpaceNews();
        $_SESSION['api_data'] = $apiData;
    } catch (Exception $e) {
        $_SESSION['api_error'] = $e->getMessage();
    }
    
    // Сохраняем информацию о пользователе в куки
    $userInfo = UserInfo::getInfo();
    UserInfo::saveToCookie($userInfo);
    
    // Сохраняем в файл
    $data_line = date('Y-m-d H:i:s') . " | " . 
    $username . " | " . 
    $ticket_number . " | " . 
    $book_genre . " | " . 
    $electronic_version . " | " . 
    $rental_period . PHP_EOL;
    
    file_put_contents('data.txt', $data_line, FILE_APPEND | LOCK_EX);
    
    // Перенаправляем на главную
    header('Location: index.php');
    exit();
} else {
    // Если попали сюда напрямую - редирект на форму
    header('Location: form.php');
    exit();
}
?>