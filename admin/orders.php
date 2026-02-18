<?php
session_start();
if(isset($_SESSION['success'])){
    echo "<div class='success-message'>".$_SESSION['success']."</div>";
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
    echo "<div class='error-message'>".$_SESSION['error']."</div>";
    unset($_SESSION['error']);
}

if(!isset($_SESSION['admin'])){
    header("Location: index.php");
    exit();
}

include 'C:\xampp\htdocs\dmm1\php\config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel - Orders | Dharmavaram Weavers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Clean CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 95%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header */
        header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
            border-bottom: 3px solid #8B0000;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo img {
            height: 45px;
        }

        .logo h1 {
            color: #8B0000;
            font-size: 1.4rem;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 20px;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        nav a:hover, nav a.active {
            background: #8B0000;
            color: white;
        }

        /* Buttons */
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #8B0000;
            color: white;
        }

        .btn-primary:hover {
            background: #a83232;
        }

        .btn-secondary {
            background: #D4AF37;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0b83a;
        }

        /* Main Content */
        .admin-panel {
            padding: 30px 0;
            min-height: 80vh;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .panel-title {
            color: #8B0000;
            font-size: 1.8rem;
        }

        /* Table - Fixed for Action Column */
        .orders-table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow-x: auto;
            width: 100%;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px; /* Ensure table doesn't get too narrow */
        }

        .orders-table th {
            background: #8B0000;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            white-space: nowrap;
        }

        .orders-table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: top;
        }

        .orders-table tr:hover {
            background: #f8f9fa;
        }

        /* Make Action Column Stand Out */
        .orders-table th:last-child,
        .orders-table td:last-child {
            background: #fff9e6;
            border-left: 3px solid #D4AF37;
            position: sticky;
            right: 0;
            z-index: 1;
        }

        .orders-table th:last-child {
            background: #8B0000;
            color: white;
        }

        /* Status Badges */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-confirmed { background: #d1ecf1; color: #0c5460; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #c3e6cb; color: #155724; }

        /* Action Column Forms - Fixed */
        .status-form {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-width: 140px;
            max-width: 160px;
        }

        .status-select {
            padding: 8px;
            border: 2px solid #ddd;
            border-radius: 5px;
            background: white;
            font-size: 0.9rem;
            width: 100%;
        }

        .status-select:focus {
            border-color: #8B0000;
            outline: none;
        }

        .action-btn {
            background: #8B0000;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            width: 100%;
            font-size: 0.85rem;
        }

        .action-btn:hover {
            background: #a83232;
            transform: translateY(-1px);
        }

        /* Messages */
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #28a745;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #dc3545;
        }

        /* Footer */
        footer {
            background: #8B0000;
            color: white;
            padding: 25px 0 15px;
            margin-top: 50px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 20px;
        }

        .footer-section h3 {
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #D4AF37;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #D4AF37;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 15px;
            border-top: 1px solid rgba(255,255,255,0.2);
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* No Orders */
        .no-orders {
            text-align: center;
            padding: 50px 20px;
            color: #666;
        }

        .no-orders i {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 15px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .orders-table {
                min-width: 1100px;
            }
        }

        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .panel-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .orders-table {
                min-width: 1000px;
            }
        }

        @media (max-width: 480px) {
            .orders-table th,
            .orders-table td {
                padding: 10px 8px;
                font-size: 0.85rem;
            }
            
            .status-form {
                min-width: 120px;
                max-width: 140px;
            }
            
            .status-select {
                padding: 6px;
                font-size: 0.8rem;
            }
            
            .action-btn {
                padding: 6px 8px;
                font-size: 0.8rem;
            }
        }

        /* Items List */
        .items-list {
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .item-row {
            padding: 2px 0;
            border-bottom: 1px dashed #ddd;
        }

        .item-row:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="../images/dmmlogo.png" alt="Dharmavaram Weavers">
                <h1>Dharmavaram Weavers - Admin</h1>
            </div>
            <nav>
                <ul>
                  
                    <li><a href="../html/index.html" class="btn btn-secondary">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Admin Panel -->
    <section class="admin-panel">
        <div class="container">
            <div class="panel-header">
                <h1 class="panel-title">All Orders</h1>
             
            </div>

            <div class="orders-table-container">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM orders ORDER BY created_at DESC";
                        $result = $conn->query($sql);

                        if($result->num_rows > 0){
                            while($order = $result->fetch_assoc()){
                                echo "<tr>";
                                echo "<td><strong>#".$order['id']."</strong></td>";
                                echo "<td>".htmlspecialchars($order['customer_name'])."</td>";
                                echo "<td>".htmlspecialchars($order['email'])."</td>";
                                echo "<td>".htmlspecialchars($order['phone'])."</td>";
                                echo "<td style='max-width: 200px;'>".htmlspecialchars($order['address'])."</td>";

                                // Fetch order items
                                $items_sql = "SELECT oi.quantity, s.name, oi.price 
                                            FROM order_items oi 
                                            JOIN sarees s ON oi.saree_id = s.id 
                                            WHERE oi.order_id=".$order['id'];
                                $items_result = $conn->query($items_sql);
                                $items_list = "<div class='items-list'>";
                                while($item = $items_result->fetch_assoc()){
                                    $items_list .= "<div class='item-row'>";
                                    $items_list .= htmlspecialchars($item['name'])." x ".$item['quantity']." (₹".$item['price'].")";
                                    $items_list .= "</div>";
                                }
                                $items_list .= "</div>";
                                echo "<td>".$items_list."</td>";

                                echo "<td><strong>₹".$order['total']."</strong></td>";
                                echo "<td>".ucfirst(str_replace('_', ' ', $order['payment_method']))."</td>";
                                
                                // Status with badge
                                $status_class = "status-".strtolower($order['status']);
                                echo "<td><span class='status-badge ".$status_class."'>".$order['status']."</span></td>";
                                
                                // Action column - Fixed
                                echo "<td>
                                        <form method='post' action='update_status.php' class='status-form'>
                                            <input type='hidden' name='order_id' value='".$order['id']."'>
                                            <select name='status' class='status-select'>
                                                <option value='Pending' ".($order['status']=='Pending'?'selected':'').">Pending</option>
                                                <option value='Confirmed' ".($order['status']=='Confirmed'?'selected':'').">Confirmed</option>
                                                <option value='Shipped' ".($order['status']=='Shipped'?'selected':'').">Shipped</option>
                                                <option value='Delivered' ".($order['status']=='Delivered'?'selected':'').">Delivered</option>
                                            </select>
                                            <button type='submit' class='action-btn'>
                                                <i class='fas fa-edit'></i> Update
                                            </button>
                                        </form>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>
                                    <div class='no-orders'>
                                        <i class='fas fa-inbox'></i>
                                        <h3>No Orders Found</h3>
                                        <p>There are no orders in the system yet.</p>
                                    </div>
                                </td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Dharmavaram Weavers</h3>
                    <p>Empowering traditional weavers with digital access to global markets.</p>
                </div>
           
                <div class="footer-section">
                    <h3>Contact</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Dharmavaram, Andhra Pradesh</p>
                    <p><i class="fas fa-phone"></i> +91 9398697842</p>
                    <p><i class="fas fa-envelope"></i> pawankothavalamvgr@gmail.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 Dharmavaram Weavers Marketplace. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>