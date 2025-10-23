<?php
session_start();
require_once 'vendor/autoload.php';

// Обработка данных формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Получение и очистка данных
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $ticket_number = htmlspecialchars(trim($_POST['ticket_number'] ?? ''));
    $book_genre = htmlspecialchars(trim($_POST['book_genre'] ?? ''));
    $electronic_version = isset($_POST['electronic_version']) ? 'yes' : 'no';
    $rental_period = htmlspecialchars(trim($_POST['rental_period'] ?? ''));
    
    // Валидация данных
    if (empty($username)) {
        $errors[] = "Имя пользователя не может быть пустым";
    } elseif (strlen($username) < 2) {
        $errors[] = "Имя пользователя должно содержать минимум 2 символа";
    }
    
    if (empty($ticket_number)) {
        $errors[] = "Номер билета не может быть пустым";
    } elseif (!is_numeric($ticket_number) || $ticket_number < 1 || $ticket_number > 9999) {
        $errors[] = "Номер билета должен быть числом от 1 до 9999";
    }
    
    if (empty($book_genre)) {
        $errors[] = "Необходимо выбрать жанр книги";
    }
    
    if (empty($rental_period)) {
        $errors[] = "Необходимо выбрать срок аренды";
    }
    
    // Если есть ошибки - сохраняем их в сессию
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit();
    }
    
    // Сохранение данных в сессию
    $_SESSION['form_data'] = [
        'username' => $username,
        'ticket_number' => $ticket_number,
        'book_genre' => $book_genre,
        'electronic_version' => $electronic_version === 'yes',
        'rental_period' => $rental_period
    ];
    
    // 🔥 ИНТЕГРАЦИЯ API - получаем новости о космосе
    try {
        $api = new ApiClient();
        $apiData = $api->getSpaceNews();
        $_SESSION['api_data'] = $apiData;
        
        // Также сохраняем случайную статью для показа
        $randomArticle = $api->getRandomArticle();
        $_SESSION['random_article'] = $randomArticle;
        
    } catch (Exception $e) {
        $_SESSION['api_error'] = "Ошибка при получении данных из API: " . $e->getMessage();
    }
    
    // Сохранение в файл
    $data_line = date('Y-m-d H:i:s') . " | " . 
    $username . " | " . 
    $ticket_number . " | " . 
    $book_genre . " | " . 
    $electronic_version . " | " . 
    $rental_period . PHP_EOL;
    
    file_put_contents('data.txt', $data_line, FILE_APPEND | LOCK_EX);
    
    // Сохранение информации о пользователе в куки
    $userInfo = UserInfo::getInfo();
    UserInfo::saveToCookie($userInfo);
    
    // Кука с временем последней отправки
    setcookie("last_submission", date('Y-m-d H:i:s'), time() + 3600, "/");
    
    // Сообщение об успехе
    $_SESSION['success'] = "Заявка успешно сохранена! Получены свежие новости.";
    
    // Перенаправление на главную страницу
    header('Location: index.php');
    exit();
} else {
    // Если кто-то попытался обратиться к process.php напрямую
    header('Location: form.html');
    exit();
}
?>