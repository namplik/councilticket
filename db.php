<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

/*
|--------------------------------------------------------------------------
| รองรับทั้ง Railway (ENV) และ Local (MAMP)
|--------------------------------------------------------------------------
*/

$host = getenv('MYSQLHOST') ?: 'localhost';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';
$db   = getenv('MYSQLDATABASE') ?: 'railway';
$port = getenv('MYSQLPORT') ?: 3306;

/*
|--------------------------------------------------------------------------
| ตรวจสอบ mysqli extension
|--------------------------------------------------------------------------
*/
if (!extension_loaded('mysqli')) {
    die("MySQLi extension is not enabled. Make sure Railway is using PHP runtime.");
}

/*
|--------------------------------------------------------------------------
| เชื่อมต่อฐานข้อมูล
|--------------------------------------------------------------------------
*/
$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
