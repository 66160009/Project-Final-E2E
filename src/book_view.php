<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($book_id <= 0) {
    header('Location: books.php');
    exit();
}

$sql = "SELECT * FROM books WHERE book_id = $book_id";
$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    header('Location: books.php');
    exit();
}

$book = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">📚 Library System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="books.php">Books</a></li>
                    <li class="nav-item"><a class="nav-link" href="members.php">Members</a></li>
                    <li class="nav-item"><a class="nav-link" href="borrow.php">Borrow</a></li>
                    <li class="nav-item"><a class="nav-link" href="return.php">Return</a></li>
                    <li class="nav-item"><a class="nav-link" href="reports.php">Reports</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <?php echo htmlspecialchars($_SESSION['full_name']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2>View Book Details</h2>
                <p class="text-muted mb-0">รายละเอียดหนังสือ</p>
            </div>
            <a href="books.php" class="btn btn-secondary">Back to Books</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <h6>ISBN</h6>
                        <p><?php echo htmlspecialchars($book['isbn']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h6>Title</h6>
                        <p><?php echo htmlspecialchars($book['title']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h6>Author</h6>
                        <p><?php echo htmlspecialchars($book['author']); ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <h6>Publisher</h6>
                        <p><?php echo htmlspecialchars($book['publisher']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h6>Publication Year</h6>
                        <p><?php echo htmlspecialchars($book['publication_year']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h6>Category</h6>
                        <p><?php echo htmlspecialchars($book['category']); ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <h6>Total Copies</h6>
                        <p><?php echo htmlspecialchars($book['total_copies']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h6>Available Copies</h6>
                        <p><?php echo htmlspecialchars($book['available_copies']); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h6>Shelf Location</h6>
                        <p><?php echo htmlspecialchars($book['shelf_location']); ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h6>Status</h6>
                        <p>
                            <?php if ($book['available_copies'] > 0): ?>
                                <span class="badge bg-success">Available</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Unavailable</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
