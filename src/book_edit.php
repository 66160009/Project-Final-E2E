<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error = '';

if ($book_id <= 0) {
    header('Location: books.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = intval($_POST['book_id']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $publisher = mysqli_real_escape_string($conn, $_POST['publisher']);
    $publication_year = intval($_POST['publication_year']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $total_copies = max(0, intval($_POST['total_copies']));
    $available_copies = max(0, intval($_POST['available_copies']));
    $shelf_location = mysqli_real_escape_string($conn, $_POST['shelf_location']);

    if ($available_copies > $total_copies) {
        $available_copies = $total_copies;
    }

    $duplicate_check = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM books WHERE isbn = '$isbn' AND book_id != $book_id");
    if ($duplicate_check) {
        $row = mysqli_fetch_assoc($duplicate_check);
        if ($row['cnt'] > 0) {
            $error = 'ISBN นี้ถูกใช้งานแล้ว กรุณาใส่ ISBN ใหม่';
        }
    }

    if (empty($error)) {
        $sql = "UPDATE books SET isbn='$isbn', title='$title', author='$author', publisher='$publisher', publication_year=$publication_year, category='$category', total_copies=$total_copies, available_copies=$available_copies, shelf_location='$shelf_location', updated_at = NOW() WHERE book_id=$book_id";

        if (mysqli_query($conn, $sql)) {
            header('Location: books.php');
            exit();
        } else {
            $error = 'Unable to update book. Please try again.';
        }
    }

    $book = [
        'book_id' => $book_id,
        'isbn' => $isbn,
        'title' => $title,
        'author' => $author,
        'publisher' => $publisher,
        'publication_year' => $publication_year,
        'category' => $category,
        'total_copies' => $total_copies,
        'available_copies' => $available_copies,
        'shelf_location' => $shelf_location,
    ];
}

if (!isset($book)) {
    $sql = "SELECT * FROM books WHERE book_id = $book_id";
    $result = mysqli_query($conn, $sql);

    if (!$result || mysqli_num_rows($result) === 0) {
        header('Location: books.php');
        exit();
    }

    $book = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
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
                <h2>Edit Book</h2>
                <p class="text-muted mb-0">แก้ไขข้อมูลหนังสือ</p>
            </div>
            <a href="books.php" class="btn btn-secondary">Back to Books</a>
        </div>

        <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="book_edit.php?id=<?php echo $book_id; ?>">
                    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">ISBN</label>
                            <input type="text" class="form-control" name="isbn" value="<?php echo htmlspecialchars(formatIsbnInput($book['isbn'])); ?>" required maxlength="17" pattern="[0-9\-]{1,17}" title="กรอกเลข ISBN 13 หลัก พร้อมขีด">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Author</label>
                            <input type="text" class="form-control" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Publisher</label>
                            <input type="text" class="form-control" name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Publication Year</label>
                            <input type="number" class="form-control" name="publication_year" value="<?php echo htmlspecialchars($book['publication_year']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" name="category" value="<?php echo htmlspecialchars($book['category']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Shelf Location</label>
                            <input type="text" class="form-control" name="shelf_location" value="<?php echo htmlspecialchars($book['shelf_location']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total Copies</label>
                            <input type="number" class="form-control" name="total_copies" min="0" value="<?php echo htmlspecialchars($book['total_copies']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Available Copies</label>
                            <input type="number" class="form-control" name="available_copies" min="0" value="<?php echo htmlspecialchars($book['available_copies']); ?>" required>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="books.php" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php
function formatIsbnInput($isbn) {
    $digits = preg_replace('/\D/', '', $isbn);
    if (strlen($digits) !== 13) return $isbn;
    return substr($digits,0,3).'-'.substr($digits,3,3).'-'.substr($digits,6,3).'-'.substr($digits,9,3).'-'.substr($digits,12,1);
}
?>
