<?php
session_start();
require 'config.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$result = $conn->query("SELECT id, name, steamid, added_by, code, expire, vip_group FROM sb_vip_system");

function displayEditButton($id) {
    return "<a href=\"edit.php?id=" . htmlspecialchars($id) . "\" class=\"btn btn-outline-primary btn-sm me-1\">Edit</a>";
}

function displayDeleteButton($id) {
    $csrf = htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');
    return <<<HTML
        <form action="delete_vip.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this VIP?');">
            <input type="hidden" name="id" value="{$id}">
            <input type="hidden" name="csrf_token" value="{$csrf}">
            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
        </form>
    HTML;
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>VIP List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            min-height: 100vh;
            background-color: var(--bs-body-bg);
        }
        .full-height-center {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .table-wrapper {
            background: var(--bs-body-bg);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0.75rem 1.5rem rgba(0,0,0,0.05);
            max-width: 95%;
            width: 100%;
        }
        .name-column {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
        <h2 class="text-center mb-4">VIP List</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>SteamID</th>
                        <th>Added By</th>
                        <th>Code</th>
                        <th>Expire</th>
                        <th>Admin Group</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td class="name-column" title="<?= htmlspecialchars($row['name']) ?>"><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['steamid']) ?></td>
                        <td><?= htmlspecialchars($row['added_by']) ?></td>
                        <td><?= htmlspecialchars($row['code']) ?></td>
                        <td><?= htmlspecialchars($row['expire']) ?></td>
                        <td><?= htmlspecialchars($row['vip_group']) ?></td>
                        <td>
                            <?php
                            if ($_SESSION['role'] === 'owner' || $_SESSION['username'] === $row['added_by']) {
                                echo displayEditButton($row['id']);
                                echo displayDeleteButton($row['id']);
                            }
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="add_vip.php" class="btn btn-outline-success">Add VIP</a>
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
