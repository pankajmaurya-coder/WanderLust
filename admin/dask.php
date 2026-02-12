<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: /PANKAJ/WanderLust/login.php?error=access_denied");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Control Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #111111;
        }
        .dashboard-card {
            border-radius: 12px;
            transition: 0.3s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .admin-header {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: white;
            border-radius: 12px;
            padding: 30px;
        }
        .admin-header h2 span {
            color: #ffdd57;
        }
    </style>
</head>
<body>

<div class="container my-5">

    <div class="admin-header mb-5">
        <h2>Welcome, <span>Pankaj Kumar</span> 👋</h2>
        <p class="mt-3">
            This is your central control panel. From here, you can manage admins,
            users, hotels, and system settings. You have full authority to control
            and monitor the entire platform securely.
        </p>
    </div>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card dashboard-card p-4 text-center">
                <h5>Create New Admin</h5>
                <p class="text-muted mt-2">
                    Add a new administrator who can manage system data and users.
                </p>
                <a href="create-admin.php" class="btn btn-primary mt-3">
                    Add Admin
                </a>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card dashboard-card p-4 text-center">
                <h5>View All Admins</h5>
                <p class="text-muted mt-2">
                    See all administrators and monitor their activities.
                </p>
                <a href="admins-list.php" class="btn btn-dark mt-3">
                    View Admins
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card p-4 text-center">
                <h5>View All Users</h5>
                <p class="text-muted mt-2">
                    Manage registered users, view details, or block accounts.
                </p>
                <a href="users-list.php" class="btn btn-success mt-3">
                    View Users
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card p-4 text-center">
                <h5>Manage Hotels</h5>
                <p class="text-muted mt-2">
                    Add, edit, or remove hotels listed on the platform.
                </p>
                <a href="/PANKAJ/WanderLust/modules/hotels/list.php" 
                class="btn btn-warning mt-3">
    Manage Hotels
</a>

            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card p-4 text-center">
                <h5>System Settings</h5>
                <p class="text-muted mt-2">
                    Configure application settings and security options.
                </p>
                <a href="settings.php" class="btn btn-secondary mt-3">
                    Settings
                </a>
            </div>
        </div>

        
        <div class="col-md-4">
            <div class="card dashboard-card p-4 text-center">
                <h5>Logout</h5>
                <p class="text-muted mt-2">
                    Safely exit from the admin control panel.
                </p>
                <a href="../authantication/logout.php" class="btn btn-danger mt-3">
                    Logout
                </a>
            </div>
        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
