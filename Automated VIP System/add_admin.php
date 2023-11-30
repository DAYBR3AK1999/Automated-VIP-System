<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['role'] !== 'owner') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'config.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param("sss", $username, $passwordHash, $role);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Admin added successfully!";
        header("Location: list_admins.php");
        exit();
    } else {
        $_SESSION['error'] = "Error adding admin: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .form-control, .btn, .form-label {
      width: 100%; /* Set the width to 100% of the parent */
      max-width: 330px; /* Match the login page width or adjust as needed */
      margin: auto; /* Center align the form elements */
    }
    .form-group {
      margin-bottom: 1rem;
    }
    .btn-group {
      display: flex;
      margin: 0 0.5rem; /* Add margin to the left and right of buttons for spacing */
      justify-content: space-between; /* Separate the buttons */
      gap: 10px; /* Add some space between buttons */
    }
    .btn-group .btn:first-child {
      margin-left: 0; /* Remove left margin for the first button */
    }
    .btn-group .btn:last-child {
      margin-right: 0; /* Remove right margin for the last button */
    }
    .btn-secondary {
      width: auto; /* Allow 'Generate' button to size itself */
    }
    #app {
      max-width: 330px;
      margin: auto;
    }
    .hidden {
      display: none;
    }
    .btn {
      border: 1px solid transparent; /* Add default border */
    }
    .btn:focus, .btn:hover {
      border: 1px solid #ddd; /* Change border color on hover/focus */
    }
    </style>
</head>
<body class="py-5 bg-light">
    <div class="container" id="app">
        <div class="row justify-content-center">
            <div class="col">
                <h1 class="text-center mb-4">Add New Admin</h1>
                <form action="add_admin.php" method="post" class="text-center">
                    <div class="form-group">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role" class="form-label">Role:</label>
                        <select class="form-select" id="role" name="role">
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="submit" class="btn btn-success">Add Admin</button>
                        <a href='list_admins.php' class="btn btn-primary">Back</a>
                    </div>
                    <div class="form-group">
                        <a href='logout.php' class="btn btn-secondary d-block mt-2">Logout</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
