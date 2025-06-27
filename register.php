<?php
require 'db.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        die('Неверный CSRF токен.');
    }
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    if ($name && $email && $password) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$name, $email, $password_hash]);
            session_regenerate_id(true);
            $_SESSION['user'] = ['name' => $name, 'email' => $email];
            header("Location: profile.php");
            unset($_SESSION['csrf_token']);
            exit;
        } catch (PDOException $e) {
            $error = "Email уже используется.";
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
  <title>Регистрация — МедТех</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php include 'header.php'; ?>

  <div class="auth-form">
    <h2>Регистрация</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
      <input type="text" name="name" placeholder="Имя" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit" class="btn-primary">Зарегистрироваться</button>
    </form>
    <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
  </div>

  <script src="header.js"></script>
  <script src="session.js"></script>
</body>
</html>
