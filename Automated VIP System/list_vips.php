<?php
session_start();

require 'config.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

$result = $conn->query("SELECT id, name, steamid, added_by, code, expire, admin_group FROM sb_vip_system");

function displayEditButton($id) {
    return "<a href=\"edit.php?id=$id\" class=\"btn btn-primary me-2\">Edit</a>";
}

function displayDeleteButton($id) {
    return <<<HTML
    <form action="delete_vip.php" method="post" style="display: inline;">
        <input type="hidden" name="id" value="$id">
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
HTML;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
	<style>
        /* Add this style to set a maximum width for the name column */
        .name-column {
            max-width: 150px; /* Set a max-width as you find appropriate */
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
        <h1 class="text-center mb-4">VIP List</h1>
        <div class="table-responsive"> <!-- Make table responsive for smaller screens -->
            <table class="table table-striped text-center"> <!-- Add text-center here -->
            <thead>
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
    <td><?php echo htmlspecialchars($row['id']); ?></td>
    <td class="name-column" title="<?php echo htmlspecialchars($row['name']); ?>">
        <?php echo htmlspecialchars($row['name']); ?>
    </td>
    <td><?php echo htmlspecialchars($row['steamid']); ?></td>
    <td><?php echo htmlspecialchars($row['added_by']); ?></td>
    <td><?php echo htmlspecialchars($row['code']); ?></td>
    <td><?php echo htmlspecialchars($row['expire']); ?></td>
    <td><?php echo htmlspecialchars($row['admin_group']); ?></td>
    <td>
        <?php 
        // Admins can only edit VIPs they added; owners can edit any, but if you want admins to edit any of the VIP's then replace this: "|| $_SESSION['username'] === $row['added_by']" by this "|| $_SESSION['role'] === 'admin'.
        if ($_SESSION['role'] === 'owner' || $_SESSION['username'] === $row['added_by']) {
            echo displayEditButton($row['id']);
        }
        // Admins can only delete VIPs they added; owners can delete any, if you want admins to delete any user then replace this: "|| $_SESSION['username'] === $row['added_by']" by this "|| $_SESSION['role'] === 'admin'.
        if ($_SESSION['role'] === 'owner' || $_SESSION['username'] === $row['added_by']) {
            echo displayDeleteButton($row['id']);
        }
        ?>
    </td>
</tr>
<?php endwhile; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-center mb-3">
            <a href="add_vip.php" class="btn btn-success me-2">Add VIP</a>
			<a href="admin.php" class="btn btn-primary me-2">Back to Dashboard</a>
            <a href="logout.php" class="btn btn-secondary me-2">Sign Out</a>
        </div>
    </div>
</body>
</html>

