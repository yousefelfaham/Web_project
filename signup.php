<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'majdool';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Enable error reporting

try {
    $conn = new mysqli($host, $user, $password, $database);
    $conn->set_charset("utf8");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $firstName = $_POST['userName'];
        $lastName = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        // Validate passwords
        if ($password !== $confirmPassword) {
            throw new Exception("Passwords do not match.");
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
        $stmt->execute();

        // Redirect to login.html after successful signup
        header("Location: login.html");
        exit(); // Ensure no further code is executed
    }
} catch (mysqli_sql_exception $e) {
    echo "Database error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conn->close();
}
?>
