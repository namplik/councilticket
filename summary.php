<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include("db.php");

// ===== ยอดรวมทั้งหมด =====
$totalAll = 0;
$resultTotal = $conn->query("SELECT SUM(amount) as total FROM orders");
if($row = $resultTotal->fetch_assoc()){
    $totalAll = $row['total'] ?? 0;
}

// ===== จำนวนรายการทั้งหมด =====
$countAll = 0;
$resultCount = $conn->query("SELECT COUNT(id) as total FROM orders");
if($row = $resultCount->fetch_assoc()){
    $countAll = $row['total'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>สรุปยอดรวม Ticket</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#0f0f14;
    color:white;
}
.header-title{
    color:#c084fc;
    font-weight:600;
}
.search-input::placeholder{
    color:#9ca3af;   /* สีเทา */
    opacity:1;
}

.search-input::-webkit-input-placeholder{
    color:#9ca3af;
}

.search-input:-ms-input-placeholder{
    color:#9ca3af;
}
.card-dark{
    background:#1a1a22;
    border-radius:15px;
    padding:20px;
}
.stat-box{
    background:#6f42c1;
    border-radius:12px;
    padding:20px;
    text-align:center;
}
.table{
    background:#1a1a22;
    color:white;
    border-radius:10px;
    overflow:hidden;
}
.table thead{
    background:#6f42c1;
}
.search-input{
    background:#1a1a22;
    border:1px solid #6f42c1;
    color:white;
}
.btn-purple{
    background:#6f42c1;
    color:white;
}
.btn-purple:hover{
    background:#5a32a3;
}
.section-title{
    color:#c084fc;
    font-weight:600;
    margin-bottom:15px;
}
</style>

</head>
<body>

<div class="container py-5">

<h2 class="text-center mb-4 header-title">
📊 สรุปยอดสะสมการซื้อ Ticket
</h2>

<!-- ===== Dashboard ===== -->
<div class="row mb-4 g-3">
    <div class="col-md-6">
        <div class="stat-box">
            <h6>ยอดรวมทั้งหมด</h6>
            <h4><?php echo number_format($totalAll); ?> Ticket</h4>
        </div>
    </div>
    <div class="col-md-6">
        <div class="stat-box">
            <h6>จำนวนรายการซื้อ</h6>
            <h4><?php echo number_format($countAll); ?> ครั้ง</h4>
        </div>
    </div>
</div>

<div class="row g-4">

<!-- ================= GANG ================= -->
<div class="col-md-6">
<div class="card-dark">

<h4 class="section-title">🔥 Gang</h4>

<input type="text" id="searchGang" 
       class="form-control search-input mb-3"
       placeholder="🔍 ค้นหา Gang...">

<div class="table-responsive">
<table class="table table-hover text-center align-middle" id="tableGang">
<thead>
<tr>
<th>ชื่อ</th>
<th>ยอดรวม</th>
<th>จำนวนครั้ง</th>
</tr>
</thead>
<tbody>

<?php
$sqlGang = "SELECT buyer,
                   SUM(amount) as total,
                   COUNT(id) as times
            FROM orders
            WHERE category = 'Gang'
            GROUP BY buyer
            ORDER BY total DESC";

$resultGang = $conn->query($sqlGang);

while($row = $resultGang->fetch_assoc()){
    echo "<tr>
    <td>".$row['buyer']."</td>
    <td style='font-weight:600;color:#c084fc;'>"
    .number_format($row['total'])."</td>
    <td>".$row['times']."</td>
    </tr>";
}
?>

</tbody>
</table>
</div>

</div>
</div>

<!-- ================= FAMILY ================= -->
<div class="col-md-6">
<div class="card-dark">

<h4 class="section-title">👨‍👩‍👧‍👦 Family</h4>

<input type="text" id="searchFamily" 
       class="form-control search-input mb-3"
       placeholder="🔍 ค้นหา Family...">

<div class="table-responsive">
<table class="table table-hover text-center align-middle" id="tableFamily">
<thead>
<tr>
<th>ชื่อ</th>
<th>ยอดรวม</th>
<th>จำนวนครั้ง</th>
</tr>
</thead>
<tbody>

<?php
$sqlFamily = "SELECT buyer,
                     SUM(amount) as total,
                     COUNT(id) as times
              FROM orders
              WHERE category = 'Family'
              GROUP BY buyer
              ORDER BY total DESC";

$resultFamily = $conn->query($sqlFamily);

while($row = $resultFamily->fetch_assoc()){
    echo "<tr>
    <td>".$row['buyer']."</td>
    <td style='font-weight:600;color:#c084fc;'>"
    .number_format($row['total'])."</td>
    <td>".$row['times']."</td>
    </tr>";
}
?>

</tbody>
</table>
</div>

</div>
</div>

</div>

<div class="text-center mt-5 d-flex justify-content-center gap-3 flex-wrap">

<a href="main.php" class="btn btn-purple px-4">
🏠 กลับหน้า Main
</a>

<a href="manage_orders.php" class="btn btn-outline-light px-4">
🗑 จัดการรายการซื้อ
</a>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// ===== Search Gang =====
$("#searchGang").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tableGang tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});

// ===== Search Family =====
$("#searchFamily").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tableFamily tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});
</script>

</body>
</html>