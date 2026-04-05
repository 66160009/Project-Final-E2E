<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

function isbnIncrement($digits) {
    $carry = 1;
    $result = '';

    for ($i = strlen($digits) - 1; $i >= 0; $i--) {
        $digit = intval($digits[$i]);
        $sum = $digit + $carry;
        $result = ($sum % 10) . $result;
        $carry = $sum >= 10 ? 1 : 0;
    }

    return $carry ? '1' . $result : $result;
}

function cleanIsbn($isbn) {
    return preg_replace('/\D/', '', $isbn);
}

function getNextIsbn($conn) {
    $default = '9786160000000';
    $result = mysqli_query($conn, "SELECT isbn FROM books");
    if (!$result) {
        return $default;
    }

    $max_isbn = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $digits = preg_replace('/\D/', '', $row['isbn']);
        if (strlen($digits) === 13 && ctype_digit($digits)) {
            if ($max_isbn === '' || strcmp($digits, $max_isbn) === 1) {
                $max_isbn = $digits;
            }
        }
    }

    if ($max_isbn === '') {
        return $default;
    }

    $next = isbnIncrement($max_isbn);
    if (strlen($next) < 13) {
        $next = str_pad($next, 13, '0', STR_PAD_LEFT);
    }

    return $next;
}


// Map category to prefix
function getCategoryPrefix($category) {
    $map = [
        'Computer' => 'A',
        'History' => 'D',
        'Economics' => 'C',
        'Fiction' => 'B',
    ];
    return isset($map[$category]) ? $map[$category] : 'A';
}

// Generate next shelf location for a given category
function getNextShelfLocation($conn, $category) {
    $prefix = getCategoryPrefix($category);
    $sql = "SELECT shelf_location FROM books WHERE shelf_location LIKE '" . $prefix . "-%' ORDER BY shelf_location DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $max_num = 0;
    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Expecting format: X-YYY
        $parts = explode('-', $row['shelf_location']);
        if (count($parts) == 2 && is_numeric($parts[1])) {
            $max_num = intval($parts[1]);
        }
    }
    $next_num = $max_num + 1;
    // Pad to 3 digits for consistency
    $next_code = sprintf('%s-%03d', $prefix, $next_num);
    return $next_code;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = getNextIsbn($conn);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $publisher = mysqli_real_escape_string($conn, $_POST['publisher']);
    $publication_year = intval($_POST['publication_year']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $total_copies = max(0, intval($_POST['total_copies']));
    // Always generate shelf location server-side for consistency
    $shelf_location = getNextShelfLocation($conn, $category);
    $shelf_location = mysqli_real_escape_string($conn, $shelf_location);
    
    $sql = "INSERT INTO books (isbn, title, author, publisher, publication_year, category, total_copies, available_copies, shelf_location) 
            VALUES ('$isbn', '$title', '$author', '$publisher', $publication_year, '$category', $total_copies, $total_copies, '$shelf_location')";
    
    if (!mysqli_query($conn, $sql)) {
        die('Error inserting book: ' . mysqli_error($conn));
    }
    
    header('Location: books.php');
    exit();
}
?>
