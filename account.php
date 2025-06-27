<?php
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];

$stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC');
$stmt->execute([$user['id']]);
$orders = $stmt->fetchAll();

$labels = [
    'new' => 'Новый',
    'processing' => 'В обработке',
    'shipped' => 'Отправлен',
    'completed' => 'Доставлен',
    'canceled' => 'Отменён'
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Личный кабинет — МедТех</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
<div class="dashboard">
  <aside class="sidebar">
    <ul>
      <li><a href="#"><span class="material-icons">person</span>Профиль</a></li>
      <li><a href="#orders"><span class="material-icons">shopping_bag</span>Заказы</a></li>
      <li><a href="#"><span class="material-icons">favorite</span>Избранное</a></li>
      <li><a href="#"><span class="material-icons">help</span>Поддержка</a></li>
      <li><a href="logout.php"><span class="material-icons">logout</span>Выход</a></li>
    </ul>
  </aside>
  <main class="dashboard-content">
    <header class="account-header">
      <div class="logo"><img src="images/logo.png" alt="МедТех"></div>
      <div class="avatar"><?= strtoupper(mb_substr($user['name'],0,1,'UTF-8')) ?></div>
    </header>
    <h2 class="greeting">Привет, <?= htmlspecialchars($user['name']) ?>!</h2>
    <h3 id="orders">Мои заказы</h3>
    <table class="table" style="margin-top:10px;">
      <thead>
        <tr>
          <th>ID заказа</th>
          <th>Сумма</th>
          <th>Адрес</th>
          <th>Оплата</th>
          <th>Статус</th>
          <th>Дата</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($orders as $o): ?>
        <tr>
          <td><?= $o['id'] ?></td>
          <td><?= $o['total_price'] ?> ₽</td>
          <td><?= nl2br(htmlspecialchars($o['address'])) ?></td>
          <td><?= htmlspecialchars($o['payment_method']) ?></td>
          <td><span class="status status-<?= $o['status'] ?>"><?= $labels[$o['status']] ?? $o['status'] ?></span></td>
          <td><?= $o['created_at'] ?></td>
          <td><a href="order.php?id=<?= $o['id'] ?>" class="btn-link">Подробнее</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </main>
</div>
</body>
</html>