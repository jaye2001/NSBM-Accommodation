<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advertisement Overview - NSBM Accommodation Finder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">

    <link href="css/main.css" rel="stylesheet">
</head>
<body>

<div class="flex-wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">NSBM Accommodations</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                    <a class="nav-item nav-link" href="dashboard_warden.php">Dashboard</a>
                    <a class="nav-item nav-link active" href="advertisement_overview.php">Advertisement Overview <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="<?php echo $web_constants->get_link('logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="ads-section">
        <div class="container">
            <h2>Advertisement Overview</h2>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Submitted By</th>
                        <th scope="col">Date Submitted</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Advertisement Row -->
                    <tr>
                        <th scope="row">1</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn btn-success btn-sm">Approve</button>
                            <button class="btn btn-danger btn-sm">Reject</button>
                            <button class="btn btn-primary btn-sm">View Details</button>
                        </td>
                    </tr>
                    <!-- Additional rows populated from the database -->
                </tbody>
            </table>
        </div>
    </div>

    <footer class="footer bg-dark text-white pt-4 pb-4">
        <div class="container text-center">
            <p>© 2024 NSBM Green University Accommodation Finder. All rights reserved.</p>
        </div>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
