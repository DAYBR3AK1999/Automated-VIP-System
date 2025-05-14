<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'owner') {
    header("Location: index.php");
    exit();
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("sss", $username, $passwordHash, $role);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Admin added successfully!";
        header("Location: list_admins.php");
        exit();
    } else {
        $_SESSION['error'] = "Error adding admin: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Add Admin</title>
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
    .form-label, .form-control {
      text-align: left;
    }
    .btn-group {
      display: flex;
      gap: 10px;
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
  <h3 class="text-center mb-4">Add Admin</h3>
  <form method="post">
    <div class="mb-3">
      <label for="username" class="form-label">Username:</label>
      <input type="text" class="form-control" name="username" id="username" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password:</label>
      <input type="password" class="form-control" name="password" id="password" required>
    </div>
    <div class="mb-4">
      <label for="role" class="form-label">Role:</label>
      <select class="form-select" name="role" id="role">
        <option value="admin">Admin</option>
        <option value="owner">Owner</option>
      </select>
    </div>
    <div class="btn-group mt-3">
      <button type="submit" class="btn btn-outline-success w-50">Add Admin</button>
      <a href="list_admins.php" class="btn btn-outline-primary w-50">Back</a>
    </div>
    <a href="logout.php" class="btn btn-outline-secondary d-block mt-3">Logout</a>
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
<?php if (isset($conn)) $conn->close(); ?>
