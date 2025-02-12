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

// Fetch Books for Search
$searchResult = "";
if (isset($_GET['query'])) {
    $query = $conn->real_escape_string($_GET['query']);
    $sql = "SELECT * FROM books WHERE title LIKE '%$query%' OR author LIKE '%$query%'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $searchResult .= "<p><strong>{$row['title']}</strong> by {$row['author']} ({$row['status']})</p>";
    }
    if ($result->num_rows == 0) {
        $searchResult = "<p>No books found.</p>";
    }
}

// Static Digital Resources (Ensures Borders)
$resourcesList = "
    <div class='col-md-4'>
        <div class='card border'>
            <img src='https://source.unsplash.com/400x300/?ebook' class='card-img-top' alt='Ebooks'>
            <div class='card-body'>
                <h5 class='card-title'>E-Books</h5>
                <p class='card-text'>Access thousands of e-books online.</p>
                <a href='#' class='btn btn-primary'>Explore</a>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='card border'>
            <img src='https://source.unsplash.com/400x300/?research' class='card-img-top' alt='Research'>
            <div class='card-body'>
                <h5 class='card-title'>Research Databases</h5>
                <p class='card-text'>Find scholarly articles and resources.</p>
                <a href='#' class='btn btn-primary'>Access</a>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='card border'>
            <img src='https://source.unsplash.com/400x300/?library' class='card-img-top' alt='Library Services'>
            <div class='card-body'>
                <h5 class='card-title'>Library Services</h5>
                <p class='card-text'>Learn about borrowing, returns, and policies.</p>
                <a href='#' class='btn btn-primary'>Learn More</a>
            </div>
        </div>
    </div>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .hero { background: url('https://source.unsplash.com/1600x900/?library,books') center/cover no-repeat; height: 50vh; display: flex; align-items: center; justify-content: center; color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.7); }
        .card { border: 2px solid #ddd; border-radius: 8px; }
        .card img { height: 200px; object-fit: cover; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">School Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#catalog">Catalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="#resources">Resources</a></li>
                    <li class="nav-item"><a class="nav-link" href="#events">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <header class="hero text-center" >
        <h1>Bienvenue au D'épartement d'études Francophones</h1>
    </header>
    
    <section id="catalog" class="container py-5">
        <h2 class="text-center">Search the Catalog</h2>
        <form method="GET">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="query" placeholder="Search for books...">
                <button class="btn btn-primary">Search</button>
            </div>
        </form>
        <p class="text-center"><?= $searchResult ?></p>
    </section>
    
    <section id="resources" class="container py-5">
        <h2 class="text-center">Digital Resources</h2>
        <div class="row"><?= $resourcesList ?></div>
    </section>
    
    <section id="events" class="container py-5">
        <h2 class="text-center">Upcoming Events</h2>
        <ul class="list-group">
            <li class="list-group-item">📖 Book Fair - March 10th</li>
            <li class="list-group-item">📚 Reading Challenge - April 1st</li>
            <li class="list-group-item">📝 Writing Workshop - May 15th</li>
        </ul>
    </section>
    
    <section id="contact" class="container py-5 text-center">
        <h2>Contact Us</h2>
        <p>Email: library@school.edu | Phone: +123 456 7890</p>
    </section>
    
    <footer class="bg-dark text-white text-center py-3">&copy; All Right reserved @Veasna POV</footer>
</body>
</html>
