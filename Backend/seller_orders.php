<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Orders</title>

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

.main {
  flex: 1;
  padding: 25px;
}

.orders {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
}

.orders h2 {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}

th {
  text-align: left;
  color: #777;
  font-weight: 600;
  padding-bottom: 8px;
}

td {
  padding: 10px 0;
  border-bottom: 1px solid #eee;
}

.status {
  font-weight: 600;
}

.shipped { color: orange; }
.completed { color: green; }
.cancelled { color: red; }
</style>
</head>
<body>

<div class="sidebar">
  <h2>Seller</h2>
  <ul>
    <li><a href="seller_dashboard.php">Dashboard</a></li>
    <li><a href="seller_product.php">Product</a></li>
    <li><a href="seller_settings.php">Settings</a></li>
    <li><a href="seller_orders.php" class="active">Orders</a></li>
    <li><a href="seller_messages.php">Messages</a></li>
    <br>
    <br>
    <br>
    <li><a href="Login.php">Logout</a></li>
  </ul>
</div>

<div class="main">
  <div class="orders">
    <h2>Orders</h2>

    <table>
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Date</th>
          <th>Customer Name</th>
          <th>Products</th>
          <th>Total</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1853</td>
          <td>2026-01-09</td>
          <td>Kyle Lowry</td>
          <td>BLKSZN Cap</td>
          <td>299.50</td>
          <td class="Shipped">Shipped</td>
        </tr>
        <tr>
          <td>1964</td>
          <td>2026-01-08</td>
          <td>Arisu Letusawa</td>
          <td>Stussy</td>
          <td>699.99</td>
          <td class="completed">Completed</td>
        </tr>

        <tr>
          <td>1244</td>
          <td>2026-01-07</td>
          <td>Andrei Lapuz Narito</td>
          <td>Chrome Heart Net Cap</td>
          <td>549.25</td>
          <td class="cancelled">Returned</td> 
        </tr>
       
        <tr>
          <td>1175</td>
          <td>2026-01-07</td>
          <td>Ramon Lorenzo Neri</td>
          <td>Bas Bro Shop Cap</td>
          <td>1999.99</td>
          <td class="cancelled">Refunded</td> 
        </tr>

      </tbody>
    </table>

    
  </div>
</div>

</body>
</html>