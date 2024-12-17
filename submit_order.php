<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'majdool';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $password, $database);
    $conn->set_charset("utf8");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = trim($_POST['email']);
        $phone_number = trim($_POST['phone_number']);
        $address = trim($_POST['address']);
        $total_price = floatval($_POST['total_price']);

        if (empty($email) || empty($phone_number) || empty($address) || $total_price <= 0) {
            die("Invalid input. Please provide all the required details.");
        }

        $stmt = $conn->prepare("INSERT INTO orders (email, address, phone_number, total_price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $email, $address, $phone_number, $total_price);

        $stmt->execute();
    }
} catch (mysqli_sql_exception $e) {
    $error = "Database Error: " . $e->getMessage();
} finally {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .confirmation {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
        }
        .confirmation h2 {
            color: #28a745;
        }
        .confirmation p {
            color: #555;
            font-size: 1.1em;
        }
        .back-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background: #000;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="confirmation">
        <h2>Order Placed Successfully!</h2>
        <p>Your order has been placed.</p>
        <a href="Majdool.php" class="back-btn">Back to Shop</a>
    </div>
</body>
</html>
