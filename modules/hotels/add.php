<?php
require_once __DIR__ . "/../../config/function.php"; 
$obj = new Query();
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $price       = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $location    = trim($_POST['location'] ?? '');
    $country     = trim($_POST['country'] ?? '');
    $image_url   = trim($_POST['image_url'] ?? '');

    // VALIDATION
    if ($title === '' || $price === '' || $description === '' || 
        $location === '' || $country === '' || $image_url === '') {
        throw new Exception("plese fill all the field");
    }
    
    $data = [
        'title'       => $title,
        'price'       => $price,
        'description' => $description,
        'location'    => $location,
        'country'     => $country,
        'image_url'   => $image_url
    ];

    try {
        $id = $obj->insertdata('hotel', $data); 
        if ($id > 0) {
            header("Location: list.php?success=1");
        } else {
           throw new Exception("fail to save data try again");
        }
        exit;
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
  rel="stylesheet" 
  integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
  crossorigin="anonymous">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
      <h4>Add New Hotel</h4>
    </div>
    <div class="card-body">
      <form action="add.php" method="POST">
        
        <div class="mb-3">
          <label for="title" class="form-label">Hotel Title</label>
          <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
          <label for="price" class="form-label">Price (₹)</label>
          <input type="number" class="form-control" id="price" name="price" min="1" step="0.01" required>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>

        <div class="mb-3">
          <label for="location" class="form-label">Location</label>
          <input type="text" class="form-control" id="location" name="location" required>
        </div>

        <div class="mb-3">
          <label for="country" class="form-label">Country</label>
          <input type="text" class="form-control" id="country" name="country" required>
        </div>

        <div class="mb-3">
          <label for="image_url" class="form-label">Image URL</label>
          <input type="url" class="form-control" id="image_url" name="image_url" placeholder="https://example.com/image.jpg" required>
        </div>

        <button type="submit" class="btn btn-success">Save Hotel</button>
        <a href="view.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </div>
</div>

</body>
</html>