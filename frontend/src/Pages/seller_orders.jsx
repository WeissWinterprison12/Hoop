import React, { useEffect, useState, useCallback, useRef } from 'react';
import '../components/seller_orders.css';

const SellerOrders = () => {
  const [showProfileModal, setShowProfileModal] = useState(false);
  const [selectedFile, setSelectedFile] = useState(null);
  const [previewImage, setPreviewImage] = useState(null);
  const [editedName, setEditedName] = useState("");
  const [currentUser, setCurrentUser] = useState(null);
  const [adminProfile, setAdminProfile] = useState({
    name: "",
    avatar: null
  });

  // ✅ IMPROVED: Use useRef to prevent multiple clicks
  const fileInputRef = useRef(null);

  const [orders, setOrders] = useState([
    {
      id: "1853",
      date: "2026-01-09",
      customer: "Kyle Lowry",
      products: "BLKSZN Cap",
      total: 299.50,
      status: "Shipped"
    },
    {
      id: "1964",
      date: "2026-01-08",
      customer: "Arisu Letusawa",
      products: "Stussy",
      total: 699.99,
      status: "Completed"
    },
    {
      id: "1244",
      date: "2026-01-07",
      customer: "Andrei Lapuz Narito",
      products: "Chrome Heart Net Cap",
      total: 549.25,
      status: "Returned"
    },
    {
      id: "1175",
      date: "2026-01-07",
      customer: "Ramon Lorenzo Neri",
      products: "Bas Bro Shop Cap",
      total: 1999.99,
      status: "Refunded"
    }
  ]);

  // Sorting state
  const [sortConfig, setSortConfig] = useState({
    key: null,
    direction: null
  });

  // ✅ IMPROVED: Combined profile loading with currentUser state
  useEffect(() => {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    console.log('🔍 LocalStorage user:', user);
    
    if (user && (user.user_id || user.id)) {
      const userId = user.user_id || user.id;
      setCurrentUser(user);
      fetchProfile(userId);
    }
  }, []);

  // ✅ IMPROVED: Stable getDisplayAvatar with useCallback
  const getDisplayAvatar = useCallback(() => {
    if (previewImage) return previewImage;
    if (!adminProfile.avatar) return null;
    
    if (adminProfile.avatar.startsWith('http')) {
      return adminProfile.avatar;
    }
    
    const fullUrl = `http://localhost/hooper_fits_api/uploads/profiles/${adminProfile.avatar}`;
    console.log('🖼️ Avatar URL:', fullUrl);
    return fullUrl;
  }, [previewImage, adminProfile.avatar]);

  const fetchProfile = async (userId) => {
    try {
      const response = await fetch(`http://localhost/hooper_fits_api/get_profile.php?user_id=${userId}`);
      
      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }
      
      const text = await response.text();
      console.log('Raw profile response:', text);
      
      const data = JSON.parse(text);
      
      if (data.success) {
        const avatarFilename = data.profile_image ? data.profile_image.split('/').pop() : null;
        
        const profileData = {
          name: data.name || "",
          avatar: avatarFilename
        };
        
        setAdminProfile(profileData);
        setEditedName(data.name || "");
        
        const updatedUser = {
          ...currentUser,
          name: profileData.name,
          profile_image: profileData.avatar
        };
        localStorage.setItem('user', JSON.stringify(updatedUser));
      }
    } catch (err) {
      console.error("Profile error:", err);
    }
  };

  // ✅ IMPROVED: Stable callback with useCallback
  const handleFileSelect = useCallback((e) => {
    const file = e.target.files[0];
    if (file) {
      console.log('✅ File selected:', file.name);
      setSelectedFile(file);
      setPreviewImage(URL.createObjectURL(file));
    }
  }, []);

  // ✅ IMPROVED: Single click handler with useRef
  const openFileExplorer = useCallback(() => {
    if (fileInputRef.current) {
      fileInputRef.current.value = '';
      fileInputRef.current.click();
    }
  }, []);

  const uploadImage = async () => {
    if (!selectedFile || !currentUser) return false;

    const userId = currentUser.user_id || currentUser.id;
    const formData = new FormData();
    formData.append("profile_image", selectedFile);
    formData.append("user_id", userId);

    try {
      const response = await fetch("http://localhost/hooper_fits_api/update_profile.php", {
        method: "POST",
        body: formData
      });
      
      const text = await response.text();
      console.log('Raw upload response:', text);
      
      const result = JSON.parse(text);

      if (result.success && result.image) {
        const filename = result.image.split('/').pop();
        console.log('✅ NEW AVATAR FILENAME:', filename);
        
        setAdminProfile(prev => ({
          ...prev,
          avatar: filename
        }));

        const updatedUser = {
          ...currentUser,
          profile_image: filename
        };
        localStorage.setItem('user', JSON.stringify(updatedUser));

        setSelectedFile(null);
        setPreviewImage(null);
        return true;
      } else {
        alert(`Upload failed: ${result.error || 'Unknown error'}`);
        return false;
      }
    } catch (error) {
      console.error('💥 Upload error:', error);
      alert("Upload error");
      return false;
    }
  };

  const updateProfileName = async () => {
    if (!currentUser) return false;

    const userId = currentUser.user_id || currentUser.id;

    try {
      const response = await fetch("http://localhost/hooper_fits_api/update_profile_name.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          user_id: userId,
          name: editedName.trim()
        })
      });
      
      const result = await response.json();

      if (result.success) {
        setAdminProfile(prev => ({ 
          ...prev, 
          name: editedName.trim() 
        }));

        const updatedUser = {
          ...currentUser,
          name: editedName.trim()
        };
        localStorage.setItem('user', JSON.stringify(updatedUser));

        return true;
      } else {
        alert(`Name update failed: ${result.error}`);
        return false;
      }
    } catch (error) {
      console.error('Name update error:', error);
      alert("Name update error");
      return false;
    }
  };

  // ✅ IMPROVED: Stable handleSaveProfile with useCallback
  const handleSaveProfile = useCallback(async () => {
    const nameChanged = editedName.trim() !== adminProfile.name.trim();
    const imageChanged = !!selectedFile;

    if (!nameChanged && !imageChanged) {
      setShowProfileModal(false);
      return;
    }

    let success = true;

    if (nameChanged) {
      success = await updateProfileName();
    }

    if (imageChanged && success) {
      success = await uploadImage();
    }

    if (success) {
      setShowProfileModal(false);
      alert("✅ Profile updated successfully!");
      
      if (currentUser) {
        const userId = currentUser.user_id || currentUser.id;
        fetchProfile(userId);
      }
    }
  }, [editedName, adminProfile.name, selectedFile, currentUser]);

  // ✅ IMPROVED: Stable handleCancelProfile with useCallback
  const handleCancelProfile = useCallback(() => {
    setShowProfileModal(false);
    setSelectedFile(null);
    setPreviewImage(null);
    setEditedName(adminProfile.name);
  }, [adminProfile.name]);

  // ✅ IMPROVED: Stable input handler
  const handleNameChange = useCallback((e) => {
    setEditedName(e.target.value);
  }, []);

  useEffect(() => {
    setEditedName(adminProfile.name);
  }, [adminProfile.name]);

  // Orders sorting functions (unchanged)
  const handleSort = (key) => {
    let sortedOrders = [...orders];
    
    if (sortConfig.key === key && sortConfig.direction === 'asc') {
      setSortConfig({ key: null, direction: null });
      return;
    } else if (sortConfig.key === key && sortConfig.direction === 'desc') {
      sortedOrders.sort((a, b) => {
        if (key === 'id') return parseInt(a.id) - parseInt(b.id);
        if (key === 'date') return new Date(a.date) - new Date(b.date);
        if (key === 'customer') return a.customer.localeCompare(b.customer);
        if (key === 'products') return a.products.localeCompare(b.products);
        if (key === 'total') return a.total - b.total;
        return 0;
      });
      setSortConfig({ key, direction: 'asc' });
    } else {
      sortedOrders.sort((a, b) => {
        if (key === 'id') return parseInt(b.id) - parseInt(a.id);
        if (key === 'date') return new Date(b.date) - new Date(a.date);
        if (key === 'customer') return b.customer.localeCompare(a.customer);
        if (key === 'products') return b.products.localeCompare(a.products);
        if (key === 'total') return b.total - a.total;
        return 0;
      });
      setSortConfig({ key, direction: 'desc' });
    }
    
    setOrders(sortedOrders);
  };

  const getSortIcon = (key) => {
    if (sortConfig.key !== key) return '↕️';
    if (sortConfig.direction === 'asc') return '↑';
    if (sortConfig.direction === 'desc') return '↓';
    return '↕️';
  };

  const getStatusClass = (status) => {
    switch(status.toLowerCase()) {
      case 'shipped': return 'status-shipped';
      case 'completed': return 'status-completed';
      case 'returned': return 'status-returned';
      case 'refunded': return 'status-refunded';
      default: return 'status-shipped';
    }
  };

  return (
    <div className="seller-orders-app">
      {/* ✅ IMPROVED: Profile Modal from seller_settings.jsx */}
      {showProfileModal && (
        <div className="profile-modal" onClick={handleCancelProfile}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            <button 
              className="close-modal" 
              onClick={handleCancelProfile}
              type="button"
            >
              ×
            </button>
            
            <div 
              className="modal-image-upload" 
              onClick={openFileExplorer}
              role="button"
              tabIndex={0}
              onKeyDown={(e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                  e.preventDefault();
                  openFileExplorer();
                }
              }}
            >
              {previewImage ? (
                <img 
                  src={previewImage} 
                  alt="Profile Preview"
                  style={{width: '100%', height: '100%', borderRadius: '16px', objectFit: 'cover'}}
                />
              ) : getDisplayAvatar() ? (
                <img 
                  src={getDisplayAvatar()} 
                  alt="Current Profile"
                  style={{width: '100%', height: '100%', borderRadius: '16px', objectFit: 'cover'}}
                />
              ) : (
                <div className="no-image-placeholder">
                  <span>👤</span>
                  <p>Click to add profile image</p>
                </div>
              )}
              <input 
                ref={fileInputRef}
                type="file" 
                accept="image/*" 
                onChange={handleFileSelect}
                style={{ display: 'none' }}
              />
              {!previewImage && !getDisplayAvatar() && (
                <div className="image-overlay">Click to upload</div>
              )}
            </div>

            <h2 className="modal-title">Update Profile</h2>
            <p className="modal-subtitle">Click avatar to change profile image</p>
            
            <div className="profile-name-input-container">
              <label className="profile-label">Profile Name</label>
              <input 
                type="text" 
                value={editedName} 
                onChange={handleNameChange}
                className="profile-name-input"
                placeholder="Enter your name"
                autoComplete="off"
              />
            </div>

            <button 
              className="get-image-btn" 
              onClick={handleSaveProfile}
              type="button"
            >
              💾 Save Changes
            </button>
            <button 
              className="cancel-btn" 
              onClick={handleCancelProfile}
              type="button"
            >
              ❌ Cancel
            </button>
          </div>
        </div>
      )}

      <div className="sidebar">
        <div className="admin-profile">
          <div className="profile-avatar" onClick={() => setShowProfileModal(true)}>
            {getDisplayAvatar() ? (
              <img 
                src={getDisplayAvatar()}
                alt="Profile"
                style={{width: '100%', height: '100%', borderRadius: '50%', objectFit: 'cover'}}
                onError={(e) => {
                  console.error('❌ Image failed:', getDisplayAvatar());
                  e.target.style.display = 'none';
                  e.target.nextSibling.style.display = 'flex';
                }}
              />
            ) : null}
            <div className="question-mark-avatar" style={{display: getDisplayAvatar() ? 'none' : 'flex'}}>
              ?
            </div>
          </div>
          <p className="profile-name">{adminProfile.name || currentUser?.name || "Loading..."}</p>
        </div>
        <ul>
          <li><a href="/seller_dashboard">📊 Dashboard</a></li>
          <li><a href="/seller_product">📦 Products</a></li>
          <li><a href="/seller_settings">⚙️ Settings</a></li>
          <li><a className="active" href="/seller_orders">📋 Orders</a></li>
          <li><a href="/seller_messages">💬 Messages</a></li>
          <br /><br /><br />
          <li><a href="/login">🚪 Logout</a></li>
        </ul>
      </div>

      <div className="main">
        <div className="top-bar">
          <h1>Orders</h1>
        </div>

        <div className="orders">
          <h2>📦 Orders</h2>

          <table>
            <thead>
              <tr>
                <th 
                  data-sort-icon={getSortIcon('id')}
                  className={sortConfig.key === 'id' ? 'sort-active' : ''}
                  onClick={() => handleSort('id')}
                >
                  Order ID {getSortIcon('id')}
                </th>
                <th 
                  data-sort-icon={getSortIcon('date')}
                  className={sortConfig.key === 'date' ? 'sort-active' : ''}
                  onClick={() => handleSort('date')}
                >
                  Date {getSortIcon('date')}
                </th>
                <th 
                  data-sort-icon={getSortIcon('customer')}
                  className={sortConfig.key === 'customer' ? 'sort-active' : ''}
                  onClick={() => handleSort('customer')}
                >
                  Customer Name {getSortIcon('customer')}
                </th>
                <th 
                  data-sort-icon={getSortIcon('products')}
                  className={sortConfig.key === 'products' ? 'sort-active' : ''}
                  onClick={() => handleSort('products')}
                >
                  Products {getSortIcon('products')}
                </th>
                <th 
                  data-sort-icon={getSortIcon('total')}
                  className={sortConfig.key === 'total' ? 'sort-active' : ''}
                  onClick={() => handleSort('total')}
                >
                  Total {getSortIcon('total')}
                </th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              {orders.map((order, index) => (
                <tr key={index}>
                  <td>#{order.id}</td>
                  <td>{order.date}</td>
                  <td>{order.customer}</td>
                  <td>{order.products}</td>
                  <td>₱{order.total.toLocaleString()}</td>
                  <td className={getStatusClass(order.status)}>{order.status}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};

export default SellerOrders;