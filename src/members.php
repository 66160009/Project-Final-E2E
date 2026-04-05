<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get all members
$sql = "SELECT * FROM members ORDER BY member_code";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Management</title>
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="books.php">Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="borrow.php">Borrow</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="return.php">Return</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reports.php">Reports</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <?php echo $_SESSION['full_name']; ?>
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
            <h2>Members Management</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                Add New Member
            </button>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Member Code</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Type</th>
                                <th>Max Books</th>
                                <th>Status</th>
                                <th>Registration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($member = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($member['member_code']); ?></td>
                                <td><?php echo htmlspecialchars($member['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($member['email']); ?></td>
                                <td>
                                <?php
                                    // Format phone for display: 081-234-5678
                                    $phone = preg_replace('/\D/', '', $member['phone']);
                                    if (strlen($phone) === 10) {
                                        echo htmlspecialchars(substr($phone,0,3) . '-' . substr($phone,3,3) . '-' . substr($phone,6));
                                    } else {
                                        echo htmlspecialchars($member['phone']);
                                    }
                                ?>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <?php echo ucfirst($member['member_type']); ?>
                                    </span>
                                </td>
                                <td><?php echo $member['max_books']; ?></td>
                                <td>
                                    <?php if ($member['status'] == 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php elseif ($member['status'] == 'suspended'): ?>
                                        <span class="badge bg-danger">Suspended</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $member['registration_date']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Member Modal -->
    <div class="modal fade" id="addMemberModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="member_add.php">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Member Code</label>
                            <!-- BUG 30: No auto-generation of member code -->
                            <input type="text" class="form-control" name="member_code" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <!-- BUG 31: No email format validation -->
                            <input type="text" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" id="phoneInput" maxlength="12" pattern="[0-9\-]{12}" placeholder="081-234-5678">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Member Type</label>
                            <select class="form-select" name="member_type" required>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                                <option value="public">Public</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Auto-format phone number as 081-234-5678
    document.addEventListener('DOMContentLoaded', function() {
        var addMemberModal = document.getElementById('addMemberModal');
        if (addMemberModal) {
            addMemberModal.addEventListener('shown.bs.modal', function () {
                var phoneInput = document.getElementById('phoneInput');
                if (phoneInput) {
                    phoneInput.addEventListener('input', function(e) {
                        let value = phoneInput.value.replace(/\D/g, '');
                        if (value.length > 10) value = value.slice(0, 10);
                        let formatted = value;
                        if (value.length > 3 && value.length <= 6) {
                            formatted = value.slice(0,3) + '-' + value.slice(3);
                        } else if (value.length > 6) {
                            formatted = value.slice(0,3) + '-' + value.slice(3,6) + '-' + value.slice(6);
                        }
                        phoneInput.value = formatted;
                    });
                }
            });
        }
    });
    </script>
</body>
</html>
