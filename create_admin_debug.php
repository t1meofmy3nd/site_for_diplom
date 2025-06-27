<?php
require 'db.php';

$username = 'admin';
$plainPassword = 'admin123';

// remove existing admin record
$pdo->prepare('DELETE FROM admins WHERE username = ?')->execute([$username]);

// create new admin
$hash = password_hash($plainPassword, PASSWORD_DEFAULT);
$pdo->prepare('INSERT INTO admins (username, password) VALUES (?, ?)')->execute([$username, $hash]);

// fetch back for verification
$adminStmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
$adminStmt->execute([$username]);
$admin = $adminStmt->fetch(PDO::FETCH_ASSOC);
var_dump($admin);
var_dump(password_verify($plainPassword, $admin['password'] ?? ''));
?>