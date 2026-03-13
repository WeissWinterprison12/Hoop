<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff; /* White background for the site */
            color: #000; /* Black text for readability */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            border-bottom: 1px solid #ddd;
            background-color: #000; /* Black header */
        }

        .logo {
            width: 110px;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .nav a {
            color: #fff; /* White text on black header */
            text-decoration: none;
            font-size: 14px;
        }

        .nav a:hover,
        .nav a.active {
            color: #dc3545;
            font-weight: 600;
        }

        .search-bar input {
            background: #333; /* Dark background for contrast on black header */
            border: 1px solid #555; /* Light border */
            color: #fff; /* White text */
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            width: 200px;
            outline: none;
        }

        .icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icons a img {
            width: 22px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .icons a img:hover {
            transform: scale(1.15);
        }

        .logout-btn {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            margin-left: 15px;
            transition: color 0.3s ease;
        }

        .logout-btn:hover {
            color: #dc3545;
            font-weight: 600;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        /* Delivery Address Section */
        .delivery-address {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .delivery-address h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #dc3545; /* Red color to match theme */
        }

        .address-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .address-info div {
            flex: 1;
        }

        .address-info p {
            margin: 5px 0;
        }

        .address-info .actions {
            text-align: right;
        }

        .address-info .actions a {
            color: #dc3545; /* Red to match theme */
            text-decoration: none;
            margin-left: 10px;
        }

        .address-info .actions span {
            color: #777;
            margin-right: 10px;
        }

        /* Products Ordered Section */
        .products-ordered {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .products-ordered h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-info {
            display: flex;
            align-items: center;
        }

        .product-info img {
            width: 80px;
            height: 80px;
            margin-right: 10px;
            object-fit: cover;
        }

        .product-details {
            flex: 1;
        }

        .product-details p {
            margin: 5px 0;
        }

        .unit-price, .quantity, .item-subtotal {
            width: 100px;
            text-align: center;
        }

        /* Payment Method Section */
        .payment-method {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .payment-method h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .payment-method p {
            margin-bottom: 10px;
        }

        .payment-method a {
            color: #dc3545; /* Red to match theme */
            text-decoration: none;
        }

        /* Order Summary Section */
        .order-summary {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: right;
        }

        .order-summary p {
            margin-bottom: 5px;
        }

        .order-summary .total {
            font-weight: bold;
            font-size: 18px;
        }

        /* Place Order Button */
        .place-order-btn {
            background-color: #dc3545; /* Red to match theme */
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .place-order-btn:hover {
            background-color: #b02a37; /* Darker red */
        }

        /* Footer */
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            font-size: 12px;
            border-top: 1px solid #ddd;
            background-color: #000; /* Black footer */
            color: #fff; /* White text */
        }

        .footer-link {
            color: #fff; /* White links on black footer */
            text-decoration: none;
            margin: 0 5px;
        }

        .footer-link:hover {
            color: #dc3545;
        }

        .social-icons img {
            width: 20px;
            margin-left: 10px;
        }

        @media (max-width: 900px) {
            .container {
                width: 95%;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <header class="header">
        <img src="../Images/HoopersFits.png" class="logo" alt="Hoopers Fits Logo">

        <nav class="nav">
            <a href="BuyerHomePage.php">Home</a>
            <a href="BuyerShopPage.php">Shop</a>
            <a href="#">New Fits</a>
            <a href="#">Contact Us</a>
        </nav>

        <div class="search-bar">
            <input type="text" placeholder="Search">
        </div>

        <!-- ICON BUTTONS -->
        <div class="icons">
            <!-- Buyer Dashboard -->
            <a href="Buyer_dashboard.php">
                <img src="../Images/Profile.png" alt="User">
            </a>

            <!-- Checkout -->
            <a href="Checkout.php">
                <img src="../Images/Cart.png" alt="Cart">
            </a>
        </div>

        <a href="#" class="logout-btn" onclick="logout()">Logout</a>
    </header>

    <div class="container">
        <section class="delivery-address">
            <h2>Delivery Address</h2>
            <div class="address-info">
                <div>
                    <p>Andrei Lapuz Narito (+63)</p>
                    <p>962 417 6786</p>
                </div>
                <div>
                    <p>1367 Santol St. 1B, B. F. International Village, Las Pinas City, Metro Manila</p>
                </div>
                <div class="actions">
                    <span style="color:#777">Default</span>
                    <a href="#">Change</a>
                </div>
            </div>
        </section>

        <section class="products-ordered">
            <h2>Products Ordered</h2>
            <div class="product-item">
                <div class="product-info">
                    <img src="../Images/Saint.jpg" alt="Saint of God Hoodie">
                    <div class="product-details">
                        <p>Saint Of God Hoodie</p>
                    </div>
                </div>
                <div class="unit-price">₱ 950.99</div>
                <div class="quantity">1</div>
                <div class="item-subtotal">₱ 950.99</div> <!-- Fixed incomplete tag -->
            </div>
        </section>

        <section class="payment-method">
            <h2>Payment Method</h2>
            <p>Cash on Delivery</p>
            <a href="#">Change</a>
        </section>

        <section class="order-summary">
            <p>Subtotal: ₱ 950.99</p>
            <p>Shipping: ₱ 50.00</p>
            <p class="total">Total: ₱ 1,000.99</p>
        </section>

        <button class="place-order-btn">Place Order</button>
    </div>

    <footer class="footer">
        <p>
            <a href="#" class="footer-link">Privacy Policy</a> |
            <a href="#" class="footer-link">Terms and Conditions</a>
        </p>

        <div>
            Follow us on:
            <span class="social-icons">
                <a href="#"><img src="../Images/facebook.png"></a>
                <a href="#"><img src="../Images/Instagram.png"></a>
            </span>
        </div>
    </footer>

    <script>
        function logout() {
            // Simple redirect to login page (no session clearing needed since no database)
            window.location.href = "login.php";
        }
    </script>

</body>
</html>