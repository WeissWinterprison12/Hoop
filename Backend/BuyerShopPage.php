<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOOPERS FITS - Shop</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff;
      color: #000;
    }

    /* ---------- HEADER ---------- */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 50px;
      border-bottom: 1px solid #ddd;
      background-color: #000;
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
      color: #fff;
      text-decoration: none;
      font-size: 14px;
    }

    .nav a:hover,
    .nav a.active {
      color: #dc3545;
      font-weight: 600;
    }

    .search-bar input {
      background: #333;
      border: 1px solid #555;
      color: #fff;
      padding: 6px 10px;
      border-radius: 20px;
      outline: none;
      font-size: 13px;
      width: 180px;
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

    .shop-container {
      padding: 50px;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 30px;
    }

    .product-card {
      background: #fff;
      color: #000;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    }

    .product-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .img-placeholder {
      width: 100%;
      height: 180px;
      background: #eee;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      color: #777;
      margin-bottom: 10px;
    }

    .product-title {
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 5px;
    }

    .product-price {
      font-size: 13px;
      color: #555;
    }

    .footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 50px;
      font-size: 12px;
      border-top: 1px solid #ddd;
      background-color: #000;
      color: #fff;
    }

    .footer-link {
      color: #fff;
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

    @media (max-width: 768px) {
      .header {
        flex-direction: column;
        gap: 15px;
      }

      .shop-container {
        padding: 20px;
      }
    }
  </style>
</head>

<body>

  <header class="header">
    <img src="../Images/HoopersFits.png" class="logo">

    <nav class="nav">
      <a href="BuyerHomePage.php">Home</a>
      <a href="BuyerShopPage.php" class="active">Shop</a>
      <a href="#">New Fits</a>
      <a href="BuyerContactPage.php">Contact Us</a>
    </nav>

    <div class="search-bar">
      <input type="text" placeholder="Search">
    </div>

    <!-- ICON BUTTONS -->
    <div class="icons">

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

  <section class="shop-container">
    <div class="product-grid">

      <div class="product-card">
        <img src="../Images/BassBro.jpg" alt="Bos Bro Shop Cap">
        <div class="product-title">Bas Bro Shop Cap</div>
        <div class="product-price">From ₱1,999.99</div>
      </div>

      <div class="product-card">
        <img src="../Images/ChromeJersey.jpg" alt="Chrome Heart Baseball Jersey">
        <div class="product-title">Chrome Heart Baseball Jersey</div>
        <div class="product-price">From ₱999.50</div>
      </div>

      <div class="product-card">
        <img src="../Images/StussyProduct.jpg" alt="Stussy">
        <div class="product-title">Stussy</div>
        <div class="product-price">From ₱699.99</div>
      </div>

      <div class="product-card">
        <img src="../Images/ChromeCap.jpg" alt="Chrome Heart Net Cap">
        <div class="product-title">Chrome Heart Net Cap</div>
        <div class="product-price">From ₱549.25</div>
      </div>

      <div class="product-card">
        <img src="../Images/BLCKSZN.jpg" alt="BLCKSZN">
        <div class="product-title">BLKZN Cap</div>
        <div class="product-price">From ₱299.50</div>
      </div>

      <div class="product-card">
        <img src="../Images/ChromeZip.jpg" alt="Chrome Heart Zipper Jacket">
        <div class="product-title">Chrome Heart Zipper Jacket</div>
        <div class="product-price">From ₱875.50</div>
      </div>

      <div class="product-card">
       <img src="../Images/Saint.jpg" alt="Saint of God Hoodie">
        <div class="product-title">Saint of God Hoodie</div>
        <div class="product-price">From ₱950.99</div>
      </div>

      <div class="product-card">
        <img src="../Images/CDGxStussy.jpg" alt="CDG x Stussy Varsity Jacket">
        <div class="product-title">CDG x Stussy Varsity Jacket</div>
        <div class="product-price">From ₱6,555.50</div>
      </div>

      <div class="product-card">
        <img src="../Images/FormTeam.jpg" alt="Chrome Hearts Form Team Jersey">
        <div class="product-title">Chrome Hearts Form Team Jersey</div>
        <div class="product-price">From ₱749.99</div>
      </div>

      <div class="product-card">
        <img src="../Images/ChromeHAzure.jpg" alt="Chrome Hearts Azure">
        <div class="product-title">Chrome Hearts Azure</div>
        <div class="product-price">From ₱865.25</div>
      </div>
    </div>
    </div>

    
  </section>

  <footer class="footer">
    <p>
      <a href="Priva.php" class="footer-link">Privacy Policy</a> |
      <a href="TC.php" class="footer-link">Terms and Conditions</a>
    </p>

    <div>
      Follow us on:
      <span class="social-icons">
        <a href="www.facebook.com"><img src="../Images/facebook.png"></a>
        <a href="www.facebook.com"><img src="../Images/Instagram.png"></a>
      </span>
    </div>
  </footer>

  <script>
    function logout() {

      window.location.href = "login.php";
    }
  </script>

</body>
</html>