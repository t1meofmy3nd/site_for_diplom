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
</head>
<body>
<?php include 'header.php'; ?>
<div class="account-container" style="max-width:1000px;margin:40px auto;padding:0 20px;">
  <h2 style="margin-bottom:20px;">Личный кабинет</h2>
  <div class="profile-info" style="margin-bottom:20px;">
    <p><strong>Имя:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <a href="logout.php" class="btn-primary" style="max-width:200px;">Выйти</a>
  </div>
  <h3>Мои заказы</h3>
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
</div>
<script src="header.js"></script>
<script src="session.js"></script>
</body>
</html>