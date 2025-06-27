<?php
require 'db.php';

$username = 'admin';
$passwordPlain = 'admin123';
$passwordHash = password_hash($passwordPlain, PASSWORD_DEFAULT);

try {
    $checkStmt = $pdo->prepare('SELECT id FROM admins WHERE username = ?');
    $checkStmt->execute([$username]);
    if ($checkStmt->fetch()) {
        echo "\xE2\x9A\xA0 Администратор уже существует\n";
        exit;
    }

    $insertStmt = $pdo->prepare('INSERT INTO admins (username, password) VALUES (?, ?)');
    $insertStmt->execute([$username, $passwordHash]);

    echo "\xE2\x9C\x85 Успешно: \"Администратор создан\"\n";
    echo "Удалите этот файл из соображений безопасности.\n";
} catch (PDOException $e) {
    echo "\xE2\x9D\x8C Ошибка: " . $e->getMessage() . "\n";
}