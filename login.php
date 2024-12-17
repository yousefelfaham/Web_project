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
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Fetch user from the database
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $user['first_name']; // Store the first name in the session
                header("Location: majdool.php");
                exit();
            }// Ensure no further code is executed
             else {
                echo "Invalid password. <a href='login.html'>Try again</a>";
            }
        } else {
            echo "No user found with this email. <a href='login.html'>Try again</a>";
        }

        $stmt->close();
    }
} catch (mysqli_sql_exception $e) {
    echo "Database error: " . $e->getMessage();
} finally {
    $conn->close();
}
?>
