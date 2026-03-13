import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./Pages/Login";
import Register from "./Pages/Register";
import Privacy from "./Pages/Privacy";
import Terms from "./Pages/Terms";
import BuyerHome from "./Pages/Buyer_home";
import BuyerShop from "./Pages/Buyer_shop";

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/privacy" element={<Privacy />} />
        <Route path="/terms" element={<Terms />} />
        <Route path="/buyer_home" element={<BuyerHome />} />
        <Route path="/buyer_shop" element={<BuyerShop />} />
      </Routes>
    </Router>
  );
}

export default App;