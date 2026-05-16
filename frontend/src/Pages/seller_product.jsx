import React, { useState, useEffect } from 'react';
import { useAuth } from '../AuthContext';
import "../components/seller_product.css";
import { syncProfile, getDisplayAvatar } from '../utils/profileSync';

const SellerProduct = () => {
  const { user } = useAuth(); // ✅ NOW HAS AUTH CONTEXT
  const [currentPage, setCurrentPage] = useState(1);
  const [showProfileModal, setShowProfileModal] = useState(false);
  const [showAddProductModal, setShowAddProductModal] = useState(false);
  const [showEditProductModal, setShowEditProductModal] = useState(false);
  const [selectedFile, setSelectedFile] = useState(null);
  const [previewImage, setPreviewImage] = useState(null);
  const [editedName, setEditedName] = useState("");
  const [newProductPreview, setNewProductPreview] = useState(null);
  const [editProductPreview, setEditProductPreview] = useState(null);
  const [newProductHasImage, setNewProductHasImage] = useState(false);
  const [editProductHasImage, setEditProductHasImage] = useState(false);
  const [showDeleteModal, setShowDeleteModal] = useState(false);
  const [productToDelete, setProductToDelete] = useState(null);
  
  const [adminProfile, setAdminProfile] = useState({
    name: "",
    avatar: null
  });

  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true); // ✅ Start with loading
  const [sellerId, setSellerId] = useState(null); // ✅ Now properly null
  
  const [showSuccessModal, setShowSuccessModal] = useState(false);
  const [showErrorModal, setShowErrorModal] = useState(false);
  const [notificationMessage, setNotificationMessage] = useState('');

  const [newProductPrice, setNewProductPrice] = useState('0.00');
  const [newProductPriceDisplay, setNewProductPriceDisplay] = useState('0.00');
  const [editProductPrice, setEditProductPrice] = useState('0.00');
  const [editProductPriceDisplay, setEditProductPriceDisplay] = useState('0.00');

  const [newProduct, setNewProduct] = useState({
    product_name: '',
    description: '',
    price: '',
    stock: ''
  });

  const [editProduct, setEditProduct] = useState({
    id: '',
    product_name: '',
    description: '',
    price: '',
    stock: '',
    image: ''
  });

  // ✅ SAME PRICE HANDLER AS BEFORE
  const handlePriceInput = (inputValue, setPriceState, setDisplayState) => {
    const input = inputValue.replace(/[^0-9]/g, '');
    if (input === '') {
      setPriceState('0.00');
      setDisplayState('0.00');
      return;
    }

    let newPrice;
    if (input.length === 1) {
      newPrice = `0.0${input}`;
    } else if (input.length === 2) {
      newPrice = `0.${input}`;
    } else {
      const dollars = input.slice(0, -2);
      const cents = input.slice(-2);
      newPrice = dollars ? `${dollars}.${cents}` : `0.${cents}`;
    }

    const formattedPrice = parseFloat(newPrice).toFixed(2);
    setPriceState(formattedPrice);
    setDisplayState(formattedPrice);
  };

  const handleNumberChange = (value, min = 1) => {
    const numValue = parseFloat(value) || 0;
    return Math.max(min, numValue).toString();
  };

  const validateForm = (formData, priceState, isEdit = false) => {
    const errors = [];

    if (!formData.product_name?.trim()) {
      errors.push('Product name is required');
    }

    if (!priceState || parseFloat(priceState) <= 0) {
      errors.push('Price must be greater than 0');
    }

    const stockValue = parseInt(formData.stock) || 0;
    if (!formData.stock || stockValue <= 0) {
      errors.push('Stock must be greater than 0');
    }

    if (!isEdit && !newProductHasImage) {
      errors.push('Product image is required');
    }

    return errors;
  };

  const showSuccessModalFunc = (message) => {
    setNotificationMessage(message);
    setShowSuccessModal(true);
    setTimeout(() => setShowSuccessModal(false), 2500);
  };

  const showErrorModalFunc = (message) => {
    setNotificationMessage(message);
    setShowErrorModal(true);
    setTimeout(() => setShowErrorModal(false), 3500);
  };

  // ✅ PROFILE FUNCTIONS (UNCHANGED)
  const handleFileSelect = (e) => {
    const file = e.target.files[0];
    if (file) {
      setSelectedFile(file);
      setPreviewImage(URL.createObjectURL(file));
    }
  };

  const openFileExplorer = () => {
    const fileInput = document.querySelector(".profile-file-input");
    if (fileInput) fileInput.click();
  };

  const uploadImage = async () => {
    if (!selectedFile) return true;
    const userId = user?.user_id || user?.id || 1;

    const formData = new FormData();
    formData.append("profile_image", selectedFile);
    formData.append("user_id", userId);

    try {
      const response = await fetch("http://localhost/hooper_fits_api/update_profile.php", {
        method: "POST",
        body: formData
      });
      const result = await response.json();

      if (result.success && result.image) {
        const avatarFilename = result.image.split('/').pop();
        setAdminProfile(prev => ({
          ...prev,
          avatar: avatarFilename
        }));
        setSelectedFile(null);
        setPreviewImage(null);
        await syncProfile(setAdminProfile, setEditedName);
        return true;
      } else {
        showErrorModalFunc(`❌ Image upload failed: ${result.error}`);
        return false;
      }
    } catch (error) {
      showErrorModalFunc('❌ Image upload error');
      return false;
    }
  };

  const updateProfileName = async () => {
    const userId = user?.user_id || user?.id || 1;

    try {
      const response = await fetch("http://localhost/hooper_fits_api/update_profile_name.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          user_id: userId,
          name: editedName
        })
      });
      const result = await response.json();

      if (result.success) {
        setAdminProfile(prev => ({ ...prev, name: editedName }));
        await syncProfile(setAdminProfile, setEditedName);
        return true;
      } else {
        showErrorModalFunc(`❌ Name update failed: ${result.error}`);
        return false;
      }
    } catch (error) {
      showErrorModalFunc('❌ Name update error');
      return false;
    }
  };

  const handleSaveProfile = async () => {
    const nameChanged = editedName !== adminProfile.name.trim();
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
      showSuccessModalFunc("✅ Profile updated successfully!");
    }
  };

  const handleCancelProfile = () => {
    setShowProfileModal(false);
    setSelectedFile(null);
    setPreviewImage(null);
    setEditedName(adminProfile.name);
  };

  // ✅ PRODUCT FUNCTIONS
  const handleProductFileSelect = (e) => {
    const file = e.target.files[0];
    if (file) {
      setNewProductPreview(URL.createObjectURL(file));
      setNewProductHasImage(true);
    }
  };

  const handleEditProductFileSelect = (e) => {
    const file = e.target.files[0];
    if (file) {
      setEditProductPreview(URL.createObjectURL(file));
      setEditProductHasImage(true);
    }
  };

  // ✅ FIXED: Use user from useAuth context
  useEffect(() => {
    if (user?.user_id || user?.id) {
      setSellerId(user.user_id || user.id);
    }
  }, [user]); // ✅ Depend on user

  useEffect(() => {
    syncProfile(setAdminProfile, setEditedName);
  }, []);

  useEffect(() => {
    setEditedName(adminProfile.name);
  }, [adminProfile.name]);

  // ✅ FIXED: Only fetch when sellerId exists
  const fetchProducts = async () => {
    if (!sellerId) {
      setLoading(false);
      return;
    }

    setLoading(true);
    try {
      console.log(`📡 Fetching products for seller ID: ${sellerId}`);
      const response = await fetch(`http://localhost/hooper_fits_api/get_seller_products.php?seller_id=${sellerId}`);
      const result = await response.json();
      
      console.log("✅ Products response:", result);
      
      if (result.success) {
        setProducts(result.products || []);
      } else {
        console.error("❌ Products error:", result.error);
        showErrorModalFunc(`❌ ${result.error}`);
        setProducts([]);
      }
    } catch (error) {
      console.error("❌ Fetch error:", error);
      showErrorModalFunc('❌ Network error - please refresh');
      setProducts([]);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    if (sellerId) {
      fetchProducts();
    }
  }, [sellerId]);

  const handleAddProduct = async () => {
    const errors = validateForm(newProduct, newProductPrice, false);
    
    if (errors.length > 0) {
      showErrorModalFunc(`❌ ${errors[0]}`);
      return;
    }

    const formData = new FormData();
    formData.append('seller_id', sellerId);
    formData.append('product_name', newProduct.product_name);
    formData.append('description', newProduct.description);
    formData.append('price', newProductPrice);
    formData.append('stock', newProduct.stock);
    
    const fileInput = document.getElementById('product-image');
    if (fileInput?.files[0]) {
      formData.append('image', fileInput.files[0]);
    }

    try {
      const response = await fetch('http://localhost/hooper_fits_api/add_product.php', {
        method: 'POST',
        body: formData
      });
      const result = await response.json();
      
      if (result.success) {
        closeAddProductModal();
        fetchProducts();
        showSuccessModalFunc('✅ Product added successfully!');
      } else {
        showErrorModalFunc(`❌ ${result.error}`);
      }
    } catch (error) {
      showErrorModalFunc('❌ Network error adding product');
    }
  };

  const handleEditClick = (product) => {
    setEditProduct({
      id: product.id || product.product_id,
      product_name: product.product_name || product.name || '',
      description: product.description || '',
      price: product.price || '',
      stock: product.stock || '',
      image: product.image || ''
    });
    
    const priceStr = (product.price || '0').toString();
    setEditProductPrice(priceStr);
    setEditProductPriceDisplay(priceStr);
    
    let imageUrl = null;
    if (product.image) {
      imageUrl = `http://localhost/hooper_fits_api/uploads/products/${product.image}`;
    }
    setEditProductPreview(imageUrl);
    setEditProductHasImage(!!imageUrl);
    
    setShowEditProductModal(true);
  };

  const handleEditProduct = async () => {
    const errors = validateForm(editProduct, editProductPrice, true);
    
    if (errors.length > 0) {
      showErrorModalFunc(`❌ ${errors[0]}`);
      return;
    }

    const formData = new FormData();
    formData.append('product_id', editProduct.id);
    formData.append('seller_id', sellerId);
    formData.append('product_name', editProduct.product_name);
    formData.append('description', editProduct.description);
    formData.append('price', editProductPrice);
    formData.append('stock', editProduct.stock);
    
    const fileInput = document.getElementById('edit-product-image');
    if (fileInput?.files[0]) {
      formData.append('image', fileInput.files[0]);
    }

    try {
      const response = await fetch('http://localhost/hooper_fits_api/edit_product.php', {
        method: 'POST',
        body: formData
      });
      const result = await response.json();
      
      if (result.success) {
        closeEditProductModal();
        fetchProducts();
        showSuccessModalFunc('✅ Product updated successfully!');
      } else {
        showErrorModalFunc(`❌ ${result.error}`);
      }
    } catch (error) {
      showErrorModalFunc('❌ Network error updating product');
    }
  };

  const closeAddProductModal = () => {
    setShowAddProductModal(false);
    setNewProduct({ product_name: '', description: '', price: '', stock: '' });
    setNewProductPrice('0.00');
    setNewProductPriceDisplay('0.00');
    setNewProductPreview(null);
    setNewProductHasImage(false);
  };

  const closeEditProductModal = () => {
    setShowEditProductModal(false);
    setEditProduct({ id: '', product_name: '', description: '', price: '', stock: '', image: '' });
    setEditProductPrice('0.00');
    setEditProductPriceDisplay('0.00');
    setEditProductPreview(null);
    setEditProductHasImage(false);
  };

  const handleDeleteClick = (product) => {
    setProductToDelete(product);
    setShowDeleteModal(true);
  };

  const confirmDelete = async () => {
    if (!productToDelete || !sellerId) return;
    
    try {
      const response = await fetch('http://localhost/hooper_fits_api/delete_product.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          product_id: productToDelete.id || productToDelete.product_id,
          seller_id: sellerId
        })
      });
      
      const result = await response.json();
      
      if (result.success) {
        setProducts(prevProducts => 
          prevProducts.filter(p => p.id !== productToDelete.id)
        );
        setShowDeleteModal(false);
        setProductToDelete(null);
        showSuccessModalFunc('✅ Product deleted successfully!');
      } else {
        showErrorModalFunc(`❌ ${result.error || 'Delete failed'}`);
      }
    } catch (error) {
      showErrorModalFunc('❌ Network error - please try again');
    }
  };

  const getStatusBadge = (stock) => {
    if (!stock) stock = 0;
    if (stock === 0) {
      return { class: 'out-of-stock', text: 'Out of Stock', color: '#f44336' };
    } else if (stock <= 5) {
      return { class: 'low-stock', text: 'Low Stock', color: '#ff9800' };
    }
    return { class: 'active', text: 'Active', color: '#4caf50' };
  };

  const openAddProductModal = () => {
    setShowAddProductModal(true);
    setNewProductPrice('0.00');
    setNewProductPriceDisplay('0.00');
  };

  const itemsPerPage = 10;
  const totalPages = Math.ceil(products.length / itemsPerPage);
  const startIndex = (currentPage - 1) * itemsPerPage;
  const currentProducts = products.slice(startIndex, startIndex + itemsPerPage);

  const displayAvatar = previewImage || 
    (adminProfile.avatar ? getDisplayAvatar(adminProfile.avatar) : null);

  // ✅ LOADING SCREEN (like dashboard)
  if (loading || !sellerId) {
    return (
      <div className="seller-dashboard-app" style={{display: 'flex', justifyContent: 'center', alignItems: 'center', minHeight: '100vh', background: '#000', color: '#fff'}}>
        <div>⏳ Loading your products...</div>
      </div>
    );
  }

  return (
    <div className="seller-product-app">
      {/* ALL MODALS - UNCHANGED */}
      {showEditProductModal && (
        <div className="add-product-modal" onClick={closeEditProductModal}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            <button className="close-modal" onClick={closeEditProductModal}>×</button>
            
            <div className="modal-image-upload" onClick={() => document.getElementById('edit-product-image').click()}>
              {editProductPreview ? (
                <img 
                  src={editProductPreview} 
                  alt="Product Preview"
                  onError={(e) => {
                    console.error('❌ Image failed to load:', editProductPreview);
                    e.target.style.display = 'none';
                    e.target.nextSibling.style.display = 'flex';
                  }}
                />
              ) : (
                <div className="no-image-placeholder">
                  <span>📸</span>
                  <p>Click to add image</p>
                </div>
              )}
              <input 
                id="edit-product-image" 
                type="file" 
                accept="image/*" 
                onChange={handleEditProductFileSelect}
                style={{ display: 'none' }}
              />
              {!editProductPreview && <div className="image-overlay">Click to upload</div>}
            </div>

            <h2 className="modal-title">Edit Product</h2>
            <p className="modal-subtitle">Update product details</p>

            <div className="product-form-group">
              <label>Product Name *</label>
              <input 
                type="text" 
                value={editProduct.product_name}
                onChange={(e) => setEditProduct({...editProduct, product_name: e.target.value})}
                placeholder="Enter product name"
                className={`name-input ${!editProduct.product_name.trim() ? 'invalid-name' : ''}`}
              />
            </div>

                        <div className="product-form-group">
              <label>Description</label>
              <textarea 
                value={editProduct.description}
                onChange={(e) => setEditProduct({...editProduct, description: e.target.value})}
                placeholder="Enter description (optional)"
                rows="3"
              />
            </div>

            <div className="product-form-row">
              <div className="product-form-group">
                <label>Price (₱) *</label>
                <input 
                  type="text"
                  value={editProductPriceDisplay}
                  onChange={(e) => handlePriceInput(e.target.value, setEditProductPrice, setEditProductPriceDisplay)}
                  placeholder="0.00"
                  className={`price-input ${(!editProductPrice || parseFloat(editProductPrice) <= 0) ? 'invalid-price' : ''}`}
                />
              </div>
              <div className="product-form-group">
                <label>Stock *</label>
                <input 
                  type="number"
                  min="1"
                  value={editProduct.stock}
                  onChange={(e) => {
                    const value = handleNumberChange(e.target.value, 1);
                    setEditProduct({...editProduct, stock: value});
                  }}
                  placeholder="Enter stock (minimum 1)"
                  className={`stock-input ${(!editProduct.stock || parseInt(editProduct.stock) <= 0) ? 'invalid-stock' : ''}`}
                />
              </div>
            </div>

            <button className="get-image-btn" onClick={handleEditProduct}>Update Product</button>
            <button className="cancel-btn" onClick={closeEditProductModal}>Cancel</button>
          </div>
        </div>
      )}

      {showAddProductModal && (
        <div className="add-product-modal" onClick={closeAddProductModal}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            <button className="close-modal" onClick={closeAddProductModal}>×</button>
            
            <div className="modal-image-upload" onClick={() => document.getElementById('product-image').click()}>
              {newProductPreview ? (
                <img src={newProductPreview} alt="Product Preview" />
              ) : (
                <div className="no-image-placeholder">
                  <span>📸</span>
                  <p>Click to upload image</p>
                </div>
              )}
              <input 
                id="product-image" 
                type="file" 
                accept="image/*" 
                onChange={handleProductFileSelect}
                style={{ display: 'none' }}
              />
            </div>

            <h2 className="modal-title">Add New Product</h2>
            <p className="modal-subtitle">
              Fill in product details <span className="required-note">* All fields required including image</span>
            </p>

            <div className="product-form-group">
              <label>Product Name <span className="required">*</span></label>
              <input 
                type="text" 
                value={newProduct.product_name}
                onChange={(e) => setNewProduct({...newProduct, product_name: e.target.value})}
                placeholder="Enter product name"
                className={`name-input ${!newProduct.product_name.trim() ? 'invalid-name' : ''}`}
              />
            </div>

                        <div className="product-form-group">
              <label>Description</label>
              <textarea 
                value={newProduct.description}
                onChange={(e) => setNewProduct({...newProduct, description: e.target.value})}
                placeholder="Enter description"
                rows="3"
              />
            </div>

            <div className="product-form-row">
              <div className="product-form-group">
                <label>Price (₱) <span className="required">*</span></label>
                <input 
                  type="text"
                  value={newProductPriceDisplay}
                  onChange={(e) => handlePriceInput(e.target.value, setNewProductPrice, setNewProductPriceDisplay)}
                  placeholder="0.00"
                  className={`price-input ${(!newProductPrice || parseFloat(newProductPrice) <= 0) ? 'invalid-price' : ''}`}
                />
              </div>
              <div className="product-form-group">
                <label>Stock <span className="required">*</span></label>
                <input 
                  type="number"
                  min="1"
                  value={newProduct.stock}
                  onChange={(e) => {
                    const value = handleNumberChange(e.target.value, 1);
                    setNewProduct({...newProduct, stock: value});
                  }}
                  placeholder="Enter stock"
                  className={`stock-input ${(!newProduct.stock || parseInt(newProduct.stock) <= 0) ? 'invalid-stock' : ''}`}
                />
              </div>
            </div>

            <button className="get-image-btn" onClick={handleAddProduct}>Add Product</button>
            <button className="cancel-btn" onClick={closeAddProductModal}>Cancel</button>
          </div>
        </div>
      )}

      {showProfileModal && (
        <div className="profile-modal" onClick={handleCancelProfile}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            <button className="close-modal" onClick={handleCancelProfile}>×</button>
            
            <div className="modal-image-upload" onClick={openFileExplorer}>
              {previewImage ? (
                <img 
                  src={previewImage} 
                  alt="Profile Preview"
                  onError={(e) => {
                    console.error('❌ Image failed to load:', previewImage);
                    e.target.style.display = 'none';
                  }}
                />
              ) : displayAvatar ? (
                <img 
                  src={displayAvatar} 
                  alt="Current Profile"
                  onError={(e) => {
                    console.error('❌ Image failed to load:', displayAvatar);
                    e.target.style.display = 'none';
                  }}
                />
              ) : (
                <div className="no-image-placeholder">
                  <span>👤</span>
                  <p>Click to add profile image</p>
                </div>
              )}
              <input 
                className="profile-file-input"
                type="file" 
                accept="image/*" 
                onChange={handleFileSelect}
                style={{ display: 'none' }}
              />
            </div>

            <h2 className="modal-title">Update Profile</h2>
            <p className="modal-subtitle">Click avatar to change profile image</p>

            <div className="profile-name-input-container">
              <label className="profile-label">Profile Name</label>
              <input 
                className="profile-name-input"
                type="text" 
                value={editedName} 
                onChange={(e)=>setEditedName(e.target.value)} 
                placeholder="Enter your name"
              />
            </div>

            <button className="get-image-btn" onClick={handleSaveProfile}>Save Changes</button>
            <button className="cancel-btn" onClick={handleCancelProfile}>Cancel</button>
          </div>
        </div>
      )}

      {/* SIDEBAR */}
      <div className="sidebar">
        <div className="admin-profile">
          <div className="profile-avatar" onClick={() => setShowProfileModal(true)}>
            {displayAvatar ? (
              <img 
                src={displayAvatar} 
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
          <li><a href="/seller_dashboard">📊 Dashboard</a></li>
          <li><a href="/seller_product" className="active">📦 Products</a></li>
          <li><a href="/seller_settings">⚙️ Settings</a></li>
          <li><a href="/seller_orders">📋 Orders</a></li>
          <li><a href="/seller_messages">💬 Messages</a></li>
          <br /><br /><br />
          <li><a href="/login">🚪 Logout</a></li>
        </ul>
      </div>

      {/* MAIN CONTENT */}
      <div className="main">
        <div className="top-bar">
          <h1>Product Management</h1>
          <button className="add-product" onClick={openAddProductModal}>
            ➕ Add New Product
          </button>
        </div>

        <div className="top-stats">
          <div className="stat-card">
            <h3>{products.filter(p => (p.stock || 0) > 5).length}</h3>
            <p>Active Items</p>
          </div>
          <div className="stat-card">
            <h3>{products.filter(p => (p.stock || 0) === 0).length}</h3>
            <p>Out of Stock</p>
          </div>
          <div className="stat-card">
            <h3>{products.filter(p => (p.stock || 0) > 0 && (p.stock || 0) <= 5).length}</h3>
            <p>Low Stock</p>
          </div>
        </div>

        <div className="inventory-table">
          <h4>📋 Inventory Management</h4>
          {products.length === 0 ? (
            <div className="empty-state">
              <div>📦</div>
              <h3>No products yet</h3>
              <p>Add your first product using the button above!</p>
            </div>
          ) : (
            <>
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
                  {currentProducts.map((product, index) => {
                    const badge = getStatusBadge(product.stock);
                    return (
                      <tr key={product.id || index}>
                        <td className="product-name-cell">
                          {product.product_name || product.name}
                        </td>
                        <td className="stock-cell">
                          {product.stock || 0}
                        </td>
                        <td className="price-cell">₱{(parseFloat(product.price || 0)).toLocaleString()}</td>
                        <td>
                          <span className={`status-badge ${badge.class}`}>
                            {badge.text}
                          </span>
                        </td>
                        <td className="actions">
                          <button onClick={() => handleEditClick(product)}>
                            ✏️ Edit
                          </button>
                          <button className="delete" onClick={() => handleDeleteClick(product)}>
                            🗑️ Delete
                          </button>
                        </td>
                      </tr>
                    );
                  })}
                </tbody>
              </table>

              {totalPages > 1 && (
                <div className="pagination">
                  <button 
                    onClick={() => setCurrentPage(prev => Math.max(prev - 1, 1))}
                    disabled={currentPage === 1}
                  >
                    ← Previous
                  </button>
                  <span className="page-info">
                    Page {currentPage} of {totalPages} ({products.length} total)
                  </span>
                  <button 
                    onClick={() => setCurrentPage(prev => Math.min(prev + 1, totalPages))}
                    disabled={currentPage === totalPages}
                  >
                    Next →
                  </button>
                </div>
              )}
            </>
          )}
        </div>
      </div>

      {/* DELETE MODAL */}
      {showDeleteModal && productToDelete && (
        <div className="delete-modal" onClick={() => setShowDeleteModal(false)}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            <button className="close-modal" onClick={() => setShowDeleteModal(false)}>×</button>
            <div className="delete-icon">🗑️</div>
            <h2 className="delete-title">Delete Product?</h2>
            <p className="delete-subtitle">
              Are you sure you want to delete this product? 
              <br />
              <strong className="product-name">
                "{productToDelete.product_name || productToDelete.name}"
              </strong>
            </p>
            <div className="delete-button-group">
              <button className="delete-confirm-btn" onClick={confirmDelete}>
                Yes, Delete It
              </button>
              <button className="delete-cancel-btn" onClick={() => setShowDeleteModal(false)}>
                Cancel
              </button>
            </div>
          </div>
        </div>
      )}

      {/* NOTIFICATION MODALS */}
      {showSuccessModal && (
        <div className="notification-modal success">
          <div className="notification-title">Success!</div>
          <div className="notification-message">{notificationMessage}</div>
        </div>
      )}

      {showErrorModal && (
        <div className="notification-modal error">
          <div className="notification-title">Error!</div>
          <div className="notification-message">{notificationMessage}</div>
        </div>
      )}
    </div>
  );
};

export default SellerProduct;