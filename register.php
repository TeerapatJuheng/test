<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Registration</title>
    <style>
        /* CSS เหมือนตัวอย่างก่อนหน้านี้ */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        h1 {
            color: #444;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        #message {
            margin-top: 15px;
            padding: 10px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            border-radius: 4px;
        }

        #error-message {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            border-radius: 4px;
        }

        #store-list {
            margin-top: 40px;
            max-width: 800px;
            width: 100%;
        }

        .store-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .store-item strong {
            font-size: 18px;
            color: #333;
        }

        .store-item hr {
            margin: 10px 0;
            border: none;
            border-top: 1px solid #eee;
        }

        .store-item p {
            margin: 5px 0;
        }
    </style>
    <script>
        function validateForm() {
            const name = document.forms["register-form"]["store_name"].value;
            const email = document.forms["register-form"]["store_email"].value;
            const phone = document.forms["register-form"]["store_phone"].value;
            const address = document.forms["register-form"]["store_address"].value;
            const errorMessage = document.getElementById('error-message');

            if (name === "" || email === "" || phone === "" || address === "") {
                errorMessage.textContent = "All fields are required!";
                return false;
            }

            // Optional: ตรวจสอบรูปแบบอีเมล
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                errorMessage.textContent = "Invalid email format!";
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <h1>Register Your Store</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "za0159753";
    $dbname = "messengerbox_web";
    $message = $error_message = "";

    // เชื่อมต่อกับฐานข้อมูล
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $store_name = $_POST['store_name'];
        $store_email = $_POST['store_email'];
        $store_phone = $_POST['store_phone'];
        $store_address = $_POST['store_address'];

        // ตรวจสอบเงื่อนไขการกรอกข้อมูล
        if (empty($store_name) || empty($store_email) || empty($store_phone) || empty($store_address)) {
            $error_message = "All fields are required!";
        } elseif (!filter_var($store_email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format!";
        } else {
            // เตรียมคำสั่ง SQL เพื่อแทรกข้อมูล
            $sql = "INSERT INTO stores (store_name, store_email, store_phone, store_address)
                    VALUES ('$store_name', '$store_email', '$store_phone', '$store_address')";

            if ($conn->query($sql) === TRUE) {
                $message = "Store registered successfully!";
            } else {
                $error_message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    // ดึงข้อมูลร้านค้าที่สมัครแล้ว
    $sql = "SELECT store_name, store_email, store_phone, store_address FROM stores";
    $result = $conn->query($sql);
    ?>

    <!-- ฟอร์มการสมัครสมาชิก -->
    <form id="register-form" name="register-form" method="POST" action="" onsubmit="return validateForm()">
        <input type="text" name="store_name" placeholder="Store Name" required><br>
        <input type="email" name="store_email" placeholder="Store Email" required><br>
        <input type="text" name="store_phone" placeholder="Store Phone" required><br>
        <textarea name="store_address" placeholder="Store Address" required></textarea><br>
        <button type="submit">Register</button>
    </form>

    <!-- แสดงผลลัพธ์การสมัคร -->
    <?php
    if (!empty($error_message)) {
        echo '<div id="error-message">' . $error_message . '</div>';
    } elseif (!empty($message)) {
        echo '<div id="message">' . $message . '</div>';
    }
    ?>

    <h2>Registered Stores</h2>
    <div id="store-list">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='store-item'><strong>" . $row["store_name"] . "</strong><hr>";
                echo "<p>Email: " . $row["store_email"] . "</p>";
                echo "<p>Phone: " . $row["store_phone"] . "</p>";
                echo "<p>Address: " . $row["store_address"] . "</p></div>";
            }
        } else {
            echo "<p>No stores registered yet.</p>";
        }

        // ปิดการเชื่อมต่อ
        $conn->close();
        ?>
    </div>

</body>
</html>
