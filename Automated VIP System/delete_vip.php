<?php
ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require 'config.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

$id = $_POST['id'] ?? null;

if ($id !== null) {
    $stmt = $conn->prepare("DELETE FROM sb_vip_system WHERE id = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "VIP deleted successfully!";
        } else {
            $_SESSION['error'] = "Error deleting VIP: No rows affected.";
        }
        
        $stmt->close();
    } else {
        $_SESSION['error'] = "Prepare failed: " . $conn->error;
    }
} else {
    $_SESSION['error'] = "Invalid VIP ID.";
}

$conn->close();
header("Location: list_vips.php");
exit();

ob_end_flush();
?>
