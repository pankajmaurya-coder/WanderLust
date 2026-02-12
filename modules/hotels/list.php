<?php
session_start();
require_once __DIR__ . "/../../config/function.php"; 

$obj = new Query();

if (!isset($_SESSION['user_id']) && !empty($_COOKIE['remember_token'])) {

    $user = $obj->getRememberUser($_COOKIE['remember_token']);

    if ($user) {

        session_regenerate_id(true);

        $_SESSION['user_id']    = $user['id'];
        $_SESSION['user_name']  = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role']  = $user['role'];
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

?> 
<?php
require_once __DIR__ . "/../..//include/header.php"; 
require_once __DIR__ . "/../..//include/sidebar.php"; 
require_once __DIR__ . "/../../config/function.php"; 
$obj = new Query();


$hotels = $obj->viewdata("hotel");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hotels List</title>
  <link rel="stylesheet"   href="/PANKAJ/WANDERLUST/public/css/hotel.css">

</head>
<body class="page-list">
 
<?php 
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin')
 {
    echo '<a href="add.php" class="add-btn">Add New Hotel</a>';
}
?>


<div class="hotel-list">
  <?php if (!empty($hotels)): ?>
    <?php foreach ($hotels as $row): ?>
        
      <div class="hotel-card" >
         <a href="view.php?id=<?= htmlspecialchars($row['id']) ?>">
          <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
        </a> 
        <div class="hotel-info">
          <h3 class="title"><?= htmlspecialchars($row['title']) ?></h3>
          <p class="price">₹<?= htmlspecialchars($row['price']) ?></p>
          <p class="location">
            <?= htmlspecialchars($row['location']) ?>, <?= htmlspecialchars($row['country']) ?>
          </p>
        </div>
        
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="no-data"> No hotels available! Please add one.</p>
  <?php endif; ?>
</div>
<?php require_once __DIR__ . "/../..//include/footer.php";  ?>
</body>
</html> 