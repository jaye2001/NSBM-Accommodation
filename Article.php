<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NSBM Accommodations - Articles</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" />
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

$web_constants = new Constants();

try {
    $db_obj = new DBConnection();
    $db_obj->connect();
    $pdo = $db_obj->get_conn();
    
    $stmt = $pdo->prepare("SELECT * FROM articles");
    $stmt->execute();
    // Fetch all rows as an associative array
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Could not connect to the database :" . $e->getMessage());
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <!-- Navbar content -->
</nav>

<div class="container mt-4">
  <div class="row">
    <!-- Check if we have articles -->
    <?php if (count($articles) > 0): ?>
      <?php foreach ($articles as $article): ?>
        <?php 
          $words = explode(' ', $article['content']);
          $excerpt = implode(' ', array_slice($words, 0, 30));
          $excerpt .= (count($words) > 30) ? '...' : '';
        ?>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($article['image']); ?>" class="bd-placeholder-img card-img-top" width="100%" height="225" alt="<?php echo htmlspecialchars($article['title']); ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h5>
              <p class="card-text"><?php echo htmlspecialchars($excerpt); ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <a href="article.php?id=<?php echo $article['article_id']; ?>" class="btn btn-sm btn-outline-secondary">Read More</a>
                </div>
                <small class="text-muted"><?php echo htmlspecialchars($article['updated_at']); ?></small>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <p>No articles to show. Please check back later.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<footer class="footer mt-4 py-3">
  <div class="container text-center">
    <span>© 2024 NSBM Green University Accommodation Finder. All rights reserved.</span>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
