<!DOCTYPE html>
<html>
<head>
    <title>Travel Website</title>
    <link rel="stylesheet" href="/PANKAJ/WANDERLUST/public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
     crossorigin="anonymous">
</head>
<body>

<header class="main-header">
<div class="logo">
    <a href="/PANKAJ/WanderLust/index.php">
        <img src="/PANKAJ/WanderLust/include/logo.jpeg" alt="Travel Logo" style="height:40px;">
    </a>
</div>
<div class="welcome">
    <?php if (isset($_SESSION['user_name'])): ?>
        <h4>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?></h4>
    <?php endif; ?>
</div>
    <nav class="navbar">
        <a href="\PANKAJ\WanderLust\authantication\signup.php">Login</a>
        <a href="/PANKAJ/WANDERLUST/index.php">Home</a>
        <a href="/PANKAJ/WANDERLUST/modules/hotels/list.php">Hotels</a>
        <a href="#">Places</a>
        <a href="#">Restaurants</a>
        <a href="#">Contact</a>
         <a href="/PANKAJ/WANDERLUST/authantication/logout.php">Logout</a>
    </nav>

</header>