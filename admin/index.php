<?php
session_start();

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // For demo: fixed admin credentials
    if($username == 'admin' && $password == 'admin123'){
        $_SESSION['admin'] = true;
        header("Location: orders.php");
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login - Dharmavaram Weavers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Your full CSS from the template */
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

        * {margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;}
        body {background-color: var(--accent);color: var(--text);line-height: 1.6;}
        .container {width:90%;max-width:1200px;margin:0 auto;padding:0 15px;}
        .global-notification {background-color: var(--primary);color: var(--white);padding:8px 0;text-align:center;font-size:0.9rem;}
        header {background-color: var(--white);box-shadow:0 2px 10px rgba(0,0,0,0.1);padding:15px 0;}
        .header-row {padding: 10px 0;}
        .header-wrapper {display:flex;justify-content:space-between;align-items:center;}
        .header-left {display:flex;align-items:center;gap:15px;}
        .header-left img.log {height:50px;}
        .logo {font-size:1.5rem;font-weight:bold;color:var(--primary);text-decoration:none;}
        .header-mobile {display:none;}

        .auth-section {padding:80px 0;min-height:calc(100vh - 200px);}
        .auth-wrapper {display:flex;min-height:600px;border-radius:10px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,0.1);}
        .auth-image {flex:1;position:relative;background-color: var(--primary);}
        .auth-image img {width:100%;height:100%;object-fit:cover;opacity:0.9;}
        .auth-image-content {position:absolute;bottom:0;left:0;right:0;padding:40px;color:var(--white);background:linear-gradient(transparent, rgba(0,0,0,0.7));}
        .auth-image-content h2 {color: var(--white);font-size:2rem;margin-bottom:15px;}
        .auth-image-content p {margin-bottom:20px;opacity:0.9;}
        .auth-content {flex:1;background-color:var(--white);padding:60px;display:flex;flex-direction:column;justify-content:center;}
        .auth-form-wrapper {max-width:450px;margin:0 auto;width:100%;}
        .auth-form-wrapper h1 {font-size:2rem;margin-bottom:10px;text-align:center;color:var(--primary);}
        .auth-subtitle {color:var(--text-light);margin-bottom:30px;text-align:center;}
        .auth-form {display:flex;flex-direction:column;gap:20px;}
        .form-group {margin-bottom:20px;}
        .form-group label {display:block;margin-bottom:8px;font-weight:600;color:var(--text);}
        .input-group {position:relative;}
        .input-group input {width:100%;padding:12px 15px 12px 45px;border:1px solid var(--gray);border-radius:5px;font-size:1rem;transition:all 0.3s ease;}
        .input-group input:focus {border-color:var(--primary);box-shadow:0 0 0 3px rgba(139,0,0,0.1);outline:none;}
        .input-icon {position:absolute;left:15px;top:50%;transform:translateY(-50%);color:var(--dark-gray);}
        .password-toggle {position:absolute;right:15px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--dark-gray);cursor:pointer;}
        .form-options {display:flex;justify-content:space-between;align-items:center;margin-top:10px;}
        .remember-me {display:flex;align-items:center;gap:8px;font-size:0.9rem;}
        .remember-me input {width:16px;height:16px;}
        .forgot-password {color:var(--primary);font-size:0.9rem;text-decoration:none;}
        .forgot-password:hover {text-decoration:underline;}
        .btn {display:inline-block;padding:12px 30px;border-radius:5px;font-weight:600;transition:all 0.3s ease;cursor:pointer;border:none;text-decoration:none;text-align:center;font-size:1rem;}
        .btn-primary {background-color:var(--primary);color:var(--white);}
        .btn-primary:hover {background-color:var(--primary-light);transform:translateY(-2px);}
        .btn-secondary {background-color:var(--secondary);color:var(--text);}
        .btn-secondary:hover {background-color:#e0b83a;transform:translateY(-2px);}
        .btn-auth {width:100%;padding:15px;font-size:1.1rem;margin-top:10px;}
        .footer {background-color:var(--primary);color:var(--white);padding:20px 0;}
        .footer-copyright {display:flex;justify-content:space-between;align-items:center;}
        .site-copyright p {margin:0;font-size:0.9rem;opacity:0.9;}
        .footer-menu-list {display:flex;list-style:none;gap:20px;}
        .footer-menu-list .list-item a {color:var(--white);text-decoration:none;font-size:0.9rem;opacity:0.9;transition:opacity 0.3s ease;}
        .footer-menu-list .list-item a:hover {opacity:1;}
        .error-message {background-color:#f8d7da;color:#721c24;padding:12px;border-radius:5px;margin:20px 0;text-align:center;border-left:4px solid #dc3545;}
        .success-message {background-color:#d4edda;color:#155724;padding:12px;border-radius:5px;margin:20px 0;text-align:center;border-left:4px solid #28a745;}
        @media (max-width:992px) {.auth-wrapper {flex-direction:column;} .auth-image {display:none;} .auth-content {padding:40px;}}
        @media (max-width:768px) {.header-mobile {display:block;font-size:1.5rem;cursor:pointer;} .auth-content {padding:20px;} .footer-copyright {flex-direction:column;gap:15px;text-align:center;} .footer-menu-list {justify-content:center;}}
        @media (max-width:576px) {.auth-form-wrapper h1 {font-size:1.5rem;} .form-options {flex-direction:column;gap:10px;align-items:flex-start;} .header-left img.log {height:40px;} .logo {font-size:1.2rem;}}
        .fade-in {animation: fadeIn 0.8s ease-in-out;}
        .slide-in {animation: slideIn 0.8s ease-in-out;}
        @keyframes fadeIn {from {opacity:0;} to {opacity:1;}}
        @keyframes slideIn {from {transform:translateY(30px);opacity:0;} to {transform:translateY(0);opacity:1;}}
        /* Navbar Styles */
        /* Navbar Styles */
nav {
    background-color: #ffffff; /* or any background you like */
    padding: 10px 20px;
}

nav ul {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    margin-left: 25px; /* spacing between menu items */
}

nav ul li a {
    text-decoration: none;
    font-weight: 600;
    color: #321414; /* default text color */
    transition: color 0.3s ease;
    position: relative;
}

nav ul li a:hover {
    color: var(--primary); /* change color on hover */
}

nav ul li a.active {
    color: var(--primary); /* active link color */
}

nav ul li a.active::after {
    content: '';
    position: absolute;
    bottom: -5px; /* underline below text */
    left: 0;
    width: 100%;
    height: 2px;
    background-color: var(--primary); /* underline color */
}



    </style>
</head>
<body>
    <!-- Header Start -->
    <header class="fade-in">
        <div class="global-notification">
            <div class="container">
                <p>
                    DIRECT FROM WEAVERS - FAIR PRICES & FREE DELIVERY ON ORDERS ABOVE ₹2000! SHOP NOW
                </p>
            </div>
        </div>
        <div class="header-row">
            <div class="container">
                <div class="header-wrapper">
                    <div class="header-mobile">
                        <i class="bi bi-list" id="btn-menu"></i>
                    </div>
                    <div class="header-left">
                        <img src="../images/dmmlogo.png" class="log" alt="Dharmavaram Weavers">
                        <a href="../html/index.html" class="logo">Dharmavaram Weavers</a>
                    </div>
                      <nav>
                <ul>
                    <li><a href="../html/index.html" class="active">Home</a></li>
                  

                </ul>
            </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Admin Login Section Start -->
    <section class="auth-section">
        <div class="container">
            <div class="auth-wrapper slide-in">
                <div class="auth-image">
                    <img src="../images/admin.jpg" alt="Admin Portal">
                    <div class="auth-image-content">
                        <h2>Admin Portal</h2>
                        <p>Secure access to manage your weavers marketplace</p>
                        <a href="../html/index.html" class="btn btn-secondary">Back to Site</a>
                    </div>
                </div>
                <div class="auth-content">
                    <div class="auth-form-wrapper">
                        <h1>Admin Login</h1>
                        <p class="auth-subtitle">Access your admin dashboard securely</p>
                        
                        <form class="auth-form" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <span class="input-icon"><i class="bi bi-person"></i></span>
                                    <input type="text" id="username" name="username" placeholder="Enter admin username" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <span class="input-icon"><i class="bi bi-lock"></i></span>
                                    <input type="password" id="password" name="password" placeholder="Enter admin password" required>
                                    <button type="button" class="password-toggle"><i class="bi bi-eye"></i></button>
                                </div>
                             
                            </div>

                            <button type="submit" name="login" class="btn btn-primary btn-auth">Login to Dashboard</button>
                            
                            <?php 
                            if(isset($error)) {
                                echo "<div class='error-message fade-in'>$error</div>";
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Admin Login Section End -->

    <!-- Footer Start -->
    <section class="footer">
        <div class="copyright-row">
            <div class="container">
                <div class="footer-copyright">
                    <div class="site-copyright">
                        <p>
                            Copyright © 2023 Dharmavaram Weavers Marketplace. All rights reserved.
                        </p>
                    </div>
                    <div class="footer-menu">
                        <ul class="footer-menu-list">
                            <li class="list-item">
                                <a href="privacy.html">Privacy Policy</a>
                            </li>
                            <li class="list-item">
                                <a href="terms.html">Terms and Conditions</a>
                            </li>
                            <li class="list-item">
                                <a href="sitemap.html">Sitemap</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer End -->

    <script>
        // Toggle password visibility
        const toggleBtn = document.querySelector('.password-toggle');
        const passwordInput = document.getElementById('password');
        toggleBtn.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleBtn.innerHTML = type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
        });
    </script>
</body>
</html>
