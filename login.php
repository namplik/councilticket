<?php
session_start();
if(isset($_POST['login'])){
    if($_POST['username']=="admin" && $_POST['password']=="1234"){
        $_SESSION['admin']="admin";
        header("Location: main.php");
        exit();
    }else{
        $error="Username หรือ Password ผิด";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#0f0f14;color:white;}
.card{background:#1a1a22;padding:30px;border-radius:15px;}
.btn-purple{background:#6f42c1;color:white;}
.btn-purple:hover{background:#5a32a3;color:white;}
input{background:#1a1a22 !important;color:white !important;border:1px solid #6f42c1 !important;}
</style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card shadow" style="width:350px;">
<h4 class="text-center mb-4" style="color:#c084fc;">Admin Login</h4>

<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>";?>

<form method="post">
<input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
<input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
<button name="login" class="btn btn-purple w-100">Login</button>
</form>
</div>

</body>
</html>