<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_code = mysqli_real_escape_string($conn, $_POST['member_code']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $member_type = mysqli_real_escape_string($conn, $_POST['member_type']);
    $registration_date = date('Y-m-d');

    // Check for duplicate member_code
    $dup_code = mysqli_query($conn, "SELECT member_id FROM members WHERE member_code = '$member_code'");
    if ($dup_code && mysqli_num_rows($dup_code) > 0) {
        echo '<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>Error</title>';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '<meta http-equiv="refresh" content="2;url=members.php">';
        echo '</head><body class="bg-light">';
        echo '<div class="container mt-5"><div class="alert alert-danger">';
        echo 'ไม่สามารถเพิ่มสมาชิกได้: Member Code <b>' . htmlspecialchars($member_code) . '</b> ถูกใช้แล้ว กรุณาใช้รหัสอื่น (ระบบจะกลับไปหน้า Members อัตโนมัติ)';
        echo '</div></div></body></html>';
        exit();
    }

    // Check for duplicate full_name
    $dup_name = mysqli_query($conn, "SELECT member_id FROM members WHERE full_name = '$full_name'");
    if ($dup_name && mysqli_num_rows($dup_name) > 0) {
        echo '<!DOCTYPE html><html lang="th"><head><meta charset="UTF-8"><title>Error</title>';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '<meta http-equiv="refresh" content="2;url=members.php">';
        echo '</head><body class="bg-light">';
        echo '<div class="container mt-5"><div class="alert alert-danger">';
        echo 'ไม่สามารถเพิ่มสมาชิกได้: ชื่อ <b>' . htmlspecialchars($full_name) . '</b> ถูกใช้แล้ว กรุณาใช้ชื่ออื่น (ระบบจะกลับไปหน้า Members อัตโนมัติ)';
        echo '</div></div></body></html>';
        exit();
    }

    // Set max_books based on member type
    $max_books = 3;
    if ($member_type == 'teacher') {
        $max_books = 5;
    } elseif ($member_type == 'public') {
        $max_books = 2;
    }

    $sql = "INSERT INTO members (member_code, full_name, email, phone, member_type, registration_date, max_books) 
            VALUES ('$member_code', '$full_name', '$email', '$phone', '$member_type', '$registration_date', $max_books)";

    if (!mysqli_query($conn, $sql)) {
        echo '<div class="alert alert-danger">Error adding member: ' . htmlspecialchars(mysqli_error($conn)) . '</div>';
        exit();
    }

    header('Location: members.php');
    exit();
}
?>
