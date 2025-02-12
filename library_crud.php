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

// Success message variable
$success_msg = "";

// ADD BOOK
if (isset($_POST['add'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "INSERT INTO Books (title, author, status) VALUES ('$title', '$author', '$status')";
    if ($conn->query($sql)) {
        header("Location: index.php?msg=Book Added Successfully");
        exit();
    }
}

// UPDATE BOOK
if (isset($_POST['update'])) {
    $book_id = $_POST['book_id'];
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "UPDATE Books SET title='$title', author='$author', status='$status' WHERE book_id=$book_id";
    if ($conn->query($sql)) {
        header("Location: index.php?msg=Book Updated Successfully");
        exit();
    }
}

// DELETE BOOK
if (isset($_GET['delete'])) {
    $book_id = $_GET['delete'];
    if ($conn->query("DELETE FROM Books WHERE book_id=$book_id")) {
        header("Location: index.php?msg=Book Deleted Successfully");
        exit();
    }
}

// FETCH ALL BOOKS
$result = $conn->query("SELECT * FROM Books");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">📚 Library Management System</h2>

    <!-- SUCCESS MESSAGE TOAST -->
    <?php if (isset($_GET['msg'])): ?>
    <div class="toast show position-fixed top-0 end-0 p-3" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1050;">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body"><?= htmlspecialchars($_GET['msg']) ?></div>
    </div>
    <?php endif; ?>

    <!-- ADD BOOK FORM -->
    <div class="card mb-4">
        <div class="card-header">➕ Add New Book</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-2">
                    <label class="form-label">Title:</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Author:</label>
                    <input type="text" class="form-control" name="author" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Status:</label>
                    <select class="form-select" name="status" required>
                        <option value="available">Available</option>
                        <option value="borrowed">Borrowed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success" name="add">Add Book</button>
            </form>
        </div>
    </div>

    <!-- BOOK LIST -->
    <h3>📖 Book List</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['book_id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['author'] ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td>
                    <a href="?edit=<?= $row['book_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="?delete=<?= $row['book_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- EDIT BOOK FORM (Only Shows When Editing) -->
    <?php if (isset($_GET['edit'])):
        $edit_id = $_GET['edit'];
        $edit_result = $conn->query("SELECT * FROM Books WHERE book_id=$edit_id");
        $edit_row = $edit_result->fetch_assoc();
    ?>
    <div class="card mt-4">
        <div class="card-header">✏️ Edit Book</div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="book_id" value="<?= $edit_row['book_id'] ?>">
                <div class="mb-2">
                    <label class="form-label">Title:</label>
                    <input type="text" class="form-control" name="title" value="<?= $edit_row['title'] ?>" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Author:</label>
                    <input type="text" class="form-control" name="author" value="<?= $edit_row['author'] ?>" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Status:</label>
                    <select class="form-select" name="status" required>
                        <option value="available" <?= $edit_row['status'] == 'available' ? 'selected' : '' ?>>Available</option>
                        <option value="borrowed" <?= $edit_row['status'] == 'borrowed' ? 'selected' : '' ?>>Borrowed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" name="update">Update Book</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
