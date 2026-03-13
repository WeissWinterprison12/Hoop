<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buyer's Cart</title>

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

/* ---------- CART CARD ---------- */
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

/* ---------- CART TABLE ---------- */
.cart-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.cart-table th, .cart-table td {
  padding: 12px 15px;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.cart-table th {
  font-weight: 500;
  color: #777;
}

.cart-table tbody tr:last-child td {
  border-bottom: none;
}

.cart-table td.product-image {
  width: 80px;
}

.cart-table td.product-image img {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 5px;
}

.cart-table td.quantity-controls {
  text-align: center;
}

.cart-table td.quantity-controls button {
  background-color: #eee;
  border: none;
  padding: 5px 10px;
  border-radius: 3px;
  cursor: pointer;
  margin: 0 3px;
  transition: background-color 0.3s ease;
}

.cart-table td.quantity-controls button:hover {
  background-color: #ddd;
}

.cart-table td.delete-item {
  text-align: center;
}

.cart-table td.delete-item a {
  color: #dc3545; /* Red to match theme */
  text-decoration: none;
}

/* ---------- CHECKOUT BUTTON ---------- */
.checkout-button {
  display: block;
  background: #eaeaea;
  color: #333;
  text-align: center;
  padding: 12px 20px;
  border-radius: 8px;
  text-decoration: none;
  margin-top: 20px;
  transition: 0.3s;
  width: 150px;
  margin-left: auto;
}

.checkout-button:hover {
  background: #ddd;
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
    <li><a href="#" class="active">Cart</a></li>
    <li><a href="Buyer_messages.php">Messages</a></li>
    <li><a href="Buyer_settings.php">Settings</a></li>
    <li><a href="Login.php">Logout</a></li>
  </ul>

  <div class="logo">
    <img src="/Client/Images/HoopersFits.png" alt="Hoopers Fits Logo">
  </div>
</div>

<!-- MAIN -->
<div class="main">
  <h1>Cart</h1>

  <div class="card">
    <h2>Your Cart</h2>

    <table class="cart-table">
      <thead>
        <tr>
          <th></th>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="product-image"><img src="../Images/BassBro.jpg" alt="Product Image"></td>
          <td>Bas Bro Shop</td>
          <td>₱ 1999.99</td>
          <td class="quantity-controls">
            <button>-</button>
            <span>1</span>
            <button>+</button>
          </td>
          <td class="delete-item"><a href="#">Delete</a></td>
        </tr>
        <tr>
          <td class="product-image"><img src="../Images/Saint.jpg" alt="Product Image"></td>
          <td>Saint Of GOD Hoodie</td>
          <td>₱ 950.99</td>
          <td class="quantity-controls">
            <button>-</button>
            <span>1</span>
            <button>+</button>
          </td>
          <td class="delete-item"><a href="#">Delete</a></td>
        </tr>
        <tr>
          <td class="product-image"><img src="../Images/BLCKSZN.jpg" alt="Product Image"></td>
          <td>BLKZN Cap</td>
          <td>₱ 299.50</td>
          <td class="quantity-controls">
            <button>-</button>
            <span>1</span>
            <button>+</button>
          </td>
          <td class="delete-item"><a href="#">Delete</a></td>
        </tr>
      </tbody>
    </table>

    <a href="#" class="checkout-button">Check Out</a>
  </div>
</div>

</body>
</html>