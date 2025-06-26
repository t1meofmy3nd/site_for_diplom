<?php
require 'db.php';

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_SESSION['user']['id'];
  $total = $_POST['total'] ?? 0;
  $address = trim($_POST['address'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $payment_method = $_POST['payment_method'] ?? '';
  $comment = $_POST['comment'] ?? '';

  if ($total > 0 && $address && $phone && $payment_method) {
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_price, address, phone, payment_method, comment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $total, $address, $phone, $payment_method, $comment]);
    header("Location: thankyou.html");
    exit;
  } else {
    $error = "Заполните все обязательные поля и убедитесь, что корзина не пуста.";
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Оформление заказа — МедТех</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <header>
    <div class="logo">
      <img src="images/logo.png" alt="Логотип" />
    </div>
    <nav>
      <a href="index.html">Главная</a>
      <a href="catalog.html">Каталог</a>
      <a href="services.html">Услуги</a>
      <a href="about.html">О нас</a>
      <a href="cart.html">Корзина</a>
      <a href="login.php" class="login-link">Войти</a>
      <a href="register.php" class="register-link">Зарегистрироваться</a>
      <a href="logout.php" class="logout-link" style="display:none;">Выйти</a>
    </nav>
  </header>

  <div class="checkout">
    <h2>Оформление заказа</h2>
    <div id="orderSummary" class="order-summary"></div>
    <p class="total">Сумма заказа: <span id="checkoutTotal">0 ₽</span></p>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
      <label>Телефон для связи:<br>
        <input type="tel" name="phone" required>
      </label>
      <label>Адрес доставки:<br>
        <textarea name="address" required></textarea>
      </label>
      <label>Способ оплаты:<br>
        <select name="payment_method" required>
          <option value="card">Картой онлайн</option>
          <option value="cash">Наличными курьеру</option>
        </select>
      </label>
      <label>Комментарий:<br>
        <textarea name="comment"></textarea>
      </label>
      <input type="hidden" name="total" id="orderTotal" value="0">
      
      <button type="submit" class="btn-primary">Подтвердить заказ</button>
    </form>
  </div>

  <script>
       const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const summaryEl = document.getElementById('orderSummary');
    let total = 0;
    summaryEl.innerHTML = '';
    cart.forEach(item => {
      const itemTotal = item.price * item.quantity;
      total += itemTotal;
      const div = document.createElement('div');
      div.className = 'order-item';
      div.innerHTML = `<span>${item.name} × ${item.quantity}</span><span>${itemTotal.toLocaleString()} ₽</span>`;
      summaryEl.appendChild(div);
    });
    document.getElementById('checkoutTotal').textContent = total.toLocaleString() + ' ₽';
    document.getElementById('orderTotal').value = total;
  </script>
  <script src="session.js"></script>
</body>
</html>
