<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

require 'config.php';
$result = $conn->query("SELECT id, vip_group, info FROM sb_vip_groups ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <title>VIP Groups</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      background-color: var(--bs-body-bg);
      height: 100%;
    }
    .table-wrapper {
      background: var(--bs-body-bg);
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.05);
      margin: 2rem auto;
      max-width: 95%;
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

<div class="container table-wrapper">
  <h2 class="text-center mb-4">VIP Groups</h2>
  <div class="d-flex justify-content-between mb-3">
    <a href="add_group.php" class="btn btn-outline-success">Add New Group</a>
    <a href="admin.php" class="btn btn-outline-primary">Back to Dashboard</a>
  </div>

  <table class="table table-bordered table-hover align-middle text-center">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Admin Group</th>
        <th>Info</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['vip_group']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['info'])) ?></td>
          <td>
            <a href="edit_group.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm me-1">Edit</a>
            <?php if ($_SESSION['role'] === 'owner'): ?>
              <form action="delete_group.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this group?');">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
              </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
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
