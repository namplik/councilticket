<?php
include("db.php");

if(isset($_POST['type']) && $_POST['type']=="buy"){

    $category      = $_POST['category'] ?? '';
    $buyer         = $_POST['buyer'] ?? '';
    $amount        = intval($_POST['amount'] ?? 0);
    $staff_name    = $_POST['staff_name'] ?? '';
    $council_name  = $_POST['council_name'] ?? '';

    if(empty($category) || empty($buyer) || empty($staff_name) || empty($council_name)){
        echo "<div class='alert alert-danger'>
        ❌ กรุณากรอกข้อมูลให้ครบ
        </div>";
        exit();
    }

    if($amount < 35000 || $amount > 1000000){
        echo "<div class='alert alert-danger'>
        ❌ จำนวนต้องอยู่ระหว่าง 35,000 - 1,000,000
        </div>";
        exit();
    }

    $stmt = $conn->prepare("
        INSERT INTO orders
        (category, buyer, amount, staff_name, council_name)
        VALUES (?,?,?,?,?)
    ");

    $stmt->bind_param(
        "ssiss",
        $category,
        $buyer,
        $amount,
        $staff_name,
        $council_name
    );

    if($stmt->execute()){
        echo "<div class='alert alert-success'>
        ✅ บันทึกสำเร็จ
        </div>";
    } else {
        echo "<div class='alert alert-danger'>
        ❌ เกิดข้อผิดพลาด
        </div>";
    }

    $stmt->close();
    $conn->close();
}
?>