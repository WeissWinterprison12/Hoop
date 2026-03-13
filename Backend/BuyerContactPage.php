<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - HOOPERS FITS</title>

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

    .contact-container {
      padding: 50px 50px 20px 50px;
    }

    .contact-section {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .contact-info {
      width: 40%;
      padding: 20px;
    }

    .contact-info h1 {
      font-size: 2em;
      margin-bottom: 10px;
      color: #000;
    }

    .contact-info p {
      color: #666;
    }

    .contact-form {
      width: 40%;
      padding: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      color: #000;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-family: 'Poppins', sans-serif;
    }

    .form-group textarea {
      height: 150px;
    }

    button[type="submit"] {
      background-color: #dc3545;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #c82333;
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
      .contact-section {
        flex-direction: column;
        align-items: center;
      }

      .contact-info,
      .contact-form {
        width: 100%;
      }

      .contact-container {
        padding: 20px;
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
      <a href="BuyerContactPage.php" class="active">Contact Us</a>
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

  <section class="contact-container">
    <div class="contact-section">
      <div class="contact-info">
        <h1>Contact Us.</h1>
        <p>Need to get in touch with us? Fill out your inquiry.</p>
      </div>
      <div class="contact-form">
        <form method="post" action="process_contact.php">  <!-- Add your PHP processing file here -->
          <div class="form-group">
            <label for="fullname">Fullname</label>
            <input type="text" id="fullname" name="fullname" required>
          </div>
          <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" required></textarea>
          </div>
          <button type="submit">Submit</button>
        </form>
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
        <a href="#"><img src="../Images/facebook.png" alt="Facebook"></a>
        <a href="#"><img src="../Images/Instagram.png" alt="Instagram"></a>
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