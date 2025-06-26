<?php
require 'db.php';

// Простейшая защита — логин через GET ?admin=1
if (!isset($_GET['admin']) || $_GET['admin'] !== '1') {
  die("Доступ запрещён.");
}

// Заказы
$orders = $pdo->query("SELECT o.id, u.name, o.total_price, o.address, o.comment, o.created_at 
                       FROM orders o LEFT JOIN users u ON o.user_id = u.id ORDER BY o.id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Админ-панель — МедТех</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
    th { background: #f0f0f0; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Список заказов</h2>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Пользователь</th>
          <th>Сумма</th>
          <th>Адрес</th>
          <th>Комментарий</th>
          <th>Дата</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?= $order['id'] ?></td>
            <td><?= htmlspecialchars($order['name'] ?? '-') ?></td>
            <td><?= $order['total_price'] ?> ₽</td>
            <td><?= nl2br(htmlspecialchars($order['address'])) ?></td>
            <td><?= nl2br(htmlspecialchars($order['comment'])) ?></td>
            <td><?= $order['created_at'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
