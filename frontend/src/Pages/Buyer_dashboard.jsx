import React, { useState } from "react";
import { Link } from "react-router-dom"; // ← ADDED FOR LOGO NAVIGATION
import logo from "../Images/HoopersFits.png";
import profilePic from "../Images/Man.png";

const BuyerDashboard = () => {
  const [showProfileModal, setShowProfileModal] = useState(false);
  const [selectedFile, setSelectedFile] = useState(null);
  const [previewImage, setPreviewImage] = useState(null);
  const [editedName, setEditedName] = useState("");
  
  const [buyerProfile, setBuyerProfile] = useState({
    name: "Andrei Lapuz Narito",
    avatar: profilePic
  });

  const [showMessageModal, setShowMessageModal] = useState(false);

  const buyerData = {
    totalSpending: 2424.24,
    recentOrders: [
      { id: 1, name: "Chrome Heart Net Cap", date: "Jan 7, 2026", price: 2500, payment: "GCash", status: "completed" },
      { id: 2, name: "Stussy", date: "Aug 18", price: 1800, payment: "Card", status: "processing" },
      { id: 3, name: "BLKZN Cap", date: "Last month", price: 1200, payment: "Bank", status: "completed" },
      { id: 4, name: "Chrome Heart Zipper Jacket", date: "2 Months Ago", price: 8500, payment: "GCash", status: "completed" }
    ]
  };

  const getDisplayAvatar = () => {
    if (previewImage) return previewImage;
    return buyerProfile.avatar || null;
  };

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

  const handleCancelProfile = () => {
    setShowProfileModal(false);
    setSelectedFile(null);
    setPreviewImage(null);
    setEditedName(buyerProfile.name);
  };

  const handleLogout = () => {
    window.location.href = "/login";
  };

  return (
    <div className="buyer-dashboard-app">
      <style jsx global>{`
        /* RED COLOR SCHEME VERSION OF ADMIN DASHBOARD LAYOUT */
        * {
          box-sizing: border-box;
          margin: 0;
          padding: 0;
        }

        html, body, #root {
          height: 100vh;
          overflow: hidden;
          font-family: 'Poppins', sans-serif;
        }

        .buyer-dashboard-app {
          height: 100vh;
          width: 100vw;
          background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
          display: flex;
          flex-direction: row;
        }

        .sidebar {
          width: 240px;
          background: linear-gradient(180deg, #000 0%, #1a1a1a 100%);
          color: #fff;
          padding: 30px 20px;
          height: 100vh;
          overflow-y: auto;
          flex-shrink: 0;
          box-shadow: 2px 0 20px rgba(0,0,0,0.3);
          position: relative;
        }

        .admin-profile {
          text-align: center;
          margin-bottom: 40px;
          padding-bottom: 25px;
          border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .profile-avatar {
          width: 70px;
          height: 70px;
          border-radius: 50%;
          border: 3px solid #dc3545;
          cursor: pointer;
          transition: all 0.3s ease;
          margin: 0 auto 12px;
          object-fit: cover;
          box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
          position: relative;
          overflow: hidden;
        }

        .profile-avatar:hover {
          transform: scale(1.1);
          border-color: #b02a37;
          box-shadow: 0 10px 30px rgba(220, 53, 69, 0.4);
        }

        .profile-avatar img {
          width: 100%;
          height: 100%;
          object-fit: cover;
        }

        .question-mark-avatar {
          width: 100%;
          height: 100%;
          border-radius: 50%;
          background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 32px;
          color: #dc3545;
          font-weight: bold;
        }

        .profile-name {
          font-size: 16px;
          font-weight: 600;
          color: #fff;
          margin: 0;
          background: linear-gradient(135deg, #fff, #f0f0f0);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          background-clip: text;
        }

        .sidebar ul {
          list-style: none;
        }

        .sidebar li {
          margin-bottom: 8px;
        }

        .sidebar a {
          display: flex;
          align-items: center;
          gap: 12px;
          padding: 14px 16px;
          text-decoration: none;
          color: #ccc;
          border-radius: 12px;
          transition: all 0.3s ease;
          font-size: 14px;
          font-weight: 500;
          position: relative;
          overflow: hidden;
        }

        .sidebar a::before {
          content: '';
          position: absolute;
          top: 0;
          left: -100%;
          width: 100%;
          height: 100%;
          background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
          transition: left 0.5s;
        }

        .sidebar a:hover::before {
          left: 100%;
        }

        .sidebar a.active,
        .sidebar a:hover {
          background: linear-gradient(135deg, #dc3545, #b02a37);
          color: #fff;
          transform: translateX(4px);
          box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }

        .sidebar-logo {
          margin-top: auto;
          padding-top: 30px;
          opacity: 0.8;
          transition: opacity 0.3s;
        }

        .sidebar-logo:hover {
          opacity: 1;
        }

        .sidebar-logo img {
          width: 120px;
          cursor: pointer; /* ← ADDED FOR BETTER UX */
        }

        .main {
          flex: 1;
          padding: 25px;
          height: 100vh;
          overflow-y: auto;
          background: #fff;
        }

        .top-bar {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 25px;
          padding-bottom: 15px;
          border-bottom: 1px solid #ddd;
        }

        .top-bar h1 {
          font-size: 28px;
          font-weight: 600;
          color: #1a1a1a;
          background: linear-gradient(135deg, #dc3545, #b02a37);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          background-clip: text;
        }

        .dashboard {
          display: grid;
          grid-template-columns: 280px 1fr;
          gap: 25px;
          height: calc(100vh - 120px);
        }

        .left-stats {
          display: grid;
          gap: 20px;
          height: 100%;
        }

        .stat-card {
          background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
          color: #fff;
          padding: 25px;
          border-radius: 16px;
          box-shadow: 0 4px 20px rgba(0,0,0,0.1);
          transition: transform 0.3s ease;
          border: 1px solid rgba(220, 53, 69, 0.1);
          position: relative;
          overflow: hidden;
        }

        .stat-card::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          height: 4px;
          background: linear-gradient(90deg, #dc3545, #b02a37);
        }

        .stat-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .stat-card h3 {
          font-size: 32px;
          font-weight: 700;
          margin-bottom: 5px;
          color: #dc3545;
        }

        .stat-card p {
          font-size: 14px;
          color: #aaa;
          font-weight: 500;
        }

        .right-content {
          display: grid;
          grid-template-rows: auto 1fr auto;
          gap: 25px;
          height: 100%;
        }

        .small-cards {
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap: 25px;
        }

        .small-card {
          background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
          padding: 30px;
          border-radius: 16px;
          box-shadow: 0 8px 30px rgba(0,0,0,0.1);
          text-align: center;
          transition: all 0.3s ease;
          border: 1px solid rgba(220, 53, 69, 0.1);
          position: relative;
          overflow: hidden;
        }

        .small-card::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          height: 4px;
          background: linear-gradient(90deg, #dc3545, #b02a37);
        }

        .small-card:hover {
          transform: translateY(-8px);
          box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .small-card h3 {
          font-size: 28px;
          font-weight: 700;
          margin-bottom: 8px;
          background: linear-gradient(45deg, #dc3545, #b02a37);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          background-clip: text;
        }

        .small-card p {
          font-size: 14px;
          color: #666;
          font-weight: 500;
        }

        .activity {
          background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
          padding: 30px;
          border-radius: 16px;
          box-shadow: 0 8px 30px rgba(0,0,0,0.1);
          border: 1px solid rgba(220, 53, 69, 0.1);
        }

        .activity h4 {
          font-size: 18px;
          margin-bottom: 20px;
          color: #1a1a1a;
          font-weight: 600;
          background: linear-gradient(135deg, #dc3545, #b02a37);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          background-clip: text;
        }

        .chart-placeholder {
          height: 200px;
          background: linear-gradient(90deg, #dc3545, #b02a37, #dc3545);
          background-size: 200% 100%;
          border-radius: 12px;
          display: flex;
          align-items: center;
          justify-content: center;
          color: white;
          font-size: 16px;
          font-weight: 600;
          animation: gradientShift 3s ease infinite;
          box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        }

        @keyframes gradientShift {
          0%, 100% { background-position: 0% 50%; }
          50% { background-position: 100% 50%; }
        }

        .orders {
          background: #fff;
          padding: 30px;
          border-radius: 16px;
          box-shadow: 0 8px 30px rgba(0,0,0,0.1);
          height: 100%;
          border: 1px solid rgba(220, 53, 69, 0.1);
        }

        .orders h4 {
          font-size: 18px;
          margin-bottom: 20px;
          color: #1a1a1a;
          font-weight: 600;
          background: linear-gradient(135deg, #dc3545, #b02a37);
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          background-clip: text;
        }

        table {
          width: 100%;
          border-collapse: collapse;
          font-size: 14px;
        }

        th {
          text-align: left;
          color: #666;
          font-weight: 600;
          padding: 15px 0 10px 0;
          border-bottom: 2px solid #eee;
        }

        td {
          padding: 15px 0;
          border-bottom: 1px solid #f5f5f5;
        }

        .status {
          font-weight: 600;
          padding: 6px 12px;
          border-radius: 20px;
          font-size: 12px;
        }

        .processing { 
          background: rgba(255, 165, 0, 0.1);
          color: orange; 
        }
        
        .completed { 
          background: rgba(40, 167, 69, 0.1);
          color: green; 
        }

        /* PROFILE MODAL */
        .profile-modal {
          position: fixed;
          top: 0;
          left: 0;
          width: 100vw;
          height: 100vh;
          background: rgba(0,0,0,0.7);
          display: flex;
          align-items: center;
          justify-content: center;
          z-index: 1000;
          backdrop-filter: blur(5px);
        }

        .modal-content {
          background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
          padding: 40px;
          border-radius: 24px;
          box-shadow: 0 25px 80px rgba(0,0,0,0.3);
          text-align: center;
          max-width: 400px;
          width: 90%;
          animation: modalSlideIn 0.3s ease-out;
          position: relative;
          border: 1px solid rgba(220, 53, 69, 0.1);
        }

        @keyframes modalSlideIn {
          from { opacity: 0; transform: scale(0.8) translateY(-20px); }
          to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .close-modal {
          position: absolute;
          top: 20px;
          right: 25px;
          background: none;
          border: none;
          font-size: 28px;
          cursor: pointer;
          color: #999;
          width: 40px;
          height: 40px;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          transition: all 0.3s ease;
        }

        .close-modal:hover {
          background: rgba(220, 53, 69, 0.1);
          color: #dc3545;
        }

        .modal-image-upload {
          width: 120px;
          height: 120px;
          border-radius: 50%;
          border: 4px dashed #dc3545;
          margin: 0 auto 20px;
          display: flex;
          align-items: center;
          justify-content: center;
          background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
          cursor: pointer;
          transition: all 0.3s ease;
          position: relative;
          overflow: hidden;
        }

        .modal-image-upload:hover {
          background: linear-gradient(135deg, #dc3545, #b02a37);
          transform: scale(1.05);
        }

        .modal-image-upload input {
          position: absolute;
          opacity: 0;
          width: 100%;
          height: 100%;
          cursor: pointer;
        }

        .modal-title {
          font-size: 24px;
          font-weight: 700;
          color: #1a1a1a;
          margin-bottom: 10px;
        }

        .modal-subtitle {
          color: #666;
          margin-bottom: 25px;
          font-size: 14px;
        }

        .profile-name-input {
          width: 100%;
          padding: 16px 20px;
          border-radius: 12px;
          border: 2px solid #eee;
          font-size: 16px;
          outline: none;
          margin-bottom: 20px;
          font-family: 'Poppins', sans-serif;
          transition: all 0.3s ease;
        }

        .profile-name-input:focus {
          border-color: #dc3545;
          box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

                .get-image-btn {
          background: linear-gradient(135deg, #dc3545, #b02a37);
          color: #fff;
          border: none;
          padding: 14px 30px;
          border-radius: 12px;
          cursor: pointer;
          font-size: 16px;
          font-weight: 600;
          transition: all 0.3s ease;
          box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
          width: 100%;
          margin-bottom: 10px;
        }

        .get-image-btn:hover {
          transform: translateY(-2px);
          box-shadow: 0 10px 30px rgba(220, 53, 69, 0.4);
        }

        .cancel-btn {
          background: linear-gradient(135deg, #6c757d, #5a6268);
          color: #fff;
          border: none;
          padding: 14px 30px;
          border-radius: 12px;
          cursor: pointer;
          font-size: 16px;
          font-weight: 600;
          box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
          width: 100%;
        }

        .cancel-btn:hover {
          transform: translateY(-2px);
          box-shadow: 0 10px 30px rgba(108, 117, 125, 0.4);
        }

        /* Message Modal */
        .message-modal {
          position: fixed;
          top: 0;
          left: 0;
          width: 100vw;
          height: 100vh;
          background: rgba(0,0,0,0.7);
          display: flex;
          align-items: center;
          justify-content: center;
          z-index: 1000;
          backdrop-filter: blur(5px);
        }

        .message-modal-content {
          background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
          padding: 40px;
          border-radius: 24px;
          box-shadow: 0 25px 80px rgba(0,0,0,0.3);
          text-align: center;
          max-width: 500px;
          width: 90%;
          animation: modalSlideIn 0.3s ease-out;
          border: 1px solid rgba(220, 53, 69, 0.1);
        }

        .message-modal-title {
          font-size: 24px;
          font-weight: 700;
          color: #1a1a1a;
          margin-bottom: 15px;
        }

        .message-modal-text {
          color: #666;
          margin-bottom: 30px;
          line-height: 1.6;
          font-size: 16px;
        }

        .message-modal-buttons {
          display: flex;
          gap: 15px;
          justify-content: center;
          flex-wrap: wrap;
        }

        .message-modal-btn {
          padding: 12px 30px;
          border: none;
          border-radius: 12px;
          font-size: 15px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.3s ease;
          min-width: 140px;
        }

        .message-modal-btn.primary {
          background: linear-gradient(135deg, #dc3545, #b02a37);
          color: white;
        }

        .message-modal-btn.primary:hover {
          transform: translateY(-2px);
          box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
        }

        .message-modal-btn.secondary {
          background: #f8f9fa;
          color: #666;
          border: 2px solid #dee2e6;
        }

        .message-modal-btn.secondary:hover {
          background: #e9ecef;
        }
      `}</style>

      {/* PROFILE MODAL */}
      {showProfileModal && (
        <div className="profile-modal" onClick={handleCancelProfile}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            <button className="close-modal" onClick={handleCancelProfile}>×</button>
            <div className="modal-image-upload" onClick={openFileExplorer}>
              {previewImage ? (
                <img src={previewImage} alt="Preview" style={{
                  width: "100%", height: "100%", borderRadius: "50%", objectFit: "cover"
                }} />
              ) : getDisplayAvatar() ? (
                <img src={getDisplayAvatar()} alt="Profile" style={{
                  width: "100%", height: "100%", borderRadius: "50%", objectFit: "cover"
                }} />
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

            <button className="get-image-btn" onClick={handleCancelProfile}>💾 Save Changes</button>
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
            {getDisplayAvatar() ? (
              <img 
                src={getDisplayAvatar()} 
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
          <p className="profile-name">{buyerProfile.name.split(' ')[0]}</p>
        </div>
        
        <ul>
          <li><a className="active" href="#">📊 Dashboard</a></li>
          <li><a href="#">📦 Orders</a></li>
          <li><a href="#">🛒 Cart</a></li>
          <li><a href="#" onClick={() => setShowMessageModal(true)}>💬 Messages</a></li>
          <li><a href="#">⚙️ Settings</a></li>
          <br /><br /><br />
          <li><a href="#" onClick={handleLogout}>🚪 Logout</a></li>
        </ul>

        {/* ✅ CLICKABLE LOGO - NAVIGATES TO BUYER HOME */}
        <div className="sidebar-logo">
          <Link to="/buyer_home">
            <img src={logo} alt="Hoopers Fits Logo" />
          </Link>
        </div>
      </div>

      <div className="main">
        <div className="top-bar">
          <h1>Dashboard Overview</h1>
        </div>

        <div className="dashboard">
          <div className="left-stats">
            <div className="stat-card">
              <h3>{buyerData.recentOrders.length}</h3>
              <p>Total Orders</p>
            </div>

            <div className="stat-card">
              <h3>₱{buyerData.totalSpending.toLocaleString('en-PH', { minimumFractionDigits: 2 })}</h3>
              <p>Total Spending</p>
            </div>

            <div className="stat-card">
              <h3>4.8</h3>
              <p>Avg Rating</p>
            </div>

            <div className="stat-card">
              <p>🔥 Recent Purchases</p>
              <ol>
                <li>Chrome Heart Net Cap</li>
                <li>Stussy</li>
                <li>BLKZN Cap</li>
              </ol>
            </div>
          </div>

          <div className="right-content">
            <div className="small-cards">
              <div className="small-card" onClick={() => setShowMessageModal(true)}>
                <h3>💬</h3>
                <p>Need Help? Message Us</p>
              </div>

              <div className="small-card">
                <h3>⭐</h3>
                <p>Review Orders</p>
              </div>
            </div>

            <div className="activity">
              <h4>📈 Spending Trend</h4>
              <div className="chart-placeholder">Spending Chart Coming Soon</div>
            </div>

            <div className="orders">
              <h4>📦 Recent Orders</h4>
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
                  {buyerData.recentOrders.map((order) => (
                    <tr key={order.id}>
                      <td>{order.name}</td>
                      <td>{order.date}</td>
                      <td>₱{order.price.toLocaleString('en-PH')}</td>
                      <td>{order.payment}</td>
                      <td className={`status ${order.status}`}>
                        {order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      {showMessageModal && (
        <div className="message-modal" onClick={() => setShowMessageModal(false)}>
          <div className="message-modal-content" onClick={(e) => e.stopPropagation()}>
            <h2 className="message-modal-title">📱 Need Help?</h2>
            <p className="message-modal-text">
              Our support team is ready to assist you! You can also reach us via:
            </p>
            <div className="message-modal-buttons">
              <button 
                className="message-modal-btn primary"
                onClick={() => window.open('mailto:support@hoopersfits.ph')}
              >
                📧 Email Support
              </button>
              <button 
                className="message-modal-btn secondary"
                onClick={() => setShowMessageModal(false)}
              >
                Close
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default BuyerDashboard;