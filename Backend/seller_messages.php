<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Seller Messages</title>

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

/* ---------- MESSAGES ---------- */
.messages {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
}

.messages h2 {
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

.unread { color: orange; }
.read { color: green; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
  <h2>Seller</h2>
  <ul>
    <li><a href="seller_dashboard.php">Dashboard</a></li>
    <li><a href="seller_product.php">Product</a></li>
    <li><a href="seller_settings.php">Settings</a></li>
    <li><a href="seller_orders.php">Orders</a></li>
    <li><a href="seller_messages.php" class="active">Messages</a></li>
    <br>
    <br>
    <br>
    <li><a href="Login.php">Logout</a></li>
  </ul>
</div>

<!-- MAIN -->
<div class="main">
  <div class="messages">
    <h2>Messages</h2>

    <table>
      <thead>
        <tr>
          <th>Sender</th>
          <th>Subject</th>
          <th>Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>@kylebuys</td>
          <td>Hi po! Available pa po ba yung hoodie sa size medium?</td>
          <td>1 min ago</td>
          <td class="status unread">Unread</td>
        </tr>
        <tr>
          <td>@arisuuu</td>
          <td>Pwede po bang COD sa Cavite Area?</td>
          <td>9:30 PM</td>
          <td class="status read">Read</td>
        </tr>
        <tr>
          <td>@Andrei</td>
          <td>Kelan po estimated delivery kung ngayon ako order?</td>
          <td>16 hours ago</td>
          <td class="status unread">Unread</td>
        </tr>
        <tr>
          <td>@RAMON</td>
          <td>SALAMAT PO! NARECIEVE KO NA YUNG ITEM, GANDA NG QUALITY!</td>
          <td>2 days ago</td>
          <td class="status unread">Unread</td>
        </tr>
        <tr>
          <td>@Lhesster11234</td>
          <td>Salamat po sa pag refund ng items ill make sure to order the correct one thank you.</td>
          <td>2 days ago</td>
          <td class="status read">Read</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>