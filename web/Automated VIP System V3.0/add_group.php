<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vip_group = trim($_POST['vip_group'] ?? '');
    $info = trim($_POST['info'] ?? '');

    if ($vip_group !== '' && $info !== '') {
        $stmt = $conn->prepare("INSERT INTO sb_vip_groups (vip_group, info) VALUES (?, ?)");
        $stmt->bind_param("ss", $vip_group, $info);
        $stmt->execute();
        header("Location: list_groups.php");
        exit();
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add VIP Group</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
      background-color: var(--bs-body-bg);
    }
    .form-wrapper {
      background: var(--bs-body-bg);
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.05);
      max-width: 600px;
      margin: 2rem auto;
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
<div class="container form-wrapper">
  <h2 class="mb-4 text-center">Add New VIP Group</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label for="vip_group" class="form-label">Admin Group</label>
      <input type="text" name="vip_group" id="vip_group" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="info" class="form-label">Info</label>
      <textarea name="info" id="info" class="form-control" rows="4" required></textarea>
    </div>
    <div class="d-flex justify-content-between">
      <button type="submit" class="btn btn-success">Create Group</button>
      <a href="list_groups.php" class="btn btn-secondary">Cancel</a>
    </div>
  </form>
</div>
<script>
  const html = document.documentElement;
  const toggle = document.getElementById('themeToggle');
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
<?php $conn->close(); ?>
