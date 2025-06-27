<?php
require 'db.php';

// Простейшая защита — логин через GET ?admin=1
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}

$adminName = htmlspecialchars($_SESSION['admin']['username']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $orderId = (int)$_POST['order_id'];
    $status  = $_POST['status'];
    $allowed = ['new','processing','shipped','completed','canceled'];
    if ($orderId && in_array($status, $allowed, true)) {
        $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
        $stmt->execute([$status, $orderId]);
    }
    header('Location: admin.php');
    exit;
}

// Заказы
$statusFilter = $_GET['status'] ?? '';
$orderSql = 'SELECT o.id, u.name, o.total_price, o.address, o.phone, o.payment_method, o.comment, o.status, o.created_at FROM orders o LEFT JOIN users u ON o.user_id = u.id';
$params = [];
if ($statusFilter && in_array($statusFilter, ["new","processing","shipped","completed","canceled"])) {
    $orderSql .= " WHERE o.status = ?";
    $params[] = $statusFilter;
}
$orderSql .= ' ORDER BY o.id DESC';
$st = $pdo->prepare($orderSql);
$st->execute($params);
$orders = $st->fetchAll();

$products = $pdo->query('SELECT id,name,price,image_01 FROM products ORDER BY id DESC')->fetchAll();
$users = $pdo->query('SELECT u.id,u.email,COUNT(o.id) AS orders_count FROM users u LEFT JOIN orders o ON u.id=o.user_id GROUP BY u.id')->fetchAll();
$messages = $pdo->query('SELECT id,name,email,number,message FROM messages ORDER BY id DESC')->fetchAll();
$admins = $pdo->query('SELECT id,username FROM admins ORDER BY id')->fetchAll();

$stats = [
    'orders' => (int)$pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn(),
    'users'  => (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(),
    'products' => (int)$pdo->query('SELECT COUNT(*) FROM products')->fetchColumn(),
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ-панель — МедТех</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="sidebar">
        <h2>MedTech</h2>
        <a href="#" data-section="orders"><i class="fa-solid fa-box"></i>Заказы</a>
        <a href="#" data-section="products"><i class="fa-solid fa-cart-shopping"></i>Товары</a>
        <a href="#" data-section="users"><i class="fa-solid fa-user"></i>Пользователи</a>
        <a href="#" data-section="messages"><i class="fa-solid fa-envelope"></i>Сообщения</a>
        <a href="#" data-section="stats"><i class="fa-solid fa-chart-line"></i>Статистика</a>
        <a href="#" data-section="admins"><i class="fa-solid fa-user-shield"></i>Администраторы</a>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Выйти</a>
    </div>
    <div class="content">
        <div class="topbar">
          <button class="menu-toggle" aria-label="Меню">&#9776;</button>
            <h1>Привет, <?= $adminName ?>!</h1>
        </div>

        <section id="orders">
            <h2>Заказы</h2>
            <form method="get" class="filters">
                <select name="status" class="status-select" onchange="this.form.submit()">
                  <option value="">Все</option>
                    <?php
                    foreach (["new"=>"Новый","processing"=>"В обработке","shipped"=>"Отправлен","completed"=>"Завершен","canceled"=>"Отменен"] as $val=>$label) {
                        $sel = $statusFilter==$val ? 'selected' : '';
                        echo "<option value='$val' $sel>$label</option>";
                    }
                    ?>
                </select>
              </form>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
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
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td><?= $o['id'] ?></td>
                        <td><?= htmlspecialchars($o['name'] ?? '-') ?></td>
                        <td><?= $o['total_price'] ?> ₽</td>
                        <td><?= nl2br(htmlspecialchars($o['address'])) ?></td>
                        <td><?= htmlspecialchars($o['phone']) ?></td>
                        <td><?= htmlspecialchars($o['payment_method']) ?></td>
                        <td><?= nl2br(htmlspecialchars($o['comment'])) ?></td>
                        <td>
                            <form method="post" style="margin:0;">
                                <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                                <select name="status" class="status-select" onchange="this.form.submit()">
                                <?php
                                    $statuses = ["new"=>"Новый","processing"=>"В обработке","shipped"=>"Отправлен","completed"=>"Завершен","canceled"=>"Отменен"];
                                    foreach ($statuses as $val=>$label) {
                                        $sel = $o['status']==$val ? 'selected' : '';
                                        echo "<option value='$val' $sel>$label</option>";
                                    }
                                ?>
                                </select>
                            </form>
                        </td>
                        <td><?= $o['created_at'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section id="products" style="display:none;">
            <h2>Товары</h2>
            <table class="table">
                <thead>
                    <tr><th>Фото</th><th>Название</th><th>Цена</th><th>Категория</th><th>Действия</th></tr>
                </thead>
                <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?php if ($p['image_01']): ?><img src="<?= htmlspecialchars($p['image_01']) ?>" style="height:40px;"/><?php endif; ?></td>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= $p['price'] ?> ₽</td>
                        <td>-</td>
                        <td>
                            <a href="#"><i class="fa fa-edit"></i></a>
                            <a href="#"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <button class="btn-primary" style="margin-top:10px;">Добавить товар</button>
        </section>

        <section id="users" style="display:none;">
            <h2>Пользователи</h2>
            <table class="table">
                <thead>
                    <tr><th>Email</th><th>Количество заказов</th><th>Действия</th></tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= $u['orders_count'] ?></td>
                        <td><button>Блокировать</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section id="messages" style="display:none;">
            <h2>Сообщения</h2>
            <table class="table">
                <thead>
                    <tr><th>Имя</th><th>Email</th><th>Телефон</th><th>Сообщение</th><th></th></tr>
                </thead>
                <tbody>
                <?php foreach ($messages as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['name']) ?></td>
                        <td><?= htmlspecialchars($m['email']) ?></td>
                        <td><?= htmlspecialchars($m['number']) ?></td>
                        <td><?= nl2br(htmlspecialchars($m['message'])) ?></td>
                        <td><a href="#"><i class="fa fa-trash"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section id="stats" style="display:none;">
            <h2>Статистика</h2>
            <div class="stats-grid">
                <div class="stat-card"><h3>Заказы</h3><p><?= $stats['orders'] ?></p></div>
                <div class="stat-card"><h3>Пользователи</h3><p><?= $stats['users'] ?></p></div>
                <div class="stat-card"><h3>Товары</h3><p><?= $stats['products'] ?></p></div>
            </div>
        </section>

        <section id="admins" style="display:none;">
            <h2>Управление администраторами</h2>
            <table class="table">
                <thead>
                    <tr><th>Логин</th><th>Действия</th></tr>
                </thead>
                <tbody>
                <?php foreach ($admins as $a): ?>
                    <tr>
                        <td><?= htmlspecialchars($a['username']) ?></td>
                        <td><a href="#">Сменить пароль</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <button class="btn-primary" style="margin-top:10px;">Добавить администратора</button>
        </section>
    </div>
    <script src="admin.js"></script>
</body>
</html>
