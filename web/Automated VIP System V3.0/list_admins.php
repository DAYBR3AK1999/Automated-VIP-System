<?php
session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

require 'config.php';

$result = $conn->query("SELECT id, username, role FROM users");

function displayEditButton($id, $username, $currentUsername, $currentRole) {
    if ($currentRole === 'owner' || ($currentRole === 'admin' && $username === $currentUsername)) {
        return "<a href=\"edit_admin.php?id=" . htmlspecialchars($id) . "\" class=\"btn btn-outline-primary btn-sm me-1\">Edit</a>";
    }
    return '';
}

function displayDeleteButton($id, $currentRole) {
    if ($currentRole === 'owner' && $id != 1) {
        return <<<HTML
        <form action="delete_admin.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this admin?');">
            <input type="hidden" name="id" value="{$id}">
            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
        HTML;
    }
    return '';
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Admin List</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
    .table-wrapper {
      background: var(--bs-body-bg);
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.05);
      max-width: 95%;
      width: 100%;
    }
    .text-center th, .text-center td {
      text-align: center;
      vertical-align: middle;
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
<div class="container-fluid full-height-center">
  <div class="table-wrapper">
    <h2 class="text-center mb-4">Admin List</h2>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td>
              <?= displayEditButton($row['id'], $row['username'], $_SESSION['username'], $_SESSION['role']) ?>
              <?= displayDeleteButton($row['id'], $_SESSION['role']) ?>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-center gap-3 mt-4">
      <?php if ($_SESSION['role'] === 'owner'): ?>
        <a href="add_admin.php" class="btn btn-outline-success">Add Admin</a>
      <?php endif; ?>
      <a href="admin.php" class="btn btn-outline-primary">Back to Dashboard</a>
      <a href="logout.php" class="btn btn-outline-secondary">Sign Out</a>
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
<?php $conn->close(); ?>
