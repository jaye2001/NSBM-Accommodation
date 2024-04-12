<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Article - NSBM Accommodations</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
  <style>
    .footer {
      background-color: #343a40;
      color: white;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
    .container-custom {
      padding-top: 20px;
      padding-bottom: 20px;
    }
  </style>
</head>
<body>
    

    <?php
include_once 'php/utils/db.php';
include_once 'php/utils/constants.php';

session_start(); 

$web_constants = new Constants();
?>


<div class="flex-wrapper">
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
                    <a class="nav-link" href="AdminAddUser.php"> Add Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="AdminUserManage.php">Manage User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="AdminAddArticle.php">Post Article</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="auth/<?php echo $web_constants->get_link('logout'); ?>">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="container mt-5 mb-5">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="card p-4">
                <form action="#" method="post" enctype="multipart/form-data">
                  <div class="text-center mb-4">
                    <h2>ADD ARTICLE</h2>
                  </div>
                  <div id="errorblock" class="d-none text-center mb-3">
                    <p id="error" class="text-danger"></p>
                  </div>
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter title here">
                  </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe your article"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="image">Add Photo For Your Article</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit Article</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
  </div>

    <footer class="footer mt-4 py-3">
      <div class="container text-center">
        <p>© 2024 NSBM Green University Accommodation Finder. All rights reserved.</p>
      </div>
    </footer>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function showErrors(err) {
      document.getElementById("errorblock").classList.remove('d-none');
      document.getElementById("error").innerHTML = err;
    }
  </script>

    <?php
try {
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn(); 
} catch (PDOException $e) { 
  die("Could not connect to the database: " . $e->getMessage()); 
} if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING); 
  $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING); 
  if (isset($_SESSION['user_id'])) {
    $author_id = $_SESSION['user_id']; } else { echo "<script> alert('Please login to add an article.');</script>"; } 
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) { 
      $file_name = $_FILES["image"]["name"]; 
      $file_tmp_name = $_FILES["image"]["tmp_name"]; 
      $file_content = file_get_contents($file_tmp_name); 
    } else { 
      echo "<script> showErrors('*Error uploading image.');</script>"; 
    } 
    if (!$title || !$description) { 
      echo "<script> showErrors('*Fields cannot be empty.');</script>"; 
    } else { 
      try { 
        $stmt = $pdo->prepare("INSERT INTO articles (title, content, author_id, image) VALUES (:title, :description, :author_id, :image)"); 
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':author_id', $author_id); 
        $stmt->bindParam(':image', $file_content, PDO::PARAM_LOB); 
        $stmt->execute(); 
        echo "<script> alert('Article added successfully.'); </script>"; 
      } catch (PDOException $e) { 
        die('Article addition failed: ' .$e->getMessage()); 
      } 
    } 
  } 
      ?>
  </body>
</html>
