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

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, role = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $role, $hashedPassword, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $role, $id);
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
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: var(--bs-body-bg);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        #themeToggle {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }
    </style>
</head>
<body>
<button id="themeToggle" class="btn btn-sm btn-outline-dark">🌚/☀️</button>
<div class="card">
    <h3 class="text-center mb-4">Edit Admin</h3>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <form action="edit_admin.php?id=<?= $adminData['id'] ?>" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($adminData['id']) ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" id="username" required class="form-control"
                   value="<?= htmlspecialchars($adminData['username']) ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password (optional):</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <?php if ($_SESSION['role'] === 'owner' && $adminData['id'] != 1): ?>
            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select name="role" id="role" required class="form-select">
                    <option value="admin" <?= $adminData['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="owner" <?= $adminData['role'] == 'owner' ? 'selected' : '' ?>>Owner</option>
                </select>
            </div>
        <?php endif; ?>
        <div class="d-flex justify-content-between gap-2 mt-4">
            <button type="submit" class="btn btn-outline-success w-100">Update</button>
            <a href="list_admins.php" class="btn btn-outline-primary w-100">Cancel</a>
        </div>
    </form>
</div>

<script>
  const html = document.documentElement;
  const toggle = document.getElementById('themeToggle');

  // Apply saved theme on load
  const savedTheme = localStorage.getItem('theme') || 'light';
  html.setAttribute('data-bs-theme', savedTheme);
  toggle.textContent = savedTheme === 'dark' ? '🌚/☀️' : '☀️/🌚';

  toggle.addEventListener('click', () => {
    const current = html.getAttribute('data-bs-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-bs-theme', next);
    localStorage.setItem('theme', next);
    toggle.textContent = next === 'dark' ? '🌚/☀️' : '☀️/🌚';
  });
</script>
</body>
</html>
