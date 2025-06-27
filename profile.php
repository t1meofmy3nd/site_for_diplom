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
</head>
<body>
<?php include 'header.php'; ?>
<div class="account-container" style="max-width:900px;margin:40px auto;">
  <h2 style="margin-bottom:10px;">Информация о пользователе</h2>
  <div class="profile-info" style="margin-bottom:20px;">
    <p><strong>Имя:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
  </div>

  <h2 style="margin-bottom:10px;">Мои заказы</h2>
  <table class="table">
    <thead>
      <tr>
        <th>№</th>
        <th>Сумма</th>
        <th>Способ оплаты</th>
        <th>Адрес</th>
        <th>Статус</th>
        <th>Дата</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $o): ?>
      <tr>
        <td><?= $o['id'] ?></td>
        <td><?= $o['total_price'] ?> ₽</td>
        <td><?= htmlspecialchars($o['payment_method']) ?></td>
        <td><?= nl2br(htmlspecialchars($o['address'])) ?></td>
        <td><span class="status status-<?= $o['status'] ?>"><?= $labels[$o['status']] ?? $o['status'] ?></span></td>
        <td><?= $o['created_at'] ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <a href="logout.php" class="btn-primary" style="display:inline-block;margin-top:20px;">Выйти из аккаунта</a>
</div>
<script src="header.js"></script>
<script src="session.js"></script>
</body>
</html>