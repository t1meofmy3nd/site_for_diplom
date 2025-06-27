<?php
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ? AND user_id = ?');
$stmt->execute([$id, $_SESSION['user']['id']]);
$order = $stmt->fetch();
if (!$order) {
    http_response_code(404);
    exit('Заказ не найден');
}

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
  <title>Заказ #<?= $order['id'] ?> — МедТех</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="account-container" style="max-width:800px;margin:40px auto;padding:0 20px;">
  <h2>Детали заказа #<?= $order['id'] ?></h2>
  <p><strong>Статус:</strong> <span class="status status-<?= $order['status'] ?>"><?= $labels[$order['status']] ?? $order['status'] ?></span></p>
  <p><strong>Сумма:</strong> <?= $order['total_price'] ?> ₽</p>
  <p><strong>Адрес:</strong> <?= nl2br(htmlspecialchars($order['address'])) ?></p>
  <p><strong>Телефон:</strong> <?= htmlspecialchars($order['phone']) ?></p>
  <p><strong>Оплата:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
  <p><strong>Комментарий:</strong> <?= nl2br(htmlspecialchars($order['comment'])) ?></p>
  <p><strong>Дата:</strong> <?= $order['created_at'] ?></p>
  <a href="profile.php" class="btn-primary" style="max-width:200px;">Назад</a>
</div>
<script src="header.js"></script>
<script src="session.js"></script>
</body>
</html>