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
        if ($stmt->error) {
            $_SESSION['error'] = "Error updating VIP: " . $stmt->error;
        } else {
            $_SESSION['message'] = "No changes were made or VIP not found with ID: $id";
        }
    }
    $stmt->close();
    header("Location: list_vips.php");
    exit();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit VIP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit VIP</h1>
        <form action="edit.php?id=<?= htmlspecialchars($vipData['id']) ?>" method="post">
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
    <?php if (!empty($vipData['expire'])): ?>
	
	<label for="expire" class="form-label">Expire:</label>
    <input type="datetime-local" class="form-control" id="expire" name="expire"
           value="<?= htmlspecialchars(str_replace(' ', 'T', $vipData['expire'])) ?>">
    <?php endif; ?>
</div>

            <button type="submit" class="btn btn-primary">Update VIP</button>
            <a href="list_vips.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    </script>
</body>
</html>