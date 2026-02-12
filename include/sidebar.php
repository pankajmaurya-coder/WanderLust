<?php
$userName  = $_SESSION['user_name'] ?? 'Guest';
$userRole  = $_SESSION['user_role'] ?? 'user';
$userImage = $_SESSION['user_image'] ?? '/PANKAJ/WanderLust/public/images/default.png';
?>

<style>
.profile-sidebar{
    width:260px;
    height:100vh;
    background:#0f172a;
    color:white;
    position:fixed;
    top:0;
    left:-270px;
    padding:25px 20px;
    transition:0.3s ease;
    z-index:9999;
    box-shadow:2px 0 15px rgba(0,0,0,0.3);
}

.profile-sidebar.active{
    left:0;
}

.sidebar-header{
    text-align:center;
    margin-bottom:25px;
}

.sidebar-header img{
    width:90px;
    height:90px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #38bdf8;
}

.sidebar-header h4{
    margin-top:10px;
}

.profile-sidebar a{
    display:block;
    color:#cbd5f5;
    text-decoration:none;
    padding:10px 5px;
    margin:6px 0;
    border-radius:6px;
}

.profile-sidebar a:hover{
    background:#1e293b;
    color:white;
}

.admin-link{
    background:#facc15;
    color:black !important;
    font-weight:bold;
}

.logout-btn{
    margin-top:15px;
    width:100%;
    background:#ef4444;
    border:none;
    padding:10px;
    color:white;
    border-radius:6px;
}
</style>

<!-- SIDEBAR -->
<div class="profile-sidebar" id="sidebar">

    <div class="sidebar-header">
        <img src="<?= $userImage ?>">
        <h4>Hello, <?= htmlspecialchars($userName) ?></h4>
    </div>

    <a href="/PANKAJ/WanderLust/index.php">Home</a>
    <a href="/PANKAJ/WanderLust/modules/hotels/list.php">Hotels</a>
    <a href="#">Restaurant</a>
    <a href="#">Contact</a>
    <a href="#">Blog</a>

    <?php if ($userRole === 'admin'): ?>
        <a href="/PANKAJ/WanderLust/modules/hotels/add.php" class="admin-link">
            + Add New Hotel
        </a>
    <?php endif; ?>

    <form method="POST" action="/PANKAJ/WanderLust/authantication/logout.php">
        <button class="logout-btn">Logout</button>
    </form>

</div>

<script>
const sidebar = document.getElementById("sidebar");
const logoBtn = document.getElementById("sidebarToggle");

logoBtn.addEventListener("click", (e)=>{
    e.stopPropagation();
    sidebar.classList.toggle("active");
});

document.addEventListener("click", (e)=>{
    if(!sidebar.contains(e.target)){
        sidebar.classList.remove("active");
    }
});
</script>
