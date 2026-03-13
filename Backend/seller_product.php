<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Product</title>

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

.add-product {
  background: #6f42c1;
  color: #fff;
  border: none;
  padding: 8px 14px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 13px;
}

/* ---------- TOP STATS ---------- */
.top-stats {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-bottom: 25px;
}

.stat-card {
  background: #111;
  color: #fff;
  padding: 20px;
  border-radius: 12px;
  text-align: center;
}

.stat-card h3 {
  font-size: 22px;
  margin: 0;
}

.stat-card p {
  font-size: 12px;
  color: #aaa;
  margin-top: 5px;
}

/* ---------- INVENTORY TABLE ---------- */
.inventory-table {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
}

.inventory-table h4 {
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

.status-badge {
  padding: 5px 10px;
  border-radius: 5px;
  color: #ffffff;
  font-weight: 600;
}

.status-badge.active {
  background-color: #4caf50;
}

.status-badge.out-of-stock {
  background-color: #f44336;
}

.status-badge.low-stock {
  background-color: #ff9800;
}

.actions {
  text-align: center;
}

.actions button {
  background: none;
  color: #777;
  border: none;
  cursor: pointer;
  margin: 0 5px;
  font-size: 13px;
  transition: color 0.3s;
}

.actions button:hover {
  color: #000;
}

/* ---------- PAGINATION ---------- */
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.pagination button {
  background: #f0f0f0;
  color: #000;
  border: none;
  padding: 8px 12px;
  margin: 0 3px;
  border-radius: 3px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.pagination button.active,
.pagination button:hover {
  background: #6f42c1;
  color: #fff;
}
</style>
</head>
<body>


<div class="sidebar">
  <h2>Seller</h2>
  <ul>
    <li><a href="seller_dashboard.php">Dashboard</a></li>
    <li><a href="seller_product.php" class="active">Product</a></li>
    <li><a href="seller_settings.php">Settings</a></li>
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
    <h1>Products</h1>
    <button class="add-product">Add New Product</button>
  </div>

  <div class="top-stats">
    <div class="stat-card">
      <h3>8</h3>
      <p>Active Items</p>
    </div>
    <div class="stat-card">
      <h3>8</h3>
      <p>Out of Stock Items</p>
    </div>
    <div class="stat-card">
      <h3>8</h3>
      <p>Low Stock Items</p>
    </div>
  </div>

  <div class="inventory-table">
    <h4>Inventory</h4>
    <table>
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Stock</th>
          <th>Price</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Bas Bro Shop</td>
          <td>69</td>
          <td>1,999</td>
          <td><span class="status-badge active">Active</span></td>
          <td class="actions">
            <button>Edit</button>
            <button>Delete</button>
          </td>
        </tr>
        <tr>
          <td>Saint God Hoodie</td>
          <td>0</td>
          <td>950</td>
          <td><span class="status-badge out-of-stock">Out of Stock</span></td>
          <td class="actions">
            <button>Edit</button>
            <button>Delete</button>
          </td>
        </tr>
        <tr>
          <td>BLACKSON</td>
          <td>11</td>
          <td>299.0</td>
          <td><span class="status-badge low-stock">Low Stock</span></td>
          <td class="actions">
            <button>Edit</button>
            <button>Delete</button>
          </td>
        </tr>
        <tr>
          <td>CDG x Stussy Vanity Jacket</td>
          <td>62</td>
          <td>565.50</td>
          <td><span class="status-badge active">Active</span></td>
          <td class="actions">
            <button>Edit</button>
            <button>Delete</button>
          </td>
        </tr>
        <tr>
          <td>Chrome Heart Net Cap</td>
          <td>0</td>
          <td>549.50</td>
          <td><span class="status-badge out-of-stock">Out of Stock</span></td>
          <td class="actions">
            <button>Edit</button>
            <button>Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="pagination">
    <button>&laquo;</button>
    <button class="active">1</button>
    <button>2</button>
    <button>3</button>
    <button>4</button>
    <button>&raquo;</button>
  </div>
</div>


</body>
</html>