<?php
require 'db.php';

if (isset($_SESSION['admin'])) {
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin'] = ['id' => $admin['id'], 'username' => $admin['username']];
            header('Location: admin.php');
            exit;
        } else {
            $error = 'Неверное имя пользователя или пароль.';
        }
    } else {
        $error = 'Пожалуйста, заполните все поля.';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вход для админа — МедТех</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="auth-form">
    <h2>Вход для администратора</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Имя пользователя" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit" class="btn-primary">Войти</button>
    </form>
  </div>
</body>
</html>