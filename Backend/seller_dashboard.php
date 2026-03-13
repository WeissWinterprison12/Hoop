<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

.add-product {
  background: #6f42c1;
  color: #fff;
  border: none;
  padding: 8px 14px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 13px;
}

/* ---------- DASHBOARD GRID ---------- */
.dashboard {
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 20px;
}

/* ---------- LEFT STATS ---------- */
.left-stats {
  display: grid;
  gap: 15px;
}

.stat-card {
  background: #111;
  color: #fff;
  padding: 20px;
  border-radius: 12px;
}

.stat-card h3 {
  font-size: 22px;
}

.stat-card p {
  font-size: 12px;
  color: #aaa;
  margin-top: 5px;
}

.top-products ol {
  margin-top: 10px;
  padding-left: 18px;
  font-size: 13px;
  color: #ccc;
}

/* ---------- RIGHT CONTENT ---------- */
.right-content {
  display: grid;
  gap: 20px;
}

.small-cards {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}

.small-card {
  background: #bdb5b5;
  padding: 20px;
  border-radius: 12px;
}

.small-card h3 {
  font-size: 20px;
}

.small-card p {
  font-size: 12px;
  margin-top: 5px;
}

/* ---------- ACTIVITY ---------- */
.activity {
  background: #bdb5b5;
  padding: 20px;
  border-radius: 12px;
}

.activity h4 {
  font-size: 14px;
  margin-bottom: 10px;
}

/* ---------- TABLE ---------- */
.orders {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
}

.orders h4 {
  font-size: 14px;
  margin-bottom: 10px;
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

.processing { color: orange; }
.completed { color: green; }
</style>
</head>
<body>
<!-- SIDEBAR -->
<div class="sidebar">
  <h2>Seller</h2>
  <ul>
    <li><a class="active" href="#">Dashboard</a></li>
    <li><a href="seller_product.php" id="product-link">Product</a></li>
    <li><a href="seller_settings.php" id="settings-link">Settings</a></li>
    <li><a href="seller_orders.php">Orders</a></li>
    <li><a href="seller_messages.php">Messages</a></li>
    <br>
    <br>
    <br>
    <li><a href="Login.php">Logout</a></li>
  </ul>
</div>
<!-- MAIN -->
<div class="main">
  <div class="top-bar">
    <h1>Dashboard</h1>
    <button class="add-product">Add New Product</button>
  </div>
  <div class="dashboard">
<!-- LEFT -->
<div class="left-stats">
  <div class="stat-card">
    <h3>99</h3>
    <p>Total Orders</p>
  </div>

  <div class="stat-card">
    <h3>99</h3>
    <p>Total Sell</p>
  </div>

  <div class="stat-card">
    <h3>99</h3>
    <p>Total Products</p>
  </div>

  <div class="stat-card top-products">
    <p>Top Products</p>
    <ol>
      <li>Bas Bro Shop</li>
      <li>BLACKSON</li>
      <li>CDG x Stussy</li>
      <li>Saint God Hoodie</li>
    </ol>
  </div>
</div>

<!-- RIGHT -->
<div class="right-content">

  <div class="small-cards">
    <div class="small-card">
      <h3>₱49,920</h3>
      <p>Total Sales</p>
    </div>
    <div class="small-card">
      <h3>58</h3>
      <p>New Customers</p>
    </div>
  </div>

  <div class="activity">
    <h4>Activity (Monthly Sales)</h4>
    <canvas id="salesChart" height="120"></canvas>
  </div>

  <div class="orders">
    <h4>Latest Orders</h4>
    <table>
      <tr>
        <th>Product</th>
        <th>Order Date</th>
        <th>Price</th>
        <th>Payment</th>
        <th>Status</th>
      </tr>

      <tr>
        <td>Bas Bro Shop</td>
        <td>June 12, 12:20pm</td>
        <td>₱1,999</td>
        <td>Credit Card</td>
        <td class="status processing">Processing</td>
      </tr>

      <tr>
        <td>BLACKSON</td>
        <td>June 12, 12:20pm</td>
        <td>₱299.50</td>
        <td>Transfer</td>
        <td class="status processing">Processing</td>
      </tr>

      <tr>
        <td>CDG x Stussy</td>
        <td>June 12, 12:20pm</td>
        <td>₱265</td>
        <td>Credit Card</td>
        <td class="status completed">Completed</td>
      </tr>

      <tr>
        <td>Saint God Hoodie</td>
        <td>June 12, 12:20pm</td>
        <td>₱950</td>
        <td>Transfer</td>
        <td class="status processing">Processing</td>
      </tr>
    </table>
  </div>

</div>

  </div>
</div>
<script>
const ctx = document.getElementById('salesChart').getContext('2d');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    datasets: [{
      data: [1200, 1900, 800, 1500, 2200, 3000, 1800, 2500, 2100, 3200, 2800, 3500],
      backgroundColor: '#6f42c1',
      borderRadius: 6
    }]
  },
  options: {
    plugins: { legend: { display: false }},
    animation: { duration: 1500, easing: 'easeOutQuart' },
    scales: {
      y: { beginAtZero: true },
      x: { grid: { display: false } }
    }
  }
});

</script>
</body>
</html>