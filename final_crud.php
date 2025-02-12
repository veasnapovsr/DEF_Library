<?php
// Database Connection
$host = "localhost";
$user = "root";
$password = "";
$database = "school_library";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle different sections based on the tab selected
$section = $_GET['section'] ?? 'books';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">📚 Library Management System</h2>
    
    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item"><a class="nav-link <?= ($section == 'books') ? 'active' : '' ?>" href="?section=books">Books</a></li>
        <li class="nav-item"><a class="nav-link <?= ($section == 'borrowed') ? 'active' : '' ?>" href="?section=borrowed">Borrowed Books</a></li>
        <li class="nav-item"><a class="nav-link <?= ($section == 'users') ? 'active' : '' ?>" href="?section=users">Users</a></li>
    </ul>
    
    <?php 
    // Include the appropriate section
    if ($section == 'books') {
        include 'library_crud.php';
    } elseif ($section == 'borrowed') {
        include 'borrow_library.php';
    } elseif ($section == 'users') {
        include 'users_library.php';
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

