<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buyer's Messages</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  background: #f2f2f2;
  display: flex;
  min-height: 100vh;
}

/* ---------- SIDEBAR ---------- */
.sidebar {
  width: 230px;
  background: #000;
  color: #fff;
  padding: 25px 15px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.sidebar img.profile {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 10px;
}

.sidebar h3 {
  font-size: 14px;
  margin-bottom: 25px;
}

.sidebar ul {
  list-style: none;
  width: 100%;
}

.sidebar li {
  margin-bottom: 12px;
}

.sidebar a {
  display: block;
  text-decoration: none;
  color: #fff;
  padding: 10px;
  border-radius: 6px;
  font-size: 13px;
  transition: 0.3s;
}

.sidebar a.active,
.sidebar a:hover {
  background: #333;
}

.sidebar .logo {
  margin-top: auto;
}

.sidebar .logo img {
  width: 110px;
}

/* ---------- MAIN ---------- */
.main {
  flex: 1;
  background: #fff;
  padding: 30px;
}

/* ---------- HEADER ---------- */
.main h1 {
  font-size: 22px;
  font-weight: 600;
  margin-bottom: 25px;
}

/* ---------- MESSAGES CARD ---------- */
.card {
  background: #f7f7f7;
  padding: 20px;
  border-radius: 10px;
}

.card h2 {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 12px;
}

/* ---------- MESSAGE LIST ---------- */
.message-list {
  list-style: none;
  padding: 0;
}

.message-list li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  border-bottom: 1px solid #ddd;
}

.message-list li:last-child {
  border-bottom: none;
}

.message-content {
  flex: 1;
}

.message-content h3 {
  font-size: 16px;
  margin-bottom: 5px;
}

.message-content p {
  color: #777;
  font-size: 14px;
}

.message-timestamp {
  color: #777;
  font-size: 14px;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <img class="profile" src="http://localhost/Client/Images/Man.png" alt="Profile picture">
  <h3>Andrei Narito</h3>

  <ul>
    <li><a href="Buyer_dashboard.php">Dashboard</a></li>
    <li><a href="Buyer_orders.php">Orders</a></li>
    <li><a href="Buyer_cart.php">Cart</a></li>
    <li><a href="#" class="active">Messages</a></li>
    <li><a href="Buyer_settings.php">Settings</a></li>
    <li><a href="Login.php">Logout</a></li>
  </ul>

  <div class="logo">
    <img src="/Client/Images/HoopersFits.png" alt="Hoopers Fits Logo">
  </div>
</div>

<!-- MAIN -->
<div class="main">
  <h1>Messages</h1>

  <div class="card">
    <h2>Your Messages</h2>
    <ul class="message-list">
      <li>
        <div class="message-content">
          <h3>Pablo jab Reyes</h3>
          <p>Order Confirmation</p>
        </div>
        <span class="message-timestamp">2:30 PM</span>
      </li>
      <li>
        <div class="message-content">
          <h3>Lina Mutac Montes</h3>
          <p>Shipping Update</p>
        </div>
        <span class="message-timestamp">9:30 AM</span>
      </li>
      <li>
        <div class="message-content">
          <h3>Ma. Antot Fukiko</h3>
          <p>Account Help</p>
        </div>
        <span class="message-timestamp">Yesterday</span>
      </li>
      <li>
        <div class="message-content">
          <h3>Juan Carlos</h3>
          <p>Promotion</p>
        </div>
        <span class="message-timestamp">August 18</span>
      </li>
    </ul>
  </div>
</div>

</body>
</html>