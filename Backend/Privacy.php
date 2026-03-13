<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOOPERS FITS - Privacy Policy</title>
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

    /* ---------- PRIVACY BOX ---------- */
    .privacy-section {
      width: 100%;
      background: rgba(255,255,255,0.95);
      color: #333;
      border-radius: 12px;
      padding: 30px;
      backdrop-filter: blur(6px);
      transition: all 0.4s ease;
    }

    .privacy-section h1 {
      font-size: 28px;
      margin-bottom: 20px;
      text-align: center;
      color: #dc3545;
    }

    .privacy-section h2 {
      font-size: 20px;
      margin-top: 20px;
      margin-bottom: 10px;
      color: #dc3545;
    }

    .privacy-section p {
      margin-bottom: 15px;
      line-height: 1.6;
    }

    .privacy-section ul {
      margin-bottom: 15px;
      padding-left: 20px;
    }

    .privacy-section li {
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
      .privacy-section {
        padding: 20px;
      }
    }
  </style>
</head>

<body>

  <div class="header">
    <img src="../Images/HoopersFits.png" class="logo">
    <nav class="nav">
      <a href="Login.php">HOME</a>
      <a href="Login.php">PRODUCT</a>
      <a href="login.php">ABOUT</a>
      <a href="logon.php">CONTACT</a>
    </nav>
  </div>

  <section class="hero">
    <div class="hero-content">
      <div class="privacy-section">
        <h1>PRIVACY POLICY</h1>

        <p>Your privacy is important to us. This Privacy Policy explains how we collect and use your information.</p>

        <h2>1. Information We Collect</h2>
        <ul>
          <li>Name</li>
          <li>Email address</li>
          <li>Personal data (processed securely and only for data analysis purposes)</li>
        </ul>

        <h2>2. How We Use Your Information</h2>
        <p>A. View item likes</p>
        <p>B. Data Protection</p>
        <ul>
          <li>To process, summarize</li>
          <li>To enrich profile insights</li>
          <li>Greater user insights, create your learning experience</li>
        </ul>

        <p>We only store your uploaded data live only for the years you provide them.</p>

        <h2>3. Data Protection</h2>
        <ul>
          <li>Assist in protecting data when they require data-related protection.</li>
        </ul>
      </div>
    </div>
  </section>

  <footer class="footer">
    <p>
      <a href="#" class="footer-link">Privacy Policy</a> |
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