<?php
require 'db.php';

// Простейшая защита — логин через GET ?admin=1
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = (int)($_POST['order_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    $allowed = ['new','processing','shipped','completed','canceled'];
    if ($orderId && in_array($status, $allowed, true)) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $orderId]);
    }
    header('Location: admin.php');
    exit;
}

// Заказы
$orders = $pdo->query("SELECT o.id, u.name, o.total_price, o.address, o.phone, o.payment_method, o.comment, o.status, o.created_at
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
          <th>Телефон</th>
          <th>Оплата</th>
          <th>Комментарий</th>
          <th>Статус</th>
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
            <td><?= htmlspecialchars($order['phone']) ?></td>
            <td><?= htmlspecialchars($order['payment_method']) ?></td>
            <td><?= nl2br(htmlspecialchars($order['comment'])) ?></td>
             <td>
              <form method="post" style="margin:0;">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <select name="status" onchange="this.form.submit()">
                  <?php
                    $statuses = ['new'=>'Новый','processing'=>'В обработке','shipped'=>'Отправлен','completed'=>'Завершен','canceled'=>'Отменен'];
                    foreach ($statuses as $value => $label) {
                        $sel = $order['status'] === $value ? 'selected' : '';
                        echo "<option value='$value' $sel>$label</option>";
                    }
                  ?>
                </select>
              </form>
            </td>
            <td><?= $order['created_at'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
