<?php
session_start();
require_once __DIR__ . "/../config/function.php";

$obj = new Query();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
     throw new Exception("Email and password are required.");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format.");
    } else {

        $user = $obj->login('users',$email, $password);

        if (!$user) {
            throw new Exception("Invalid credentials.");
        } else {

            session_regenerate_id(true);

            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_name']  = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role']  = $user['role'];
  
             if (!empty($_POST['remember'])) {

                $token = $obj->createRememberToken($user['id']);

                setcookie(
                    "remember_token",
                    $token,
                    time() + (30 * 24 * 60 * 60), 
                    "/",
                    "",
                    false,
                    true
                );
            }
            if($user['role'] === 'admin'){
                header("Location: ../admin/dask.php");
                exit;
            }else{
                  header("Location: ../modules/hotels/list.php");
            exit;
            }
            
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
     rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">

        <h4 class="text-center mb-4">Login</h4>

        <form method="POST">

            <div class="mb-3">
                <input type="email" name="email" 
                       class="form-control" 
                       placeholder="Email" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" 
                       class="form-control" 
                       placeholder="Password" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" 
                       type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Login
            </button>

        </form>

    </div>
</div>

</body>
</html>
