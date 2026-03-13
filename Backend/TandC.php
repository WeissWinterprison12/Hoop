<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOOPERS FITS - Terms & Conditions</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    * { box-sizing: border-box; }

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #000;
      color: #fff;
      overflow-x: hidden;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 50px;
      position: relative;
      z-index: 10;
    }

    .logo { width: 100px; }

    .nav a {
      color: #fff;
      text-decoration: none;
      margin-left: 20px;
      font-size: 14px;
      transition: color 0.3s ease;
    }

    .nav a:hover { color: #dc3545; }

    /* ---------- HERO ---------- */
    .hero {
      position: relative;
      width: 100%;
      min-height: 500px;
      overflow: hidden;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 50px 0;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: -10%;
      left: -5%;
      width: 110%;
      height: 130%;
      background:
        linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
        url('../Images/sapatos.jpg') no-repeat center center / cover;
      transform: skewY(-5deg);
      transform-origin: top left;
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      width: 80%;
      max-width: 800px;
    }

    /* ---------- TERMS BOX ---------- */
    .terms-section {
      width: 100%;
      background: rgba(255,255,255,0.95);
      color: #333;
      border-radius: 12px;
      padding: 30px;
      backdrop-filter: blur(6px);
      transition: all 0.4s ease;
    }

    .terms-section h1 {
      font-size: 28px;
      margin-bottom: 20px;
      text-align: center;
      color: #dc3545;
    }

    .terms-section h2 {
      font-size: 20px;
      margin-top: 20px;
      margin-bottom: 10px;
      color: #dc3545;
    }

    .terms-section p {
      margin-bottom: 15px;
      line-height: 1.6;
    }

    .terms-section ul {
      margin-bottom: 15px;
      padding-left: 20px;
    }

    .terms-section li {
      margin-bottom: 10px;
    }

    /* ---------- FOOTER ---------- */
    .footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 50px;
      font-size: 12px;
    }

    .footer-link {
      color: #fff;
      text-decoration: none;
    }

    .footer-link:hover { color: #dc3545; }

    .social-icons img {
      width: 20px;
      margin-left: 10px;
    }

    @media (max-width: 900px) {
      .hero-content {
        width: 95%;
      }
      .terms-section {
        padding: 20px;
      }
    }
  </style>
</head>

<body>

  <div class="header">
    <img src="../Images/HoopersFits.png" class="logo">
    <nav class="nav">
      <a href="login.php">HOME</a>
      <a href="login.php">PRODUCT</a>
      <a href="login.php">ABOUT</a>
      <a href="login.php">CONTACT</a>
    </nav>
  </div>

  <section class="hero">
    <div class="hero-content">
      <div class="terms-section">
        <h1>TERMS & CONDITIONS</h1>

        <p>Welcome to our store. By accessing or using our website, you agree to be bound by these Terms and Conditions.</p>

        <h2>1. Use of the Website</h2>
        <p>You agree to use the website only for lawful purposes, and in a way that does not infringe the rights of others.</p>

        <h2>2. Products & Pricing</h2>
        <ul>
          <li>We reserve the right to modify the contents of this site at any time, but we have no obligation to update any information on our site.</li>
          <li>Prices may change without prior notice.</li>
        </ul>

        <h2>3. Orders & Payment</h2>
        <ul>
          <li>Orders are confirmed upon successful payment.</li>
          <li>We reserve the right to refuse or cancel any order for any reason, including limitations on quantities available for purchase, inaccuracies, or errors in product or pricing information.</li>
        </ul>

        <h2>4. Shipping & Delivery</h2>
        <ul>
          <li>Delivery times may vary depending on shipping location. We are not responsible for delays beyond our control.</li>
        </ul>
      </div>
    </div>
  </section>

  <footer class="footer">
    <p>
      <a href="Privacy.php" class="footer-link">Privacy Policy</a> |
      <a href="TandC.php" class="footer-link">Terms & Conditions</a>
    </p>
    <div>
      Follow us on:
      <span class="social-icons">
        <img src="../Images/facebook.png">
        <img src="../Images/Instagram.png">
      </span>
    </div>
  </footer>

</body>
</html>