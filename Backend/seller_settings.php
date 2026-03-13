<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Settings</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: 'Poppins', sans-serif;
  background: #e5e5e5;
  display: flex;
  min-height: 100vh;
}

/* ---------- SIDEBAR ---------- */
.sidebar {
  width: 220px;
  background: #111;
  color: #fff;
  padding: 20px;
}

.sidebar h2 {
  font-size: 18px;
  margin-bottom: 30px;
}

.sidebar ul {
  list-style: none;
}

.sidebar li {
  margin-bottom: 12px;
}

.sidebar a {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 15px;
  text-decoration: none;
  color: #ccc;
  border-radius: 8px;
  transition: 0.3s;
}

.sidebar a.active,
.sidebar a:hover {
  background: #6f42c1;
  color: #fff;
}

/* ---------- MAIN ---------- */
.main {
  flex: 1;
  padding: 25px;
}

/* ---------- TOP BAR ---------- */
.top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}

.top-bar h1 {
  font-size: 18px;
  font-weight: 600;
}

/* ---------- SETTINGS CONTAINER ---------- */
.settings-container {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
}

.settings-container h2 {
  font-size: 20px;
  margin-bottom: 10px;
  color: #000;
}

.settings-container p {
  color: #777;
  font-size: 14px;
  margin-bottom: 20px;
}

.settings-grid {
  display: grid;
  gap: 15px;
}

.setting-option {
  background: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s, box-shadow 0.3s;
}

.setting-option:hover {
  background: #e0e0e0;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.setting-option h3 {
  margin: 0;
  font-size: 16px;
  color: #000;
}

.setting-option p {
  margin: 5px 0 0;
  font-size: 12px;
  color: #555;
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h2>Seller</h2>
  <ul>
    <li><a href="seller_dashboard.php">Dashboard</a></li>
    <li><a href="seller_product.php">Product</a></li>
    <li><a href="seller_settings.php" class="active">Settings</a></li>
    <li><a href="seller_orders.php">Orders</a></li>
    <li><a href="seller_messages.php">Messages</a></li>
    <br>
    <br>
    <br>
    <li><a href="Login.php">Logout</a></li>
  </ul>
</div>


<div class="main">

  <div class="top-bar">
    <h1>Settings</h1>
  </div>

  <div class="settings-container">
    <h2>ACCOUNT SETTINGS</h2>
    <p>Manage your personal and store details.</p>

    <div class="settings-grid">
      <div class="setting-option">
        <h3>Store Profile</h3>
        <p>Manage your store name, logo, and business information.</p>
      </div>

      <div class="setting-option">
        <h3>Store Information Card</h3>
        <p>Set up how you receive and manage your earnings.</p>
      </div>

      <div class="setting-option">
        <h3>Shipping Options</h3>
        <p>Choose courier partners, define shipping rates, and manage delivery time estimates.</p>
      </div>

      <div class="setting-option">
        <h3>Notifications & Alerts</h3>
        <p>Control what updates and alerts you receive from your dashboard.</p>
      </div>

      <div class="setting-option">
        <h3>Security & Access</h3>
        <p>Manage your account's safety and access settings.</p>
      </div>
    </div>
  </div>
</div>

<script>

</body>
</html>