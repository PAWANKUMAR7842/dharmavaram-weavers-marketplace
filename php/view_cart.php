<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dmm_db");

// Handle Checkout
if(isset($_POST['checkout'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $total = 0;

    foreach($_SESSION['cart'] as $item){
        $total += $item['price'] * $item['quantity'];
    }

    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (customer_name,email,phone,address,total) VALUES (?,?,?,?,?)");
    $stmt->bind_param("ssssd",$name,$email,$phone,$address,$total);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Insert order items
    foreach($_SESSION['cart'] as $item){
        $stmt = $conn->prepare("INSERT INTO order_items (order_id,saree_id,quantity,price) VALUES (?,?,?,?)");
        $stmt->bind_param("iiid",$order_id,$item['id'],$item['quantity'],$item['price']);
        $stmt->execute();
    }

    // Clear cart
    unset($_SESSION['cart']);
    echo "<div class='success-message'>Order placed successfully! Your order ID is #$order_id</div>";
    exit;
}

// Handle Remove Item
if(isset($_GET['remove'])){
    $index = $_GET['remove'];
    if(isset($_SESSION['cart'][$index])){
        array_splice($_SESSION['cart'], $index, 1);
        header("Location: view_cart.php");
        exit;
    }
}

// Handle Update Quantity
if(isset($_POST['update_quantity'])){
    $index = $_POST['item_index'];
    $new_quantity = $_POST['quantity'];
    
    if(isset($_SESSION['cart'][$index]) && $new_quantity > 0){
        $_SESSION['cart'][$index]['quantity'] = $new_quantity;
        header("Location: view_cart.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Cart - DMM Sarees</title>

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

.btn-danger {
    background-color: #dc3545;
    color: var(--white);
}

.btn-danger:hover {
    background-color: #c82333;
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

/* Cart Section */
.cart-section {
    padding: 60px 0;
    background-color: var(--white);
    min-height: 70vh;
}

.cart-container {
    max-width: 1000px;
    margin: 0 auto;
}

.cart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--gray);
}

.cart-title {
    font-size: 2rem;
    color: var(--primary);
}

.cart-count {
    font-size: 1.2rem;
    color: var(--text-light);
}

/* Cart Table */
.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    overflow: hidden;
    animation: tableFadeIn 0.8s ease;
}

.cart-table th {
    background-color: var(--primary);
    color: var(--white);
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

.cart-table td {
    padding: 15px;
    border-bottom: 1px solid var(--gray);
    vertical-align: middle;
}

.cart-table tr {
    transition: all 0.3s ease;
    animation: rowSlideIn 0.5s ease forwards;
    opacity: 0;
    transform: translateX(-20px);
}

.cart-table tr:nth-child(1) { animation-delay: 0.1s; }
.cart-table tr:nth-child(2) { animation-delay: 0.2s; }
.cart-table tr:nth-child(3) { animation-delay: 0.3s; }
.cart-table tr:nth-child(4) { animation-delay: 0.4s; }
.cart-table tr:nth-child(5) { animation-delay: 0.5s; }

.cart-table tr:hover {
    background-color: rgba(139, 0, 0, 0.03);
}

.cart-item-name {
    font-weight: 600;
    color: var(--primary);
}

.cart-item-price, .cart-item-subtotal {
    font-weight: 600;
    color: var(--text);
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-input {
    width: 60px;
    padding: 8px;
    border: 1px solid var(--gray);
    border-radius: 5px;
    text-align: center;
}

.update-btn {
    background-color: var(--secondary);
    color: var(--text);
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.8rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.update-btn:hover {
    background-color: #e0b83a;
}

.remove-btn {
    background-color: transparent;
    color: #dc3545;
    border: none;
    cursor: pointer;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    padding: 5px;
    border-radius: 50%;
}

.remove-btn:hover {
    background-color: rgba(220, 53, 69, 0.1);
    transform: scale(1.1);
}

.cart-total {
    background-color: var(--accent);
    font-weight: 700;
    font-size: 1.2rem;
}

.cart-total td {
    padding: 20px 15px;
}

/* Checkout Form */
.checkout-section {
    background-color: var(--accent);
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    margin-top: 30px;
    animation: formSlideUp 0.6s ease;
}

.checkout-title {
    font-size: 1.5rem;
    margin-bottom: 20px;
    color: var(--primary);
    text-align: center;
}

.checkout-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: var(--text);
}

.form-group input, .form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid var(--gray);
    border-radius: 5px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group input:focus, .form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(139, 0, 0, 0.1);
}

.checkout-btn {
    grid-column: 1 / -1;
    background-color: var(--primary);
    color: var(--white);
    padding: 15px;
    border-radius: 5px;
    font-size: 1.1rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.checkout-btn:hover {
    background-color: var(--primary-light);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(139, 0, 0, 0.2);
}

/* Empty Cart */
.empty-cart {
    text-align: center;
    padding: 60px 20px;
    animation: fadeIn 0.8s ease;
}

.empty-cart-icon {
    font-size: 4rem;
    color: var(--gray);
    margin-bottom: 20px;
}

.empty-cart h2 {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: var(--text-light);
}

.empty-cart p {
    margin-bottom: 30px;
    color: var(--text-light);
}

/* Success Message */
.success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 5px;
    margin: 20px 0;
    text-align: center;
    animation: popUp 0.5s ease;
    border-left: 4px solid #28a745;
}

/* Continue Shopping */
.continue-shopping {
    text-align: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--gray);
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

@keyframes tableFadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes rowSlideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes formSlideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Styles */
@media (max-width: 992px) {
    .checkout-form {
        grid-template-columns: 1fr;
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
    
    .cart-table {
        display: block;
        overflow-x: auto;
    }
    
    .cart-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

@media (max-width: 576px) {
    .logo h1 {
        font-size: 1.4rem;
    }
    
    .logo img {
        height: 40px;
    }
    
    .cart-title {
        font-size: 1.5rem;
    }
    
    .footer-bottom {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .quantity-controls {
        flex-direction: column;
        gap: 5px;
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
                    <li><a href="../html/index.html#sarees">Sarees</a></li>
                   <li><a href="../html/index.html#about">About</a></li>

                    <li><a href="../html/feedback.html">Feedback</a></li>
                    <li><a href="#foot">Contact</a></li>
                    <li><a href="view_cart.php" class="active">Cart (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="container cart-container">
            <div class="cart-header">
                <h1 class="cart-title">Your Shopping Cart</h1>
                <div class="cart-count">
                    <?php 
                    $itemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                    echo $itemCount . ' item' . ($itemCount != 1 ? 's' : '') . ' in cart';
                    ?>
                </div>
            </div>

            <?php if(!empty($_SESSION['cart'])): ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Saree</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total=0; foreach($_SESSION['cart'] as $index => $item): ?>
                            <tr>
                                <td class="cart-item-name"><?php echo $item['name']; ?></td>
                                <td class="cart-item-price">₹<?php echo $item['price']; ?></td>
                                <td>
                                    <form method="post" class="quantity-controls">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input">
                                        <input type="hidden" name="item_index" value="<?php echo $index; ?>">
                                        <button type="submit" name="update_quantity" class="update-btn">Update</button>
                                    </form>
                                </td>
                                <td class="cart-item-subtotal">₹<?php echo $item['price'] * $item['quantity']; ?></td>
                                <td>
                                    <a href="?remove=<?php echo $index; ?>" class="remove-btn" onclick="return confirm('Are you sure you want to remove this item?')">🗑️</a>
                                </td>
                            </tr>
                            <?php $total += $item['price'] * $item['quantity']; ?>
                        <?php endforeach; ?>
                        <tr class="cart-total">
                            <td colspan="3"><strong>Total</strong></td>
                            <td colspan="2"><strong>₹<?php echo $total; ?></strong></td>
                        </tr>
                    </tbody>
                </table>

                <div class="checkout-section">
                    <h2 class="checkout-title">Checkout Information</h2>
                    <form method="post" class="checkout-form">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>
                        </div>
                        <div class="form-group full-width">
                            <label for="address">Shipping Address</label>
                            <textarea id="address" name="address" rows="4" placeholder="Enter your complete address" required></textarea>
                        </div>
                        <button type="submit" name="checkout" class="checkout-btn">Place Order - ₹<?php echo $total; ?></button>
                    </form>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <div class="empty-cart-icon">🛒</div>
                    <h2>Your cart is empty</h2>
                    <p>Looks like you haven't added any sarees to your cart yet.</p>
                    <a href="../html/index.html#saree" class="btn btn-primary">Browse Sarees</a>
                </div>
            <?php endif; ?>

            <div class="continue-shopping">
                <a href="../html/index.html" class="btn btn-secondary">Continue Shopping</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="foot">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>DMM Sarees brings you the finest collection of traditional and contemporary sarees, preserving the rich heritage of Indian handloom.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                     <ul>
                        
                    <li><a href="../html/index.html" class="active">Home</a></li>
                    <li><a href="#sarees">Sarees</a></li>
                   <li><a href="../html/index.html#about">About</a></li>

                    <li><a href="../html/feedback.html">Feedback</a></li>
                    <li><a href="#foot">Contact</a></li>

                
                   
                </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <p><i>📍</i> 123 Silk Street, Varanasi, India</p>
                    <p><i>📞</i> +91 9876543210</p>
                    <p><i>✉️</i> info@dmmsarees.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 DMM Sarees. All rights reserved.</p>
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
        
        // Confirm before removing item
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                if(!confirm('Are you sure you want to remove this item from your cart?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>