<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

require 'config.php';

$name = $_POST['name'] ?? '';
$steamid = $_POST['steamid'] ?? '';
$code = $_POST['code'] ?? bin2hex(random_bytes(5));
$expire = $_POST['expire'] ?? NULL;
$added_by = $_SESSION['username'] ?? 'Unknown';
$admin_group = $_POST['admin_group'] ?? NULL;
$used = $_POST['used'] ?? '0';

$expire_date = $expire ? date('Y-m-d H:i:s', strtotime($expire)) : NULL;

$sql = "INSERT INTO sb_vip_system (code, name, steamid, expire, admin_group, used, added_by) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {

    $expire_date = ($expire !== '') ? date('Y-m-d H:i:s', strtotime($expire)) : NULL;
    $admin_group = ($admin_group !== '') ? $admin_group : NULL;

    $stmt->bind_param("sssssis", $code, $name, $steamid, $expire_date, $admin_group, $used, $added_by);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'VIP added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding VIP: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
}

$conn->close();
?>
