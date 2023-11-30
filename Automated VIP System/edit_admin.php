<?php
session_start();
require 'config.php';
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || !in_array($_SESSION['role'], ['admin', 'owner'])) {
    header("Location: index.php");
    exit();
}

$adminData = ['id' => '', 'username' => '', 'role' => ''];
if (isset($_GET['id']) && ($_SESSION['role'] === 'owner' || $_GET['id'] == $_SESSION['user_id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT id, username, role FROM users WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $adminData = $result->fetch_assoc();
    } else {
        $_SESSION['error'] = 'Admin not found.';
        header("Location: list_admins.php");
        exit();
    }
    $stmt->close();
} else {
    $_SESSION['error'] = 'Invalid request.';
    header("Location: list_admins.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'] ?? $adminData['role'];
    if ($_SESSION['role'] === 'admin' || ($id == 1 && $_SESSION['role'] === 'owner')) {
        $role = $adminData['role'];
    }

    $stmt = $conn->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $role, $id);
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, role = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $role, $hashedPassword, $id);
    }

    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = 'Admin updated successfully.';
    } else {
        $_SESSION['error'] = 'No changes made or update failed.';
    }
    $stmt->close();
    header("Location: list_admins.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Admin</h1>
        <?php
        if (!empty($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        if (!empty($_SESSION['message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <form action="edit_admin.php?id=<?= $adminData['id'] ?>" method="post">
            <input type="hidden" name="id" value="<?= $adminData['id'] ?>">
            <div class="mb-3">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($adminData['username']) ?>" required class="form-control">
            </div>
            <div class="mb-3">
                <label for="password">Password (leave blank if you do not want to change it)</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <?php if ($_SESSION['role'] === 'owner' && $adminData['id'] != 1): ?>
            <div class="mb-3">
                <label for="role">Role</label>
                <select name="role" id="role" required class="form-control">
                    <option value="admin" <?= $adminData['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="owner" <?= $adminData['role'] == 'owner' ? 'selected' : '' ?>>Owner</option>
                </select>
            </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="list_admins.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
