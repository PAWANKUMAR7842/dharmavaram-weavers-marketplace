<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dmm_db");
if($conn->connect_error){ 
    die("Connection failed: ".$conn->connect_error); 
}

// Handle Add to Cart
if(isset($_POST['add_to_cart'])){
    $qty = $_POST['quantity'];
    $id = $_POST['saree_id'];

    $stmt = $conn->prepare("SELECT * FROM sarees WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    $item = [
        'id' => $result['id'],
        'name' => $result['name'],
        'price' => $result['price'],
        'quantity' => $qty
    ];

    $_SESSION['cart'][] = $item;
    header("Location: card4.php");
    exit;
}

// Fetch all Upaada Sarees
$result = $conn->query("SELECT * FROM sarees WHERE type='upada'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upaada Silk Sarees</title>
<link rel="icon" type="image/png" href="../images/dmmlogo.png">
<style>
/* Global Styles */
:root {
    --primary: #8B0000;
    --primary-light: #a83232;
    --secondary: #D4AF37;
    --accent: #F5F5DC;
    --text: #321414;
    --text-light: #5c3a3a;
    --white: #ffffff;
    --gray: #e0e0e0;
    --dark-gray: #888;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: var(--accent);
    color: var(--text);
    line-height: 1.6;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

h1, h2, h3, h4, h5, h6 {
    font-weight: 700;
    color: var(--primary);
}

a {
    text-decoration: none;
    color: inherit;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: 600;
    transition: all 0.3s ease;
    cursor: pointer;
    border: none;
}

.btn-primary {
    background-color: var(--primary);
    color: var(--white);
}

.btn-primary:hover {
    background-color: var(--primary-light);
    transform: translateY(-2px);
}

.btn-secondary {
    background-color: var(--secondary);
    color: var(--text);
}

.btn-secondary:hover {
    background-color: #e0b83a;
    transform: translateY(-2px);
}

.btn-weaver {
    background-color: var(--secondary);
    color: var(--text);
    border-radius: 5px;
    padding: 8px 15px;
    font-weight: 600;
}

.btn-weaver:hover {
    background-color: #e0b83a;
}

.btn-more {
    background-color: var(--primary);
    color: var(--white);
    padding: 8px 15px;
    border-radius: 5px;
    font-size: 14px;
    display: inline-block;
    margin-top: 8px;
    width: 100%;
    text-align: center;
}

.btn-more:hover {
    background-color: var(--primary-light);
    transform: translateY(-2px);
}

.section-title {
    text-align: center;
    margin-bottom: 40px;
    position: relative;
    font-size: 2rem;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: var(--secondary);
}

/* Header Styles */
header {
    background-color: var(--white);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 15px 0;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    display: flex;
    align-items: center;
}

.logo img {
    height: 60px;
    margin-right: 15px;
}

.logo h1 {
    font-size: 1.8rem;
    color: var(--primary);
}

nav ul {
    display: flex;
    list-style: none;
}

nav ul li {
    margin-left: 25px;
}

nav ul li a {
    font-weight: 600;
    transition: color 0.3s ease;
}

nav ul li a:hover {
    color: var(--primary);
}

nav ul li a.active {
    color: var(--primary);
    position: relative;
}

nav ul li a.active::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: var(--primary);
}

.mobile-menu {
    display: none;
    font-size: 1.5rem;
    cursor: pointer;
}

/* Hero Section */
.hero {
    padding: 80px 0 60px;
    background: linear-gradient(135deg, var(--accent) 0%, #f0e8c8 100%);
}

.hero .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.hero-content {
    flex: 1;
    padding-right: 40px;
}

.hero-content h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: var(--primary);
}

.hero-content p {
    font-size: 1.1rem;
    margin-bottom: 30px;
    color: var(--text-light);
}

.hero-image {
    flex: 1;
    text-align: center;
}

.hero-image img {
    max-width: 100%;
    height: 460px;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(139, 0, 0, 0.2);
}

/* Sarees Section */
.sarees-section {
    padding: 60px 0;
    background-color: var(--white);
}

.saree-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.saree-card {
    background-color: var(--white);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    opacity: 0;
    transform: translateY(20px);
    animation: cardFadeIn 0.6s ease forwards;
}

.saree-card:nth-child(1) { animation-delay: 0.1s; }
.saree-card:nth-child(2) { animation-delay: 0.2s; }
.saree-card:nth-child(3) { animation-delay: 0.3s; }
.saree-card:nth-child(4) { animation-delay: 0.4s; }
.saree-card:nth-child(5) { animation-delay: 0.5s; }
.saree-card:nth-child(6) { animation-delay: 0.6s; }

.saree-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.saree-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.saree-card:hover img {
    transform: scale(1.05);
}

.saree-card h3 {
    padding: 15px 15px 10px;
    font-size: 1.1rem;
    text-align: center;
    flex-grow: 1;
}

.card-footer {
    padding: 10px 15px 15px;
}

.card-footer p {
    margin-bottom: 10px;
    font-weight: 600;
    color: var(--primary);
    text-align: center;
}

.card-footer form {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.card-footer input[type="number"] {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
}

.card-footer button {
    background-color: var(--primary);
    color: var(--white);
    padding: 8px 12px;
    border-radius: 5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
}

.card-footer button:hover {
    background-color: var(--primary-light);
    transform: translateY(-2px);
}

/* Cart Link */
.cart-link {
    display: inline-block;
    margin: 20px 0;
    padding: 10px 20px;
    background-color: var(--secondary);
    color: var(--text);
    border-radius: 5px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.cart-link:hover {
    background-color: #e0b83a;
    transform: translateY(-2px);
}

/* Footer Styles */
footer {
    background-color: var(--primary);
    color: var(--white);
    padding: 40px 0 20px;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
}

.footer-section h3 {
    margin-bottom: 20px;
    font-size: 1.2rem;
    position: relative;
    padding-bottom: 10px;
}

.footer-section h3::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 2px;
    background-color: var(--secondary);
}

.footer-section p, .footer-section li {
    margin-bottom: 10px;
    font-size: 0.9rem;
    opacity: 0.9;
}

.footer-section ul {
    list-style: none;
}

.footer-section ul li {
    margin-bottom: 8px;
}

.footer-section ul li a:hover {
    color: var(--secondary);
}

.footer-section i {
    margin-right: 10px;
    color: var(--secondary);
    width: 20px;
    text-align: center;
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8rem;
}

.social-icons a {
    display: inline-block;
    margin-left: 15px;
    font-size: 1.2rem;
    color: var(--white);
    transition: color 0.3s ease;
}

.social-icons a:hover {
    color: var(--secondary);
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 1s ease-in-out;
}

.slide-in-left {
    animation: slideInLeft 1s ease-in-out;
}

.slide-in-right {
    animation: slideInRight 1s ease-in-out;
}

.pop-up {
    animation: popUp 0.5s ease-in-out;
}

/* Keyframes */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideInLeft {
    from {
        transform: translateX(-50px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideInRight {
    from {
        transform: translateX(50px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes popUp {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes cardFadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Styles */
@media (max-width: 992px) {
    .hero .container {
        flex-direction: column;
    }
    
    .hero-content {
        padding-right: 0;
        margin-bottom: 40px;
        text-align: center;
    }
    
    .hero-image {
        order: -1;
    }
}

@media (max-width: 768px) {
    nav ul {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background-color: var(--white);
        flex-direction: column;
        padding: 20px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    nav ul.show {
        display: flex;
    }
    
    nav ul li {
        margin: 10px 0;
    }
    
    .mobile-menu {
        display: block;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .hero-content h1 {
        font-size: 2rem;
    }
    
    .saree-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}

@media (max-width: 576px) {
    .logo h1 {
        font-size: 1.4rem;
    }
    
    .logo img {
        height: 40px;
    }
    
    .hero-content h1 {
        font-size: 1.8rem;
    }
    
    .saree-grid {
        grid-template-columns: 1fr;
    }
    
    .footer-bottom {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}
</style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="../images/dmmlogo.png" alt="DMM Sarees Logo">
                <h1>Dharmavaram Weavers</h1>
            </div>
            <nav>
                <div class="mobile-menu">☰</div>
                  <ul>
                        
                    <li><a href="../html/index.html" class="active">Home</a></li>
                    <li><a href="#sarees">Sarees</a></li>
                   <li><a href="../html/index.html#about">About</a></li>

                    <li><a href="../html/feedback.html">Feedback</a></li>
                    <li><a href="#foot">Contact</a></li>

                
                    <li><a href="../php/view_cart.php" class="active">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content slide-in-left">
                <h1>Upaada Silk Sarees</h1>
                <p>Elegantly handcrafted in Andhra Pradesh, Upaada Silk Sarees are known for their lightweight feel, lustrous texture, and exquisite zari borders that define grace and heritage.</p>
                <a href="#sarees" class="btn btn-primary">Explore Collection</a>
            </div>
            <div class="hero-image slide-in-right">
                <img src="../images/upada/mainupada.jpg" alt="Upaada Saree">
            </div>
        </div>
    </section>

    <!-- Sarees Section -->
    <section class="sarees-section" id="sarees">
        <div class="container">
            <h2 class="section-title">Our Upaada Collection</h2>
            <div class="saree-grid">
                <?php while($saree = $result->fetch_assoc()): ?>
                    <div class="saree-card">
                        <h3><?php echo $saree['name']; ?></h3>
                        <img src="../images/<?php echo $saree['image']; ?>" alt="<?php echo $saree['name']; ?>">
                        <div class="card-footer">
                            <p>Price: ₹<?php echo $saree['price']; ?></p>
                            <form method="post">
                                <input type="number" name="quantity" value="1" min="1" max="<?php echo $saree['stock']; ?>">
                                <input type="hidden" name="saree_id" value="<?php echo $saree['id']; ?>">
                                <button type="submit" name="add_to_cart">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="text-center">
                <a href="../php/view_cart.php" class="cart-link">View Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
                <br><br>
                <a href="../html/index.html" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer  id="foot">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>DMM Sarees brings you the finest collection of traditional and contemporary sarees, preserving the rich heritage of Indian handloom.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="../html/index.html">Home</a></li>
                        <li><a href="sarees.php">Sarees</a></li>
                        <li><a href="about.html">About Us</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <p><i>📍</i> Dharmavaram, Andhra Pradesh, India</p>
                    <p><i>📞</i> +91 9876543210</p>
                    <p><i>✉️</i> info@dmmsarees.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 DMM Sarees. All rights reserved.</p>
                <div class="social-icons">
                    <a href="#"><i>📱</i></a>
                    <a href="#"><i>📷</i></a>
                    <a href="#"><i>🐦</i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu').addEventListener('click', function() {
            document.querySelector('nav ul').classList.toggle('show');
        });
    </script>
</body>
</html>
