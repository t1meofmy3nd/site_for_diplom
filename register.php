<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    if ($name && $email && $password) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$name, $email, $password_hash]);
            $_SESSION['user'] = ['name' => $name, 'email' => $email];
            header("Location: index.html");
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
  <title>Регистрация — МедТех</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="auth-form">
    <h2>Регистрация</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
      <input type="text" name="name" placeholder="Имя" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Пароль" required>
      <button type="submit" class="btn-primary">Зарегистрироваться</button>
    </form>
    <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
  </div>
</body>
</html>
