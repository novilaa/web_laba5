<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма заявки в библиотеку</title>
    <style>
        .nav { margin: 20px 0; padding: 10px; background: #f5f5f5; }
        .nav a { margin-right: 15px; text-decoration: none; color: blue; }
        form { max-width: 500px; margin: 20px 0; }
        input, select { margin: 5px 0; padding: 8px; width: 100%; }
        button { padding: 10px 20px; background: #007cba; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>📝 Форма заявки в библиотеку</h1>
    
    <div class="nav">
        <a href="index.php">🏠 Главная</a>
        <a href="form.php">📝 Форма заявки</a>
        <a href="view.php">👁️ Просмотр заявок</a>
    </div>

    <form action="process.php" method="POST">
        <!-- 👤 Имя пользователя -->
        <div>
            <label><strong>👤 Имя пользователя:</strong></label>
            <input type="text" name="username" placeholder="Введите ваше имя" required>
        </div>
        
        <!-- 🎟️ Номер билета -->
        <div>
            <label><strong>🎟️ Номер билета:</strong></label>
            <input type="number" name="ticket_number" min="1" max="9999" placeholder="От 1 до 9999" required>
        </div>
        
        <!-- 📚 Жанр книги -->
        <div>
            <label><strong>📚 Жанр книги:</strong></label>
            <select name="book_genre" required>
                <option value="">-- Выберите жанр --</option>
                <option value="fantasy">Фэнтези</option>
                <option value="science_fiction">Научная фантастика</option>
                <option value="detective">Детектив</option>
                <option value="romance">Роман</option>
                <option value="historical">Исторический</option>
                <option value="technical">Техническая литература</option>
            </select>
        </div>
        
        <!-- 💻 Электронная версия -->
        <div>
            <input type="checkbox" name="electronic_version" value="yes" id="electronic_version">
            <label for="electronic_version"><strong>💻 Электронная версия</strong></label>
        </div>
        
        <!-- 🗓️ Срок аренды -->
        <div>
            <label><strong>🗓️ Срок аренды:</strong></label><br>
            <input type="radio" name="rental_period" value="1week" id="rental_1week" required>
            <label for="rental_1week">1 неделя</label><br>
            
            <input type="radio" name="rental_period" value="2weeks" id="rental_2weeks">
            <label for="rental_2weeks">2 недели</label><br>
            
            <input type="radio" name="rental_period" value="1month" id="rental_1month">
            <label for="rental_1month">1 месяц</label>
        </div>
        
        <br>
        <button type="submit">📝 Отправить заявку</button>
    </form>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const username = this.username.value;
            const ticketNumber = this.ticket_number.value;
            const bookGenre = this.book_genre.options[this.book_genre.selectedIndex].text;
            const electronicVersion = this.electronic_version.checked ? 'Да' : 'Нет';
            
            // Находим выбранный срок аренды
            const rentalPeriod = document.querySelector('input[name="rental_period"]:checked');
            const rentalText = rentalPeriod ? rentalPeriod.nextElementSibling.textContent : 'Не выбрано';
            
            alert(`Вы ввели:\n👤 Имя: ${username}\n🎟️ Номер билета: ${ticketNumber}\n📚 Жанр: ${bookGenre}\n💻 Электронная версия: ${electronicVersion}\n🗓️ Срок аренды: ${rentalText}`);
        });
    </script>
</body>
</html>