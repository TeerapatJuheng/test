<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "za0159753";
$dbname = "stores";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT store_name, store_email, store_phone, store_address FROM stores";
$result = $conn->query($sql);

$stores = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $stores[] = $row;
    }
}

// ส่งข้อมูลเป็น JSON กลับไปที่ frontend
header('Content-Type: application/json');
echo json_encode($stores);

$conn->close();
?>
