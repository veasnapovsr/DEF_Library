<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'school_library';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Create and Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $borrow_id = $_POST['borrow_id'] ?? null;
    $user_id = $_POST['user_id'];
    $book_id = $_POST['book_id'];
    $borrow_date = $_POST['borrow_date'];
    $return_date = $_POST['return_date'];

    if ($borrow_id) {
        $sql = "UPDATE borrowedbooks SET user_id='$user_id', book_id='$book_id', borrow_date='$borrow_date', return_date='$return_date' WHERE borrow_id='$borrow_id'";
    } else {
        $sql = "INSERT INTO borrowedbooks (user_id, book_id, borrow_date, return_date) VALUES ('$user_id', '$book_id', '$borrow_date', '$return_date')";
    }
    $conn->query($sql);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $borrow_id = $_GET['delete'];
    $conn->query("DELETE FROM borrowedbooks WHERE borrow_id='$borrow_id'");
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch Data
$result = $conn->query("SELECT * FROM borrowedbooks");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Borrowed Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .container { margin-top: 50px; }
        .table th { background-color: #007bff; color: white; }
        .form-control, .btn { margin-bottom: 10px; }
        .btn { transition: 0.3s; }
        .btn:hover { transform: scale(1.05); }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Borrowed Books Management</h2>
        <div class="card p-4 shadow-lg">
            <form method="post">
                <input type="hidden" name="borrow_id" id="borrow_id">
                <div class="mb-3">
                    <label class="form-label">User ID:</label>
                    <input type="text" class="form-control" name="user_id" id="user_id" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Book ID:</label>
                    <input type="text" class="form-control" name="book_id" id="book_id" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Borrow Date:</label>
                    <input type="date" class="form-control" name="borrow_date" id="borrow_date" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Return Date:</label>
                    <input type="date" class="form-control" name="return_date" id="return_date">
                </div>
                <button type="submit" class="btn btn-primary w-100">Save</button>
            </form>
        </div>
        <table class="table table-bordered table-striped mt-4">
            <tr>
                <th>Borrow ID</th>
                <th>User ID</th>
                <th>Book ID</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['borrow_id'] ?></td>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['book_id'] ?></td>
                    <td><?= $row['borrow_date'] ?></td>
                    <td><?= $row['return_date'] ?></td>
                    <td>
                        <a href="?delete=<?= $row['borrow_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>