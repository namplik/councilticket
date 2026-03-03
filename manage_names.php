<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include("db.php");

// ===== AJAX SECTION =====
if(isset($_POST['action'])){

    // โหลดรายชื่อ
    if($_POST['action']=="get"){
        $category = $_POST['category'];
        $stmt = $conn->prepare("SELECT * FROM names WHERE category=? ORDER BY name ASC");
        $stmt->bind_param("s",$category);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while($row=$result->fetch_assoc()){
            $data[] = $row;
        }
        echo json_encode($data);
        exit();
    }

    // เพิ่มชื่อ
    if($_POST['action']=="add"){
        $category = $_POST['category'];
        $name = $_POST['name'];
        $stmt = $conn->prepare("INSERT INTO names(category,name) VALUES(?,?)");
        $stmt->bind_param("ss",$category,$name);
        $stmt->execute();
        echo "เพิ่มสำเร็จ";
        exit();
    }

    // ลบชื่อ
    if($_POST['action']=="delete"){
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM names WHERE id=?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        echo "ลบสำเร็จ";
        exit();
    }

    // แก้ไขชื่อ
    if($_POST['action']=="edit"){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $stmt = $conn->prepare("UPDATE names SET name=? WHERE id=?");
        $stmt->bind_param("si",$name,$id);
        $stmt->execute();
        echo "แก้ไขสำเร็จ";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการชื่อ Gang / Family</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<div class="container py-5">

<h3 class="text-center mb-4 text-warning">
⚙ จัดการรายชื่อ Gang / Family
</h3>

<div class="card bg-secondary p-4">

<div class="row g-3 mb-3">

<div class="col-md-4">
<select id="category" class="form-select">
<option value="Gang">Gang</option>
<option value="Family">Family</option>
</select>
</div>

<div class="col-md-5">
<input type="text" id="newName" class="form-control" placeholder="ชื่อใหม่">
</div>

<div class="col-md-3">
<button id="addBtn" class="btn btn-warning w-100">เพิ่มชื่อ</button>
</div>

</div>

<table class="table table-dark table-hover text-center">
<thead>
<tr>
<th>ID</th>
<th>ชื่อ</th>
<th>จัดการ</th>
</tr>
</thead>
<tbody id="nameTable"></tbody>
</table>

</div>

<div class="text-center mt-4">
<a href="index.php" class="btn btn-light">⬅ กลับหน้าหลัก</a>
</div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
function loadNames(){
    $.post("manage_names.php",
        {action:"get", category:$("#category").val()},
        function(data){
            let result = JSON.parse(data);
            let html="";
            result.forEach(row=>{
                html+=`
                <tr>
                    <td>${row.id}</td>
                    <td>
                        <input type="text" value="${row.name}" 
                               class="form-control nameInput">
                    </td>
                    <td>
                        <button class="btn btn-success btn-sm saveBtn"
                            data-id="${row.id}">บันทึก</button>
                        <button class="btn btn-danger btn-sm deleteBtn"
                            data-id="${row.id}">ลบ</button>
                    </td>
                </tr>`;
            });
            $("#nameTable").html(html);
        }
    );
}

$("#category").change(loadNames);
loadNames();

// เพิ่ม
$("#addBtn").click(function(){
    let name = $("#newName").val();
    $.post("manage_names.php",
        {action:"add", category:$("#category").val(), name:name},
        function(){
            $("#newName").val("");
            loadNames();
        }
    );
});

// ลบ
$(document).on("click",".deleteBtn",function(){
    if(confirm("ยืนยันการลบ?")){
        $.post("manage_names.php",
            {action:"delete", id:$(this).data("id")},
            loadNames
        );
    }
});

// แก้ไข
$(document).on("click",".saveBtn",function(){
    let id = $(this).data("id");
    let name = $(this).closest("tr").find(".nameInput").val();

    $.post("manage_names.php",
        {action:"edit", id:id, name:name},
        loadNames
    );
});
</script>

</body>
</html>