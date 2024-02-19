<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use CRON\CronExpression;

// Путь к сертификату и токену
$certPath = 'path_to_your_certificate.pem';
$token = 'your_token_here';

// Функция для отправки запроса на страницу с уведомлениями
function getNotifications() {
    global $certPath, $token;

    // Создаем объект GuzzleHttp\Client
    $client = new Client([
        'base_uri' => 'https://esia.gosuslugi.ru/',
        'cert' => $certPath,
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
        ]
    ]);

    // Отправляем GET-запрос
    $response = $client->get('');

    // Получаем содержимое ответа
    $body = $response->getBody()->getContents();

    // Парсим HTML и ищем уведомления
    $notificationCount = substr_count($body, 'class="notification"');

    // Выводим количество уведомлений
    echo "Количество уведомлений на госуслугах: $notificationCount\n";
}

// Выполняем функцию получения уведомлений
getNotifications();

// Планируем выполнение скрипта раз в час
$cronExpression = CronExpression::factory('@hourly');
if ($cronExpression->isDue()) {
    getNotifications();
}
