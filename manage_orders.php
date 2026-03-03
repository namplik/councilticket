<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include("db.php");

// ===== ลบรายการ =====
if(isset($_POST['delete_id'])){
    $id = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM orders WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการรายการซื้อ</title>

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
.card-dark{
    background:#1a1a22;
    border-radius:15px;
    padding:25px;
    margin-bottom:40px;
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
.btn-purple{
    background:#6f42c1;
    color:white;
}
.btn-purple:hover{
    background:#5a32a3;
}
.btn-danger-custom{
    background:#dc3545;
    border:none;
}
.btn-danger-custom:hover{
    background:#b02a37;
}
.section-title{
    color:#c084fc;
    margin-bottom:15px;
}
</style>

</head>
<body>

<div class="container py-5">

<h2 class="text-center mb-5 header-title">
🗑 จัดการ / ลบรายการซื้อ
</h2>

<?php
$gang = $conn->query("SELECT * FROM orders WHERE category='Gang' ORDER BY id DESC");
$family = $conn->query("SELECT * FROM orders WHERE category='Family' ORDER BY id DESC");
?>

<!-- ================= GANG ================= -->
<div class="card-dark">
<h4 class="section-title">🔴 Gang</h4>

<div class="row mb-3">
<div class="col-md-6">
<input type="text" id="searchGang" class="form-control"
placeholder="🔍 ค้นหา Gang (ชื่อ / ผู้ทำรายการ / สภา)">
</div>
</div>

<div class="table-responsive">
<table class="table table-hover text-center align-middle" id="gangTable">
<thead>
<tr>
<th>ID</th>
<th>ชื่อ</th>
<th>จำนวน</th>
<th>ผู้ทำรายการ</th>
<th>สภาผู้รับผิดชอบ</th>
<th>วันที่</th>
<th>จัดการ</th>
</tr>
</thead>
<tbody>

<?php while($row = $gang->fetch_assoc()){ ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['buyer'] ?></td>
<td style="font-weight:600;color:#c084fc;">
<?= number_format($row['amount']) ?>
</td>
<td><?= $row['staff_name'] ?></td>
<td><?= $row['council_name'] ?></td>
<td><?= $row['created_at'] ?></td>
<td>
<button class="btn btn-danger-custom btn-sm deleteBtn"
data-id="<?= $row['id'] ?>">ลบ</button>
</td>
</tr>
<?php } ?>

</tbody>
</table>
</div>
</div>


<!-- ================= FAMILY ================= -->
<div class="card-dark">
<h4 class="section-title">🔵 Family</h4>

<div class="row mb-3">
<div class="col-md-6">
<input type="text" id="searchFamily" class="form-control"
placeholder="🔍 ค้นหา Family (ชื่อ / ผู้ทำรายการ / สภา)">
</div>
</div>

<div class="table-responsive">
<table class="table table-hover text-center align-middle" id="familyTable">
<thead>
<tr>
<th>ID</th>
<th>ชื่อ</th>
<th>จำนวน</th>
<th>ผู้ทำรายการ</th>
<th>สภาผู้รับผิดชอบ</th>
<th>วันที่</th>
<th>จัดการ</th>
</tr>
</thead>
<tbody>

<?php while($row = $family->fetch_assoc()){ ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['buyer'] ?></td>
<td style="font-weight:600;color:#c084fc;">
<?= number_format($row['amount']) ?>
</td>
<td><?= $row['staff_name'] ?></td>
<td><?= $row['council_name'] ?></td>
<td><?= $row['created_at'] ?></td>
<td>
<button class="btn btn-danger-custom btn-sm deleteBtn"
data-id="<?= $row['id'] ?>">ลบ</button>
</td>
</tr>
<?php } ?>

</tbody>
</table>
</div>
</div>


<div class="text-center mt-5 d-flex justify-content-center gap-3 flex-wrap">
<a href="summary.php" class="btn btn-purple px-4">
📊 สรุปยอดรวม
</a>

<a href="main.php" class="btn btn-outline-light px-4">
🏠 กลับหน้า Main
</a>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// ===== ลบ =====
$(".deleteBtn").click(function(){
    if(confirm("ยืนยันการลบรายการนี้?")){
        let id = $(this).data("id");
        $.post("manage_orders.php",
            {delete_id:id},
            function(){
                location.reload();
            }
        );
    }
});

// ===== Search Gang =====
$("#searchGang").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#gangTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});

// ===== Search Family =====
$("#searchFamily").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#familyTable tbody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});
</script>

</body>
</html>
