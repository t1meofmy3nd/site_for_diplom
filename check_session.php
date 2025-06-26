<?php
session_start();
header('Content-Type: application/json');
$logged = isset($_SESSION['user']);

echo json_encode(['loggedIn' => $logged]);
?>