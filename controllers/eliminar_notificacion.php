<?php
require_once __DIR__ . "/../models/bbdd.php";
require_once __DIR__ . "/../middleware/session.php";

$db = new Database();
$conn = $db->connect();

$id = $_POST["id"] ?? null;

if ($id) {
    $sql = $conn->prepare("DELETE FROM notificaciones WHERE id = ?");
    $sql->execute([$id]);
}

header("Location: /pages/notificaciones-familiar.php");
exit();
