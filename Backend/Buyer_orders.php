<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buyer's Orders</title>

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

/* ---------- ORDERS CARD ---------- */
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

/* ---------- ORDERS TABLE ---------- */
.orders-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.orders-table th, .orders-table td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.orders-table th {
  font-weight: 500;
  color: #777;
}

.orders-table tbody tr:last-child td {
  border-bottom: none;
}

.orders-table td.order-image {
  width: 80px;
}

.orders-table td.order-image img {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 5px;
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
    <li><a href="#" class="active">Orders</a></li>
    <li><a href="Buyer_cart.php">Cart</a></li>
    <li><a href="Buyer_Messages.php">Messages</a></li>
    <li><a href="Buyer_Settings.php">Settings</a></li>
    <li><a href="Login.php">Logout</a></li>
  </ul>

  <div class="logo">
    <img src="/Client/Images/HoopersFits.png" alt="Hoopers Fits Logo">
  </div>
</div>

<!-- MAIN -->
<div class="main">
  <h1>Orders</h1>

  <div class="card">
    <h2>Your Orders</h2>

    <table class="orders-table">
      <thead>
        <tr>
          <th>Order</th>
          <th>Product</th>
          <th>Price</th>
          <th>Date Ordered</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="order-image"><img src="../Images/ChromeCap.jpg" alt="Product Image"></td>
          <td>Chrome Heart Net Cap</td>
          <td>₱ 549.25</td>
          <td>Jan 07</td>
          <td>Returned</td>
        </tr>
        <tr>
          <td class="order-image"><img src="../Images/StussyProduct.jpg" alt="Product Image"></td>
          <td>Stussy</td>
          <td>₱ 699.99</td>
          <td>Aug 18</td>
          <td>Delivered</td>
        </tr>
        <tr>
          <td class="order-image"><img src="../Images/BLCKSZN.jpg" alt="Product Image"></td>
          <td>BLKZN Cap</td>
          <td>₱ 299.50</td>
          <td>Last Month</td>
          <td>Delivered</td>
        </tr>
        <tr>
          <td class="order-image"><img src="../Images/ChromeZip.jpg" alt="Product Image"></td>
          <td>Chrome Heart Zipper Jacket</td>
          <td>₱ 876.50</td>
          <td>2 Months Ago</td>
          <td>Refunded</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>