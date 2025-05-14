<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

require 'config.php';

$vipData = [
    'id' => '',
    'name' => '',
    'steamid' => '',
    'code' => '',
    'expire' => ''
];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM sb_vip_system WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $vipData = $result->fetch_assoc();
    } else {
        $_SESSION['error'] = "No VIP found with the provided ID.";
        header("Location: list_vips.php");
        exit();
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $steamid = $_POST['steamid'] ?? '';
    $code = $_POST['code'] ?? '';
    $expire = $_POST['expire'] ?? '';

    $expire = (empty($expire)) ? NULL : date('Y-m-d H:i:s', strtotime($expire));

    $stmt = $conn->prepare("UPDATE sb_vip_system SET name = ?, steamid = ?, code = ?, expire = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $steamid, $code, $expire, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "VIP updated successfully!";
    } else {
        $_SESSION['message'] = $stmt->error
            ? "Error updating VIP: " . $stmt->error
            : "No changes were made or VIP not found.";
    }
    $stmt->close();
    header("Location: list_vips.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <title>Edit VIP</title>
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
    <h3 class="text-center mb-4">Edit VIP</h3>
    <form method="post" action="edit.php?id=<?= htmlspecialchars($vipData['id']) ?>">
        <input type="hidden" name="id" value="<?= htmlspecialchars($vipData['id']) ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($vipData['name']) ?>">
        </div>
        <div class="mb-3">
            <label for="steamid" class="form-label">SteamID:</label>
            <input type="text" class="form-control" id="steamid" name="steamid" required value="<?= htmlspecialchars($vipData['steamid']) ?>">
        </div>
        <div class="mb-3">
            <label for="code" class="form-label">Code:</label>
            <input type="text" class="form-control" id="code" name="code" required value="<?= htmlspecialchars($vipData['code']) ?>">
        </div>
        <div class="mb-3">
            <label for="expire" class="form-label">Expire (optional):</label>
            <input type="datetime-local" class="form-control" id="expire" name="expire"
                   value="<?= $vipData['expire'] ? htmlspecialchars(str_replace(' ', 'T', $vipData['expire'])) : '' ?>">
        </div>
        <div class="d-flex justify-content-between gap-2 mt-4">
            <button type="submit" class="btn btn-outline-success w-100">Update</button>
            <a href="list_vips.php" class="btn btn-outline-primary w-100">Cancel</a>
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
