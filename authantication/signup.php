<?php
require_once __DIR__ . "/../config/function.php";

$obj = new Query();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name     = trim($_POST['name'] ?? '');
    $email    = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $country  = trim($_POST['country'] ?? '');
    $image    = trim($_POST['image_url'] ?? '');

    if ($name === '' || $email === '' || $password === '' || $country === '' || $image === '') {
     throw new Exception("please_fill_all_fields");
    }

    $email = preg_replace('/\s+/', '', $email);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         throw new Exception("Invalid email");
    }

    if (!filter_var($image, FILTER_VALIDATE_URL)) {
         throw new Exception("invalid image_url");
    }

    if (strlen($password) < 6) {
         throw new Exception("please enter minium 6 digit password");
    }

    if ($obj->emailExists('users', $email)) {
         throw new Exception("Email already exists"); 
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
   
    $role = 'user';
    if ($obj->totalUsers() === 0) {
        $role = 'admin';   
    }


    $data = [
        'name'      => $name,
        'email'     => $email,
        'password'  => $hashedPassword,
        'role'      => $role,
        'country'   => $country,
        'image_url' => $image
    ];

    try {
        $id = $obj->insertdata('users', $data);

        if ($id > 0) {
            header("Location: login.php?success=1");
        } else {
           throw new Exception("try again");
        }
    } catch (Exception $e) {
        error_log($e->getMessage()); 
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Signup</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h4 class="text-center mb-4">Create Account</h4>

                    <form method="POST" action="signup.php">
    
    <!-- Name -->
    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Choose a strong password" required>
    </div>

    <!-- Country -->
    <div class="mb-3">
        <label class="form-label">Country</label>
        <input type="text" name="country" class="form-control" placeholder="Type your country" required>
    </div>

    <!-- Image Link -->
    <div class="mb-3">
        <label class="form-label">Profile Image Link (Google)</label>
        <input type="url" name="image_url" class="form-control" placeholder="Paste image URL here" required>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-primary w-100" name= "submit">
        Sign Up
    </button>
  <a href ="login.php">Login</a>
</form>

 
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
