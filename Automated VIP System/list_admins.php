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
        return "<a href=\"edit_admin.php?id=$id\" class=\"btn btn-primary btn-sm\">Edit</a>";
    }
    return '';
}

function displayDeleteButton($id, $currentRole) {
    if ($currentRole === 'owner' && $id != 1) {
        return "<form action=\"delete_admin.php\" method=\"post\" style=\"display: inline;\">
                    <input type=\"hidden\" name=\"id\" value=\"$id\">
                    <button type=\"submit\" class=\"btn btn-danger btn-sm\">Delete</button>
                </form>";
    }
    return '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin List</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    /* Custom styles copied from list_vips.php */
    .name-column {
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .text-center th, .text-center td {
        text-align: center;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Admin List</h1>
    <div class="table-responsive">
        <table class="table table-striped text-center">
          <thead>
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Table content from PHP fetch loop -->
            <?php while ($row = $result->fetch_assoc()): ?>
<tr>
  <td><?= htmlspecialchars($row['id']); ?></td>
  <td><?= htmlspecialchars($row['username']); ?></td>
  <td><?= htmlspecialchars($row['role']); ?></td>
  <td>
    <?= displayEditButton($row['id'], $row['username'], $_SESSION['username'], $_SESSION['role']); ?>
    <?= displayDeleteButton($row['id'], $_SESSION['role']); ?>
  </td>
</tr>
<?php endwhile; ?>
          </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mb-3">
    <?php if ($_SESSION['role'] === 'owner'): ?>
        <a href="add_admin.php" class="btn btn-success me-2">Add Admin</a>
    <?php endif; ?>
    <a href="admin.php" class="btn btn-primary">Back to Dashboard</a>
    <a href="logout.php" class="btn btn-secondary ms-2">Sign Out</a>
  </div>
</body>
</html>
