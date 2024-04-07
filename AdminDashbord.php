<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - NSBM Accommodation Finder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f7fa;
            margin-top: 0;
        }
        .navbar {
            background-color: #333;
            padding: 0.8rem 1rem;
        }
        .navbar .navbar-brand {
            color: #fff;
        }
        .navbar .navbar-brand:hover {
            color: #ddd;
        }
        .content {
            padding: 2rem;
        }
        .card {
            margin-bottom: 1rem;
        }
        .card-title {
            margin-bottom: 0.5rem;
        }
        .card-text {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .icon {
            font-size: 2.5rem;
            margin-right: 1rem;
        }
        .fa-users { color: #f0ad4e; }
        .fa-building { color: #5cb85c; }
        .fa-calendar-alt { color: #d9534f; }
        .fa-file-alt { color: #5bc0de; }
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="AdminDashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user_management.php">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="property_management.php">Properties</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reservation_management.php">Reservations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="content_management.php">Content</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Dashboard Content -->
<div class="container content">
    <h2 class="my-4">Admin Dashboard</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <i class="fas fa-users icon"></i>
                    <span class="card-title">Users</span>
                    <p class="card-text">1020</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <i class="fas fa-building icon"></i>
                    <span class="card-title">Properties</span>
                    <p class="card-text">250</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <i class="fas fa-calendar-alt icon"></i>
                    <span class="card-title">Reservations</span>
                    <p class="card-text">75</p>
                </div>
            </div>
        </div>

    </div>


</div>

<!-- Footer -->
<div class="footer">
    © 2024 NSBM Green University Accommodation Finder. All rights reserved.
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
