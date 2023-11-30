<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || ($_SESSION['role'] !== 'owner' && $_SESSION['role'] !== 'admin')) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="py-5 bg-light">
  <div class="container text-center">
    <h1 class="mb-4">Admin Dashboard</h1>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <a href="list_vips.php" class="btn btn-success btn-lg w-100 mb-3">VIP List</a>
        <a href="list_admins.php" class="btn btn-secondary btn-lg w-100 mb-3">Admin List</a>
		<a href="logout.php" class="btn btn-primary btn-lg w-100 mb-3">Sign Out</a>
      </div>
    </div>
  </div>
</body>
</html>
