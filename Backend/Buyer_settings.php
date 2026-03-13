<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buyer's Settings</title>

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

/* ---------- SETTINGS CARD ---------- */
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

/* ---------- SETTINGS LIST ---------- */
.settings-list {
  list-style: none;
  padding: 0;
}

.settings-list li {
  padding: 15px;
  border-bottom: 1px solid #ddd;
}

.settings-list li:last-child {
  border-bottom: none;
}

.settings-list li h3 {
  font-size: 16px;
  margin-bottom: 5px;
}

.settings-list li p {
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
    <li><a href="Buyer_messages.php">Messages</a></li>
    <li><a href="#" class="active">Settings</a></li>
    <li><a href="Login.php">Logout</a></li>
  </ul>

  <div class="logo">
    <img src="/Client/Images/HoopersFits.png" alt="Hoopers Fits Logo">
  </div>
</div>

<!-- MAIN -->
<div class="main">
  <h1>Settings</h1>

  <div class="card">
    <h2>Your Settings</h2>
    <ul class="settings-list">
      <li>
        <h3>Account</h3>
        <p>Manage your account details</p>
      </li>
      <li>
        <h3>Payment</h3>
        <p>Manage payment option</p>
      </li>
      <li>
        <h3>Security</h3>
        <p>Change password and security settings</p>
      </li>
      <li>
        <h3>Notification</h3>
        <p>Set your notification preferences</p>
      </li>
    </ul>
  </div>
</div>

</body>
</html>