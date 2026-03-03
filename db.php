<?php
$host = "switchyard.proxy.rlwy.net";
$port = "45554";
$user = "root";
$pass = "hMHPaJjqGSVlGNFvbOFQSTBNbUzSCiqa";
$db   = "railway";

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
