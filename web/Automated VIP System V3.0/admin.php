<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
      background-color: var(--bs-body-bg);
    }
    .full-height-center {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .dashboard-card {
      background: var(--bs-body-bg);
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
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
<div class="container full-height-center">
  <div class="dashboard-card text-center">
    <h2 class="mb-4">Admin Dashboard</h2>
    <div class="d-grid gap-3">
      <a href="list_vips.php" class="btn btn-outline-success btn-lg">VIP List</a>
      <a href="list_admins.php" class="btn btn-outline-secondary btn-lg">Admin List</a>
	  <a href="list_groups.php" class="btn btn-outline-warning btn-lg">Group List</a>
      <a href="logout.php" class="btn btn-outline-primary btn-lg">Sign Out</a>
    </div>
  </div>
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
