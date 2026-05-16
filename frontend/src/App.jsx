import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import { AuthProvider } from "./AuthContext";
// import ProtectedRoute from "./ProtectedRoute"; // UNUSED
// import RoleProtectedRoute from "./RoleProtectedRoute"; // REMOVED
import Login from "./Pages/Login";
import Register from "./Pages/Register";
import Privacy from "./Pages/Privacy";
import Terms from "./Pages/Terms";
import BuyerHome from "./Pages/Buyer_home";
import BuyerShop from "./Pages/Buyer_shop";
import Pr from "./Pages/Pr";
import SellerDashboard from "./Pages/seller_dashboard";
import SellerProduct from "./Pages/seller_product";
import SellerSettings from "./Pages/seller_settings";
import SellerOrders from "./Pages/seller_orders";
import SellerMessages from "./Pages/seller_messages";
import Checkout from "./Pages/checkout";
import Contact from "./Pages/contact";
import BuyerDashboard from "./Pages/Buyer_dashboard";

function App() {
  return (
    <AuthProvider>
      <Router>
        <Routes>
          {/* 📱 PUBLIC ROUTES - No authentication required */}
          <Route path="/login" element={<Login />} />
          <Route path="/register" element={<Register />} />
          <Route path="/privacy" element={<Privacy />} />
          <Route path="/terms" element={<Terms />} />
          <Route path="/Pr" element={<Pr />} />
          <Route path="/contact" element={<Contact />} />

          {/* 🛒 BUYER ROUTES - Now public */}
          <Route path="/buyer_home" element={<BuyerHome />} />
          <Route path="/buyer_shop" element={<BuyerShop />} />
          <Route path="/buyer_dashboard" element={<BuyerDashboard />} />
          <Route path="/checkout" element={<Checkout />} />

          {/* 🏪 SELLER/ADMIN ROUTES - Now public */}
          <Route path="/seller_dashboard" element={<SellerDashboard />} />
          <Route path="/seller_product" element={<SellerProduct />} />
          <Route path="/seller_settings" element={<SellerSettings />} />
          <Route path="/seller_orders" element={<SellerOrders />} />
          <Route path="/seller_messages" element={<SellerMessages />} />
          
          <Route path="/" element={<Login />} />
          <Route path="*" element={<Login />} />
        </Routes>
      </Router>
    </AuthProvider>
  );
}

export default App;