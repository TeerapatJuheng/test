<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $store_name = $_POST['store_name'];
    $store_email = $_POST['store_email'];
    $store_phone = $_POST['store_phone'];
    $store_address = $_POST['store_address'];

    // เชื่อมต่อกับฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "za0159753";
    $dbname = "stores";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // เตรียมคำสั่ง SQL เพื่อแทรกข้อมูล
    $sql = "INSERT INTO stores (store_name, store_email, store_phone, store_address)
            VALUES ('$store_name', '$store_email', '$store_phone', '$store_address')";

    if ($conn->query($sql) === TRUE) {
        echo "Store registered successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
