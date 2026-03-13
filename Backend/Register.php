<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HOOPERS FITS - Register</title>
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
    }

    .nav a:hover { color: #dc3545; }

    /* ---------- HERO ---------- */
    .hero {
      position: relative;
      width: 100%;
      height: 500px;
      overflow: hidden;
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
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 100%;
      padding: 0 80px;
    }

    .text-section h2 {
      font-size: 38px;
      margin: 0;
      text-transform: uppercase;
    }

    .text-section h2:first-child { color: #dc3545; }

    /* ---------- REGISTER BOX ---------- */
    .register-section {
      width: 360px;
      height: 360px;
      background: rgba(255,255,255,0.95);
      color: #333;
      border-radius: 12px;
      padding: 20px;
      backdrop-filter: blur(6px);
      display: flex;
      flex-direction: column;
      transition: all 0.4s ease;
    }

    .login-tabs {
      display: flex;
      justify-content: space-around;
      margin-bottom: 10px;
    }

    .login-tabs button {
      background: none;
      border: none;
      font-size: 16px;
      padding: 10px;
      cursor: pointer;
      border-bottom: 2px solid transparent;
    }

    .login-tabs button.active {
      border-color: #dc3545;
      color: #dc3545;
      font-weight: 600;
    }

    /* ---------- SCROLLABLE FORM ---------- */
    .form-scroll {
      flex: 1;
      overflow-y: auto;
      padding-right: 5px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      font-size: 14px;
      display: block;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    .login-button {
      width: 100%;
      background-color: #dc3545;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      margin-top: 10px;
    }

    .login-button:hover { background-color: #b02a37; }

    /* ---------- SLIDE OUT ---------- */
    .slide-out {
      animation: slideOut 0.6s ease forwards;
    }

    @keyframes slideOut {
      from { transform: translateX(0); opacity: 1; }
      to { transform: translateX(100%); opacity: 0; }
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
        flex-direction: column;
        text-align: center;
      }
      .register-section { margin-top: 30px; }
    }
  </style>
</head>

<body>

  <div class="header">
    <img src="../Images/HoopersFits.png" class="logo">
    <nav class="nav">
      <a href="Login.php">HOME</a>
      <a href="Login.php">PRODUCT</a>
      <a href="Login.php">ABOUT</a>
      <a href="Login.php">CONTACT</a>
    </nav>
  </div>

  <section class="hero">
    <div class="hero-content">
      <div class="text-section">
        <h2>ELEVATE YOUR GAME</h2>
        <h2>ELEVATE YOUR FIT</h2>
      </div>

      <div class="register-section" id="registerBox">
        <div class="login-tabs">
          <button onclick="goLogin()">Login</button>
          <button class="active">Register</button>
        </div>

        <form class="form-scroll" onsubmit="handleRegister(event)">
          <div class="form-group">
            <label>Username</label>
            <input type="text" required>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" required>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" required>
          </div>

          <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" required>
          </div>

          <div class="form-group">
            <label>Contact Number</label>
            <input type="text" required>
          </div>

          <button class="login-button">Register</button>
        </form>
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

  <script>
    function goLogin() {
      document.getElementById("registerBox").classList.add("slide-out");
      setTimeout(() => {
        window.location.href = "Login.php";
      }, 600);
    }

    function handleRegister(e) {
      e.preventDefault();
      document.getElementById("registerBox").classList.add("slide-out");
      setTimeout(() => {
        window.location.href = "Login.php";
      }, 600);
    }
  </script>

</body>
</html>