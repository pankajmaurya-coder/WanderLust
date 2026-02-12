<?php
require_once __DIR__ . "/../../config/function.php";
$obj = new Query();

$id = isset($_GET['id']) ? (int) $_GET['id'] : (int) ($_POST['id'] ?? 0);

if ($id <= 0) {
    throw new Exception("invalid id");
}


try {
    $hotel = $obj->getdata('hotel', $id);
} catch (Exception $e) {
     error_log($e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title       = trim($_POST['title'] ?? '');
    $price       = trim($_POST['price'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $location    = trim($_POST['location'] ?? '');
    $country     = trim($_POST['country'] ?? '');
    $image_url   = trim($_POST['image_url'] ?? '');

    if (
        $title === '' || $price === '' || $description === '' ||
        $location === '' || $country === '' || $image_url === ''
    ) {
     throw new Exception("plese fill all the field");
    } 
        try {

            $obj->updatedata('hotel', $id, [
                'title'       => $title,
                'price'       => $price,
                'description' => $description,
                'location'    => $location,
                'country'     => $country,
                'image_url'   => $image_url
            ]);
            header("Location: list.php?success=updated");
            exit;

        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Hotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-lg">

    <div class="card-header bg-warning">
      <h4>Edit Hotel</h4>
    </div>

    <div class="card-body">

      <form method="POST" action="edit.php?id=<?php echo $id; ?>">

        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <div class="mb-3">
          <label class="form-label">Hotel Title</label>
          <input
            type="text"
            class="form-control"
            name="title"
            value="<?php echo htmlspecialchars($_POST['title'] ?? $hotel['title']); ?>"
            required>
        </div>

        <div class="mb-3">
          <label class="form-label">Price (₹)</label>
          <input
            type="number"
            class="form-control"
            name="price"
            min="1"
            step="0.01"
            value="<?php echo htmlspecialchars($_POST['price'] ?? $hotel['price']); ?>"
            required>
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea
            class="form-control"
            name="description"
            rows="3"
            required><?php
                echo htmlspecialchars($_POST['description'] ?? $hotel['description']);
          ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Location</label>
          <input
            type="text"
            class="form-control"
            name="location"
            value="<?php echo htmlspecialchars($_POST['location'] ?? $hotel['location']); ?>"
            required>
        </div>

        <div class="mb-3">
          <label class="form-label">Country</label>
          <input
            type="text"
            class="form-control"
            name="country"
            value="<?php echo htmlspecialchars($_POST['country'] ?? $hotel['country']); ?>"
            required>
        </div>

        <div class="mb-3">
          <label class="form-label">Image URL</label>
          <input
            type="url"
            class="form-control"
            name="image_url"
            value="<?php echo htmlspecialchars($_POST['image_url'] ?? $hotel['image_url']); ?>"
            required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>

      </form>

    </div>
  </div>
</div>

</body>
</html>
