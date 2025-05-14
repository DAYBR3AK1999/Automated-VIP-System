<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

require 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid group ID.");
}

$result = $conn->prepare("SELECT * FROM sb_vip_groups WHERE id = ?");
$result->bind_param("i", $id);
$result->execute();
$groupData = $result->get_result()->fetch_assoc();

if (!$groupData) {
    die("Group not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vip_group = trim($_POST['vip_group']);
    $info = trim($_POST['info']);

    $update = $conn->prepare("UPDATE sb_vip_groups SET vip_group = ?, info = ? WHERE id = ?");
    $update->bind_param("ssi", $vip_group, $info, $id);
    $update->execute();

    header("Location: list_groups.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Edit VIP Group</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
      background-color: var(--bs-body-bg);
    }
    .centered-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .card {
      background: var(--bs-body-bg);
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.05);
      width: 100%;
      max-width: 500px;
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
<div class="container centered-container">
  <div class="card">
    <h3 class="text-center mb-4">Edit VIP Group</h3>
    <form method="post">
      <div class="mb-3">
        <label for="vip_group" class="form-label">Admin Group</label>
        <input type="text" id="vip_group" name="vip_group" class="form-control" value="<?= htmlspecialchars($groupData['vip_group']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="info" class="form-label">Description / Info</label>
        <textarea id="info" name="info" class="form-control" rows="4" required><?= htmlspecialchars($groupData['info']) ?></textarea>
      </div>
      <div class="d-flex justify-content-between">
        <a href="list_groups.php" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-outline-primary">Save Changes</button>
      </div>
    </form>
  </div>
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
