<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#0f0f14;
    color:white;
    font-family: 'Segoe UI', sans-serif;
}

/* Navbar */
.navbar{
    background:#1a1a22;
}
.navbar-brand{
    color:#c084fc !important;
    font-weight:600;
}
.admin-name{
    color:#c084fc;
    font-weight:500;
}

/* Dashboard Container */
.dashboard-wrapper{
    background:#1a1a22;
    padding:40px;
    border-radius:20px;
    box-shadow:0 0 25px rgba(111,66,193,0.2);
}

/* Card */
.dashboard-card{
    background:linear-gradient(145deg,#1a1a22,#111118);
    border-radius:20px;
    padding:35px;
    text-align:center;
    transition:0.3s;
    cursor:pointer;
    border:1px solid rgba(111,66,193,0.2);
}

.dashboard-card:hover{
    transform:translateY(-8px);
    background:linear-gradient(145deg,#6f42c1,#4b2e83);
    box-shadow:0 10px 30px rgba(111,66,193,0.5);
}

/* Icon */
.icon{
    font-size:45px;
    margin-bottom:15px;
}

/* Title */
.title{
    font-weight:600;
    font-size:18px;
}

/* Logout Card */
.logout-card{
    background:linear-gradient(145deg,#8b0000,#5a0000);
}

.logout-card:hover{
    background:linear-gradient(145deg,#b30000,#7a0000);
}
</style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg px-4 py-3">
<div class="container-fluid">
<span class="navbar-brand">🎫 Ticket Admin System</span>
<div class="ms-auto admin-name">
👤 <?php echo $_SESSION['admin']; ?>
</div>
</div>
</nav>

<div class="container py-5">

<div class="dashboard-wrapper">

<h2 class="text-center mb-5" style="color:#c084fc;">
⚙ Admin Control Panel
</h2>

<div class="row g-4">

<!-- ซื้อ -->
<div class="col-md-4">
<a href="index.php" class="text-decoration-none text-white">
<div class="dashboard-card">
<div class="icon">💰</div>
<div class="title">ซื้อ Ticket</div>
</div>
</a>
</div>

<!-- สรุป -->
<div class="col-md-4">
<a href="summary.php" class="text-decoration-none text-white">
<div class="dashboard-card">
<div class="icon">📊</div>
<div class="title">สรุปยอดรวม</div>
</div>
</a>
</div>

<!-- จัดการชื่อ -->
<div class="col-md-4">
<a href="manage_names.php" class="text-decoration-none text-white">
<div class="dashboard-card">
<div class="icon">📝</div>
<div class="title">จัดการชื่อ</div>
</div>
</a>
</div>

<!-- รายการซื้อ -->
<div class="col-md-4">
<a href="manage_orders.php" class="text-decoration-none text-white">
<div class="dashboard-card">
<div class="icon">🗑</div>
<div class="title">จัดการรายการซื้อ</div>
</div>
</a>
</div>

<!-- Logout -->
<div class="col-md-4">
<a href="logout.php" class="text-decoration-none text-white">
<div class="dashboard-card logout-card">
<div class="icon">🚪</div>
<div class="title">ออกจากระบบ</div>
</div>
</a>
</div>

</div>

</div>

</div>

</body>
</html>