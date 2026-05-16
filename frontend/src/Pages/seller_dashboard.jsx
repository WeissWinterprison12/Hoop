import React, { useEffect, useState } from 'react';
import { useAuth } from '../AuthContext';
import { syncProfile, getDisplayAvatar } from '../utils/profileSync';
import '../components/seller_dashboard.css';

const SellerDashboard = () => {
  const { user, logout } = useAuth();
  const [showProfileModal, setShowProfileModal] = useState(false);
  const [selectedFile, setSelectedFile] = useState(null);
  const [previewImage, setPreviewImage] = useState(null);
  const [editedName, setEditedName] = useState("");
  
  const [adminProfile, setAdminProfile] = useState({
    name: "",
    avatar: null
  });


  const [totalOrders, setTotalOrders] = useState(0);
  const [totalSales, setTotalSales] = useState(0);
  const [totalProducts, setTotalProducts] = useState(0);
  const [monthlyRevenue, setMonthlyRevenue] = useState(0);
  const [newCustomers, setNewCustomers] = useState(0);
  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    syncProfile(setAdminProfile, setEditedName);
  }, []);

  useEffect(() => {
    setEditedName(adminProfile.name);
  }, [adminProfile.name]);

  useEffect(() => {
  const fetchDashboardData = async () => {
    if (!user?.user_id && !user?.id) {
      setError("User not authenticated");
      setLoading(false);
      return;
    }

    const userId = user.user_id || user.id;
    
    try {
      setLoading(true);
      setError(null);
      
      console.log(`📡 Fetching data for seller ID: ${userId}`);
      
      const response = await fetch(`http://localhost/hooper_fits_api/seller_dashboard.php?user_id=${userId}`);
      
      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }
      
      const data = await response.json();
      console.log("✅ Real database data:", data);
      
      if (data.error) {
        throw new Error(data.error);
      }
      
      setTotalOrders(data.totalOrders || 0);
      setTotalSales(data.totalSales || 0);
      setTotalProducts(data.totalProducts || 0);
      setMonthlyRevenue(data.monthlyRevenue || 0);
      setNewCustomers(data.newCustomers || 0);
      setOrders(data.orders || []);
      
    } catch (err) {
      console.error("❌ Database error:", err);
      setError(`Database error: ${err.message}`);
      // Show zeros - no fake data
      setTotalOrders(0);
      setTotalSales(0);
      setTotalProducts(0);
      setMonthlyRevenue(0);
      setNewCustomers(0);
      setOrders([]);
    } finally {
      setLoading(false);
    }
  };

    fetchDashboardData();
  }, [user]);

  const getCurrentDisplayAvatar = () => {
    if (previewImage) return previewImage;
    return getDisplayAvatar(adminProfile.avatar);
  };

  // ✅ ALL ORIGINAL FUNCTIONS RESTORED
  const handleFileSelect = (e) => {
    const file = e.target.files[0];
    if (file) {
      setSelectedFile(file);
      setPreviewImage(URL.createObjectURL(file));
    }
  };

  const openFileExplorer = () => {
    const fileInput = document.querySelector(".modal-image-upload input");
    if (fileInput) fileInput.click();
  };

  const handleSaveProfile = () => {
    setShowProfileModal(false);
    setSelectedFile(null);
    setPreviewImage(null);
  };

  const handleCancelProfile = () => {
    setShowProfileModal(false);
    setSelectedFile(null);
    setPreviewImage(null);
    setEditedName(adminProfile.name);
  };

  const handleLogout = () => logout();

  if (loading) {
    return (
      <div className="seller-dashboard-app" style={{display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: '100vh', background: '#000', color: '#fff'}}>
        <div>⏳ Loading your dashboard...</div>
      </div>
    );
  }

  return (
    <div className="seller-dashboard-app">
      {showProfileModal && (
        <div className="profile-modal" onClick={handleCancelProfile}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            <button className="close-modal" onClick={handleCancelProfile}>×</button>
            <div className="modal-image-upload" onClick={openFileExplorer}>
              {previewImage ? (
                <img src={previewImage} alt="Preview" style={{width: "100%", height: "100%", borderRadius: "50%", objectFit: "cover"}} />
              ) : getCurrentDisplayAvatar() ? (
                <img src={getCurrentDisplayAvatar()} alt="Profile" style={{width: "100%", height: "100%", borderRadius: "50%", objectFit: "cover"}} />
              ) : (
                <div className="question-mark-avatar">?</div>
              )}
              <input type="file" accept="image/*" onChange={handleFileSelect} />
            </div>
            <h2 className="modal-title">Update Profile</h2>
            <p className="modal-subtitle">Click the avatar to change profile image</p>
            
            <input 
              type="text" 
              value={editedName} 
              onChange={(e)=>setEditedName(e.target.value)} 
              className="profile-name-input"
              placeholder="Enter your name"
            />

            <button className="get-image-btn" onClick={handleSaveProfile}>💾 Save Changes</button>
            <button className="cancel-btn" onClick={handleCancelProfile}>❌ Cancel</button>
          </div>
        </div>
      )}

      <div className="sidebar">
        <div className="admin-profile">
          <div 
            className="profile-avatar"
            onClick={() => setShowProfileModal(true)}
          >
            {getCurrentDisplayAvatar() ? (
              <img 
                src={getCurrentDisplayAvatar()} 
                alt="Profile" 
                onError={(e) => {
                  e.target.style.display = 'none';
                  e.target.parentNode.innerHTML = '<div class="question-mark-avatar">?</div>';
                }}
              />
            ) : (
              <div className="question-mark-avatar">?</div>
            )}
          </div>
          <p className="profile-name">{adminProfile.name || "Set your name"}</p>
          {user && <p className="profile-username" style={{fontSize: '12px', opacity: 0.7}}>@{user.username}</p>}
        </div>
        <ul>
          <li><a className="active" href="/seller_dashboard">📊 Dashboard</a></li>
          <li><a href="/seller_product">📦 Products</a></li>
          <li><a href="/seller_settings">⚙️ Settings</a></li>
          <li><a href="/seller_orders">📋 Orders</a></li>
          <li><a href="/seller_messages">💬 Messages</a></li>
          <br /><br /><br />
          <li><a href="#" onClick={handleLogout}>🚪 Logout</a></li>
        </ul>
      </div>

      {/* ✅ ORIGINAL MAIN CONTENT - FULLY RESTORED */}
      <div className="main">
        <div className="top-bar">
          <h1>Dashboard Overview</h1>
          {error && <p style={{color: '#ff6b6b', fontSize: '14px'}}>⚠️ {error}</p>}
        </div>

        <div className="dashboard">
          <div className="left-stats">
            <div className="stat-card">
              <h3>{totalOrders}</h3>
              <p>Total Orders</p>
            </div>

            <div className="stat-card">
              <h3>₱{Number(totalSales).toLocaleString()}</h3>
              <p>Total Sales</p>
            </div>

            <div className="stat-card">
              <h3>{totalProducts}</h3>
              <p>Total Products</p>
            </div>

            <div className="stat-card top-products">
              <p>🔥 Top Products</p>
              <ol></ol>
            </div>
          </div>

          <div className="right-content">
            <div className="small-cards">
              <div className="small-card">
                <h3>₱{Number(monthlyRevenue).toLocaleString()}</h3>
                <p>Monthly Revenue</p>
              </div>

              <div className="small-card">
                <h3>{newCustomers}</h3>
                <p>New Customers</p>
              </div>
            </div>

            <div className="activity">
              <h4>📈 Activity (Monthly Sales)</h4>
              <div className="chart-placeholder"></div>
            </div>

            <div className="orders">
              <h4>📦 Latest Orders</h4>
              <table>
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Date</th>
                    <th>Price</th>
                    <th>Payment</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  {orders.map((order, index) => (
                    <tr key={order.id || index}>
                      <td>{order.product}</td>
                      <td>{order.date}</td>
                      <td>₱{Number(order.price).toLocaleString()}</td>
                      <td>{order.payment}</td>
                      <td className={`status ${order.status}`}>
                        {order.status}
                      </td>
                    </tr>
                  ))}
                  {orders.length === 0 && (
                    <tr>
                      <td colSpan="5" style={{textAlign: 'center', color: '#666', padding: '20px'}}>
                        No orders yet. Start selling! 🚀
                      </td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default SellerDashboard;