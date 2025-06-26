<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']];
            header("Location: index.html");
            exit;
        } else {
            $error = "Неверный email или пароль.";
        }
    } else {
        $error = "Пожалуйста, заполните все поля.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Вход — МедТех</title>
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

  <div class="auth-form">
    <h2>Вход</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit" class="btn-primary">Войти</button>
    </form>
    <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
  </div>
</body>
</html>
