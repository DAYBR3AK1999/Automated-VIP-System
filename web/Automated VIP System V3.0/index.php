<?php
session_start();
require 'config.php';

$error_message = '';

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];
            header("Location: admin.php");
            exit();
        } else {
            $error_message = 'Invalid username or password.';
        }
    } else {
        $error_message = 'Invalid username or password.';
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            background-color: var(--bs-body-bg);
        }
        .full-center {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background: var(--bs-body-bg);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.1);
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
<button id="themeToggle" class="btn btn-sm btn-outline-dark" title="Toggle Theme">🌚/☀️</button>

<div class="container-fluid full-center">
    <div class="login-box">
        <h2 class="text-center mb-4">Sign In</h2>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <form method="post" action="index.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-outline-primary">Sign In</button>
            </div>
        </form>
    </div>
</div>

<script>
    const toggle = document.getElementById('themeToggle');
    const html = document.documentElement;
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
