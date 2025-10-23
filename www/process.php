<?php
session_start();
require_once 'vendor/autoload.php';

if ($_POST) {
    // Сохраняем в сессию
    $_SESSION['form_data'] = [
        'username' => $_POST['username'],
        'ticket_number' => $_POST['ticket_number'],
        'book_genre' => $_POST['book_genre'],
        'electronic_version' => isset($_POST['electronic_version']),
        'rental_period' => $_POST['rental_period']
    ];
    
    // 🔥 ПОЛУЧАЕМ ДАННЫЕ ИЗ API
    try {
        $api = new ApiClient();
        $apiData = $api->getSpaceNews();
        $_SESSION['api_data'] = $apiData;
    } catch (Exception $e) {
        $_SESSION['api_error'] = $e->getMessage();
    }
    
    // Сохраняем информацию о пользователе
    $userInfo = UserInfo::getInfo();
    UserInfo::saveToCookie($userInfo);
    
    // Сохраняем в файл
    $data = implode(' | ', [
        date('Y-m-d H:i:s'),
        $_POST['username'],
        $_POST['ticket_number'],
        $_POST['book_genre'],
        isset($_POST['electronic_version']) ? 'yes' : 'no',
        $_POST['rental_period']
    ]) . PHP_EOL;
    
    file_put_contents('data.txt', $data, FILE_APPEND);
    
    header('Location: index.php');
    exit;
}
?>