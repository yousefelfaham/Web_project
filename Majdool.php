<?php
// Connect to MySQL
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'majdool';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT id, name, price, image_url FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Majdool</title>
    <link rel="stylesheet" href="Majdool.css">
    <!-- Add Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <nav class="navbar">
            <h2 class="logo"><a href="login.html">Majdool</a></h2>
            <ul class="nav-links">
                <li><a href="Majdool.php">Products</a></li>
                <li><a href="about us.html">About</a></li>
                <li><a href="cart.html">View Cart</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Product Display -->
    <main>
        <div class="product-cards">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card" data-id="<?php echo htmlspecialchars($row['id']); ?>" data-name="<?php echo htmlspecialchars($row['name']); ?>" data-price="<?php echo htmlspecialchars($row['price']); ?>">
                        <div class="image">
                            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        </div>
                        <p class="product_name"><?php echo htmlspecialchars($row['name']); ?></p>
                        <p class="price"><b>EG <?php echo htmlspecialchars($row['price']); ?></b></p>
                        <button class="add">ADD TO CART</button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products available.</p>
            <?php endif; ?>
            <?php $conn->close(); ?>
        </div>
    </main>

    <!-- Footer Section -->
    <footer>
        <div class="footer-container">
            <section class="social-media">
                <h2>Connect with Us</h2>
                <div class="social-links">
                    <a href="https://www.facebook.com/profile.php?id=61564358075541" target="_blank" class="facebook" aria-label="Follow us on Facebook" rel="noopener">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/_majdool_/" target="_blank" class="instagram" aria-label="Follow us on Instagram" rel="noopener">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.tiktok.com/search?q=majdool&t=1733452557246" target="_blank" class="tiktok" aria-label="Follow us on TikTok" rel="noopener">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <a href="mailto:yaraelfaham@gmail.com" class="email" aria-label="Send us an email" rel="noopener">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </section>
            <div class="footer-info">
                <p>&copy; 2024 Majdool. All rights reserved.</p>
                <p><a href="privacy.html">Privacy Policy</a> | <a href="terms.html">Terms & Conditions</a></p>
            </div>
        </div>
    </footer>

    <script>
        // Add to Cart functionality
        const addToCartButtons = document.querySelectorAll('.add');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', () => {
                const card = button.closest('.card');
                const productId = card.dataset.id;
                const productName = card.dataset.name;
                const productPrice = card.dataset.price;

                const product = { id: productId, name: productName, price: productPrice };

                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                cart.push(product);

                localStorage.setItem('cart', JSON.stringify(cart));

                alert(`${productName} added to cart!`);
            });
        });
    </script>
</body>
</html>
