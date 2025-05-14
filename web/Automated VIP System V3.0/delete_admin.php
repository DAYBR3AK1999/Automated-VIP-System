<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? 0;

    if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || !in_array($_SESSION['role'], ['owner', 'admin'])) {
        $_SESSION['error'] = "Unauthorized access.";
        header("Location: list_admins.php");
        exit();
    }

    // Only owner can delete any admin, admins can only delete themselves
    if ($id == 1 || ($_SESSION['role'] !== 'owner' && $id != $_SESSION['user_id'])) {
        $_SESSION['error'] = "You do not have permission to delete this account.";
        header("Location: list_admins.php");
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Admin deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting admin.";
    }

    $stmt->close();
    $conn->close();

    header("Location: list_admins.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: list_admins.php");
    exit();
}
