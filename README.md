Лабораторная работа №5 – Работа с базой данных MySQL через PHP и Docker

👩‍💻 Автор: Новиков Илья, группа РИСКУ

🎯 Цель работы

Освоить принципы контейнеризации с использованием Docker и Docker Compose.

Настроить работу связки Nginx + PHP + MySQL.

Научиться создавать и подключать базы данных MySQL в контейнерах.

Реализовать веб-приложение с формой заявок и сохранением данных в БД.

Отработать доступ к базе данных как через Adminer, так и из PHP-кода.

🌐 Результат доступен по адресам

Главная страница: http://localhost:8080

Adminer (управление БД): http://localhost:8081

🧠 Как запустить проект

1.Открыть папку проекта в терминале

2.Выполнить:

docker-compose up -d

3.Проверить работу:

сайт: http://localhost:8080

adminer: http://localhost:8081

4.В Adminer войти с данными:

System: MySQL

Server: db

User: lab5_user

Password: lab5_pass

Database: lab5_db
📸 Скриншоты работы
Таблица заявок в view.php
<img width="1715" height="684" alt="image" src="https://github.com/user-attachments/assets/3e74ed33-192a-461d-a193-9d24aeb1cece" />

Структура базы данных в Adminer
<img width="1345" height="591" alt="image" src="https://github.com/user-attachments/assets/239231e1-9279-40e1-ac3e-b1324e573c92" />

