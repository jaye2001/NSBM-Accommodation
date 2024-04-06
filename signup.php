<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - NSBM Accommodation Finder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
 
    <link href="css/signup.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#"> &nbsp &nbsp   NSBM Accommodations Finder &nbsp</a>
    </div>
</nav>
<br><br><br>
<div class="container shadow mt-5">
    <h2 class="sign-up-title">Sign Up</h2>
    <form action="php/signup_process.php" method="POST">
        <div class="form-group">
            <label for="userType">I am a:</label>
            <select class="form-control" id="userType" name="userType" required>
                <option value="landlord">Landlord</option>
                <option value="warden">Warden</option>
                <option value="student">Student</option>

            </select>
        </div>
        <div class="form-group">
            <label for="userName">Name</label>
            <input type="text" class="form-control" id="userName" name="userName" placeholder="Enter Name" required>
        </div>
        <div class="form-group">
            <label for="userEmail">Email</label>
            <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Enter Email" required>
        </div>
        
        <div class="form-group">
             <label for="phoneNumber">Phone Number</label>
            <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter phone number" required>
        </div>

        <div class="form-group">
            <label for="userPassword">Password</label>
            <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Enter Password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
    </form>
</div>

<script src="js/signup.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
