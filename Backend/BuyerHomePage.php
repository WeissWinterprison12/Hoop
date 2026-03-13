<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOOPERS FITS - Home</title>

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

    .home-container {
      padding: 50px 50px 20px 50px;
    }

    .featured-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 25px;
    }

    .featured-card {
      background: #f0f0f0;
      border-radius: 10px;
      height: 420px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #777;
      font-size: 14px;
      text-transform: uppercase;
      overflow: hidden;
    }

    .featured-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 10px;
    }

    .featured-card.sale {
      background: #e0e0e0;
      font-size: 28px;
      font-weight: 700;
      letter-spacing: 2px;
      color: #c2b280;
      text-align: center;
      flex-direction: column;
    }

    .sale span {
      font-size: 12px;
      color: #666;
      margin-bottom: 10px;
    }

    .home-arrows {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin: 20px 0;
      font-size: 24px;
      cursor: pointer;
      color: #000;
    }

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
      .featured-grid {
        grid-template-columns: 1fr;
      }

      .home-container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <header class="header">
    <img src="../Images/HoopersFits.png" class="logo" alt="Hoopers Fits Logo">

    <nav class="nav">
      <a href="BuyerHomePage.php" class="active">Home</a>
      <a href="BuyerShopPage.php">Shop</a>
      <a href="#">New Fits</a>
      <a href="BuyerContactPage.php">Contact Us</a>
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

  <section class="home-container">
    <div class="featured-grid">

      <div class="featured-card">
        <img src="../Images/Black simple caps fashion promotion - instagram post.jpg" alt="Discount Image">
      </div>

      <div class="featured-card">
        <img src="../Images/cdg.jpg" alt="Lifestyle Image">
      </div>

      <div class="featured-card">
        <img src="../Images/fireeee.jpg" alt="Outfit Image">
      </div>

    </div>

    <div class="home-arrows">← →</div>
  </section>

  <footer class="footer">
    <p>
      <a href="Priva.php" class="footer-link">Privacy Policy</a> |
      <a href="TC.php" class="footer-link">Terms and Conditions</a>
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