<?php
session_start();
require_once __DIR__ . "/../../config/function.php";
$obj = new Query();

try {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        throw new Exception("Invalid Request");
    }

    $id = (int) $_GET['id'];
    $hotel = $obj->getdata("hotel", $id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($hotel['title']) ?></title>
  <link rel="stylesheet" href="/PANKAJ/WANDERLUST/public/css/hotel.css">
</head>
<body class="page-view">

  <div class="hotel-view">
    <img src="<?= htmlspecialchars($hotel['image_url']) ?>"  
         alt="<?= htmlspecialchars($hotel['title']) ?>"  
         style="max-width:300px; height:auto; display:block; margin-bottom:15px;">

    <h2 class="title"><?= htmlspecialchars($hotel['title']) ?></h2>
    <p class="price">₹<?= htmlspecialchars($hotel['price']) ?></p>
    <p class="location"><?= htmlspecialchars($hotel['location']) ?>, <?= htmlspecialchars($hotel['country']) ?></p>
    <p class="description"><?= htmlspecialchars($hotel['description'])?></p>

    <!-- Buttons -->
    <div class="actions">
      <?php 
      if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
          echo '<a href="list.php" class="btn home">🏠 Home</a>';
          echo '<a href="edit.php?id=' . $hotel['id'] . '" class="btn edit">✏️ Edit</a>';
          echo '<a href="delete.php?id=' . $hotel['id'] . '" 
                   onclick="return confirm(\'Are you sure you want to delete this hotel?\')" 
                   class="btn delete">🗑️ Delete</a>';
      }
      ?>
    </div>
  </div>

</body>
</html>
<?php
} catch (Exception $e) {
  error_log($e->getMessage()) ;
}
?>