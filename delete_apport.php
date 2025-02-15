<?php
session_start();
include_once __DIR__ . '/db.php';

if (!isset($_GET['id'])) {
    header('Location: rapport.php');
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM apports WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header('Location: rapport.php');
exit();
?>
