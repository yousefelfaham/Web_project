<?php
// Start session to access user data
session_start();

// Database connection settings
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'majdool';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    die("Error: You must be logged in to place an order. <a href='login.html'>Login here</a>");
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Establish database connection
    $conn = new mysqli($host, $user, $password, $database);
    $conn->set_charset("utf8");

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve logged-in user's email
        $email = $_SESSION['email'];

        // Retrieve form data
        $address = trim($_POST['address']);
        $phone_number = trim($_POST['phone_number']);
        $total_price = floatval($_POST['total_price']);

        // Input validation
        if (empty($address) || empty($phone_number) || $total_price <= 0) {
            die("Invalid input. Please go back and provide correct details.");
        }

        // Insert order into the database
        $stmt = $conn->prepare("INSERT INTO orders (email, address, phone_number, total_price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $email, $address, $phone_number, $total_price);

        if ($stmt->execute()) {
            echo "<h2>Order placed successfully!</h2>";
            echo "<p>Thank you for your purchase, <b>" . htmlspecialchars($email) . "</b>.</p>";
            echo "<p>Your total was <b>EG " . number_format($total_price, 2) . "</b>.</p>";
            echo "<a href='Majdool.php'>Continue Shopping</a>";
        } else {
            echo "<h3>Failed to place the order. Please try again later.</h3>";
        }

        $stmt->close();
    } else {
        echo "<h3>Invalid request. Please use the checkout form.</h3>";
    }
} catch (mysqli_sql_exception $e) {
    echo "<h3>Database Error: " . $e->getMessage() . "</h3>";
} finally {
    $conn->close();
}
?>
