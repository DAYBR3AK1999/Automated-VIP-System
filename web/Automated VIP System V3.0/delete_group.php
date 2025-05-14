<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'owner') {
    header("Location: index.php");
    exit();
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM sb_vip_groups WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
header("Location: list_groups.php");
exit();
