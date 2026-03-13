<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buyer Dashboard</title>

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

.main {
  flex: 1;
  background: #fff;
  padding: 30px;
}

.main h1 {
  font-size: 22px;
  font-weight: 600;
  margin-bottom: 25px;
}

.dashboard-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 25px;
}

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

.profile-box h3 {
  font-size: 15px;
  font-weight: 600;
}

.profile-box p {
  font-size: 12px;
  color: #777;
}

.message-box {
  display: flex;
  justify-content: center;
  align-items: center;
}

.message-box button {
  background: #eaeaea;
  border: none;
  padding: 10px 22px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 13px;
  transition: 0.3s;
}

.message-box button:hover {
  background: #ddd;
}

.orders ul {
  list-style: none;
}

.orders li {
  display: flex;
  justify-content: space-between;
  padding: 10px 0;
  font-size: 13px;
  border-bottom: 1px solid #ddd;
}

.orders li:last-child {
  border-bottom: none;
}

.spending {
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  font-weight: 700;
}
</style>
</head>

<body>

<div class="sidebar">
  <img class="profile" src="/Client/Images/Man.png" alt="Profile picture">
  <h3>Andrei Narito</h3>

  <ul>
    <li><a class="active" href="#">Dashboard</a></li>
    <li><a href="Buyer_orders.php">Orders</a></li>
    <li><a href="Buyer_cart.php">Cart</a></li>
    <li><a href="Buyer_Messages.php">Messages</a></li>
    <li><a href="Buyer_Settings.php">Settings</a></li>
    <li><a href="Login.php">Logout</a></li>
  </ul>

  <div class="logo">
    <img src="/Client/Images/HoopersFits.png" alt="Hoopers Fits Logo">
  </div>
</div>

<div class="main">
  <h1>Buyer Dashboard</h1>

  <div class="dashboard-grid">
    <div class="card profile-box">
      <h2>Profile Summary</h2>
      <h3>Andrei Lapuz Narito</h3>
      <p>Andrei@gmail.com</p>
    </div>

    <div class="card message-box">
      <button>Message</button>
    </div>

    <div class="card orders">
      <h2>Recent Orders</h2>
      <ul>
        <li><span>Chrome Heart Net Cap</span><span>Jan 7, 2026</span></li>
        <li><span>Stussy</span><span>Aug 18</span></li>
        <li><span>BLKZN Cap</span><span>Last month</span></li>
        <li><span>Chrome Heart Zipper Jacket</span><span>2 Months Ago</span></li>
      </ul>
    </div>

    <div class="card spending">
      ₱ 2424.24
    </div>

  </div>
</div>

</body>
</html>