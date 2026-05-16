import React, { useState, useEffect } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import '../components/Checkout.css';
import logo from "../Images/HoopersFits.png";
import profileIcon from "../Images/Profile.png";
import facebookIcon from "../Images/facebook.png";
import instagramIcon from "../Images/Instagram.png";

const Checkout = () => {
  const [cartItems, setCartItems] = useState([]);
  const [loading, setLoading] = useState(false);
  const [buyerId, setBuyerId] = useState(null);
  const [authStatus, setAuthStatus] = useState('checking');
  const [showCancelModal, setShowCancelModal] = useState(false);
  const [showReasonModal, setShowReasonModal] = useState(false);
  const [selectedReason, setSelectedReason] = useState('');
  const navigate = useNavigate();
  const location = useLocation();

  // ✅ Auth check - IMMEDIATE cart loading
  useEffect(() => {
    const checkAuth = () => {
      console.log('🔍 [CHECKOUT] Checking auth...');
      
      try {
        const userData = localStorage.getItem('user');
        console.log('🔍 [CHECKOUT] localStorage user:', userData);
        
        if (userData) {
          const user = JSON.parse(userData);
          console.log('🔍 [CHECKOUT] Parsed user:', user);
          
          const userId = user.id || user.user_id;
          console.log('🔍 [CHECKOUT] Found user ID:', userId);
          
          if (userId && (user.role === 'buyer' || user.role === 'customer')) {
            setBuyerId(userId);
            setAuthStatus('logged_in');
            console.log('✅ [CHECKOUT] Buyer authenticated:', userId);
            
            loadCartItems(userId);
          } else {
            console.log('❌ [CHECKOUT] Not a buyer or missing ID. Role:', user.role);
            setAuthStatus('not_logged_in');
          }
        } else {
          console.log('❌ [CHECKOUT] No user data in localStorage');
          setAuthStatus('not_logged_in');
        }
      } catch (error) {
        console.error('❌ [CHECKOUT] Auth check error:', error);
        setAuthStatus('not_logged_in');
      }
    };

    checkAuth();
  }, []);

  const loadCartItems = async (userId) => {
    try {
      console.log('🛒 [CHECKOUT] Loading cart for user:', userId);
      
      const response = await fetch(`http://localhost/hooper_fits_api/get_cart.php?buyer_id=${userId}`);
      const data = await response.json();
      
      console.log('🛒 [CHECKOUT] Cart API response:', data);
      
      if (data.success && data.cart && data.cart.length > 0) {
        setCartItems(data.cart);
        console.log('✅ [CHECKOUT] Using DB cart:', data.cart.length, 'items');
        return;
      }
      
      console.log('ℹ️ [CHECKOUT] DB cart empty, checking selectedProduct...');
      const selectedProduct = sessionStorage.getItem('selectedProduct');
      console.log('🛒 [CHECKOUT] selectedProduct raw:', selectedProduct);
      
      if (selectedProduct) {
        try {
          const product = JSON.parse(selectedProduct);
          console.log('✅ [CHECKOUT] Parsed selected product:', product);
          
          const cartItem = [{
            id: product.id || product.product_id,
            name: product.product_name,
            price: parseFloat(product.price),
            quantity: 1,
            image: product.image,
            seller_id: product.seller_id || null  // ✅ ENSURE seller_id for real-time
          }];
          
          setCartItems(cartItem);
          console.log('✅ [CHECKOUT] Set cart from selectedProduct:', cartItem);
        } catch (e) {
          console.error('❌ [CHECKOUT] Error parsing selected product:', e);
          setCartItems([]);
        }
      } else {
        console.log('ℹ️ [CHECKOUT] No selectedProduct found');
        setCartItems([]);
      }
      
    } catch (error) {
      console.error('❌ [CHECKOUT] Cart load error:', error);
      
      const selectedProduct = sessionStorage.getItem('selectedProduct');
      if (selectedProduct) {
        try {
          const product = JSON.parse(selectedProduct);
          setCartItems([{
            id: product.id || product.product_id,
            name: product.product_name,
            price: parseFloat(product.price),
            quantity: 1,
            image: product.image,
            seller_id: product.seller_id || null  // ✅ ENSURE seller_id for real-time
          }]);
          console.log('✅ [CHECKOUT] Emergency fallback from selectedProduct');
        } catch (e) {
          console.error('❌ [CHECKOUT] Fallback parse error:', e);
          setCartItems([]);
        }
      } else {
        setCartItems([]);
      }
    }
  };

  useEffect(() => {
    if (authStatus === 'not_logged_in') {
      console.log('🚫 [CHECKOUT] Not authenticated - starting redirect timer');
      const timer = setTimeout(() => {
        console.log('🔄 [CHECKOUT] Redirecting to login...');
        alert('Please login first to checkout!');
        navigate('/login');
      }, 3000);
      return () => clearTimeout(timer);
    }
  }, [authStatus, navigate]);

  const subtotal = cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
  const shipping = 50.00;
  const total = subtotal + shipping;

  const logout = () => {
    sessionStorage.clear();
    localStorage.clear();
    window.location.href = "/login";
  };

  // ✅ Logo goes to buyer_home
  const handleLogoClick = () => {
    navigate('/buyer_home');
  };

  // ✅ Profile goes to buyer_dashboard
  const handleProfileClick = () => {
    navigate('/buyer_dashboard');
  };

  // ✅ NEW: Remove individual item from cart
  const handleRemoveItem = async (itemId) => {
    if (!window.confirm('Remove this item from your cart?')) {
      return;
    }

    try {
      console.log('🗑️ [CHECKOUT] Removing item:', itemId);
      
      // Optimistically remove from UI first
      setCartItems(prevItems => {
        const newItems = prevItems.filter(item => item.id !== itemId);
        console.log('✅ [CHECKOUT] UI updated - remaining items:', newItems.length);
        return newItems;
      });

      // Call API to remove from database
      if (buyerId) {
        const response = await fetch('http://localhost/hooper_fits_api/remove_cart_item.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            buyer_id: buyerId,
            product_id: itemId
          })
        });

        const result = await response.json();
        console.log('✅ [CHECKOUT] API response:', result);
      }

      console.log('✅ [CHECKOUT] Item removed successfully');
      
    } catch (error) {
      console.error('❌ [CHECKOUT] Remove item error:', error);
      
      // Reload cart on error to sync with DB
      if (buyerId) {
        loadCartItems(buyerId);
      }
      
      alert('Failed to remove item. Cart has been refreshed.');
    }
  };

  // 🔥 UPDATED: handlePlaceOrder with seller_id for real-time
  const handlePlaceOrder = async () => {
    console.log('🚀 [CHECKOUT] Place order clicked!');
    console.log('🛒 Cart items:', cartItems);
    console.log('👤 Buyer ID:', buyerId);
    console.log('💰 Total:', total);
    console.log('🔐 Auth status:', authStatus);

    if (cartItems.length === 0) {
      alert('No items in cart!');
      return;
    }

    if (!buyerId) {
      alert('No buyer ID found! Please login again.');
      return;
    }

    if (authStatus !== 'logged_in') {
      alert('Please login first!');
      navigate('/login');
      return;
    }

    setLoading(true);
    try {
      // 🔥 FIXED: Ensure seller_id is included for real-time tracking
      const orderData = {
        buyer_id: buyerId,
        items: cartItems.map(item => ({
          id: item.id,
          seller_id: item.seller_id || null,  // ✅ Critical for real-time seller notifications
          quantity: item.quantity,
          price: item.price
        })),
        subtotal,
        shipping,
        total,
        status: 'pending'
      };
      
      console.log('📤 [CHECKOUT→SELLER] Sending order with seller_ids:', orderData.items.map(i => i.seller_id));
      
      const response = await fetch('http://localhost/hooper_fits_api/place_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(orderData)
      });

      console.log('📥 Response status:', response.status);
      const result = await response.json();
      console.log('📋 Full response:', result);
      
      if (result.success) {
        console.log('🎉 [CHECKOUT→SELLER] Order LIVE! ID:', result.order_id);
        alert('✅ Order placed successfully! Order ID: ' + result.order_id);
        
        // ✅ CLEAR CART using your existing cancel_order.php
        await fetch('http://localhost/hooper_fits_api/cancel_order.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            buyer_id: buyerId,
            reason: 'order_placed_successfully'
          })
        });
        
        sessionStorage.removeItem('selectedProduct');
        setCartItems([]);
        navigate('/buyer_home');
      } else {
        console.error('❌ Order failed:', result.error);
        alert('❌ Failed to place order: ' + (result.error || 'Unknown error'));
      }
    } catch (error) {
      console.error('❌ Network/Parse error:', error);
      alert('🌐 Network error. Check console (F12) and try again.');
    } finally {
      setLoading(false);
    }
  };

  const debugState = () => {
    console.log('🐛 DEBUG STATE:', {
      cartItems,
      buyerId,
      authStatus,
      subtotal,
      total,
      loading
    });
  };

  const handleCancelOrder = () => {
    setShowCancelModal(true);
  };

  const handleCancelConfirmNo = () => {
    setShowCancelModal(false);
  };

  const handleCancelConfirmYes = () => {
    setShowCancelModal(false);
    setShowReasonModal(true);
  };

  const handleReasonSelect = (reason) => {
    setSelectedReason(reason);
  };

  const handleReasonSubmit = async () => {
    if (!selectedReason) {
      alert('Please select a reason for cancellation');
      return;
    }

    try {
      const response = await fetch('http://localhost/hooper_fits_api/cancel_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          buyer_id: buyerId,
          reason: selectedReason
        })
      });

      const result = await response.json();
      
      if (result.success) {
        alert('Order cancelled successfully!');
        setShowReasonModal(false);
        setCartItems([]);
        navigate('/buyer_home');
      } else {
        alert('Failed to cancel order: ' + (result.error || 'Unknown error'));
      }
    } catch (error) {
      console.error('Cancel order error:', error);
      alert('Failed to cancel order. Please try again.');
    }
  };

  const handleReasonClose = () => {
    setShowReasonModal(false);
    setSelectedReason('');
  };

  if (authStatus === 'checking') {
    return (
      <div className="auth-checking">
        <div className="spinner"></div>
        <p>🔍 Checking login status...</p>
      </div>
    );
  }

  return (
    <>
      <header className="header">
        <img 
          src={logo} 
          className="logo" 
          alt="Hoopers Fits Logo"
          onClick={handleLogoClick}
          title="Go to Home"
        />
        <div className="header-right">
          <img 
            src={profileIcon} 
            alt="Profile" 
            className="header-icon"
            onClick={handleProfileClick}
            style={{ cursor: 'pointer' }}
            title="Go to Dashboard"
          />
          <span className="logout-btn" onClick={logout}>Logout</span>
        </div>
      </header>

      <div className="checkout-container">
        {authStatus === 'not_logged_in' && (
          <div className="auth-warning">
            <h3>⚠️ Please Login First</h3>
            <p>Redirecting to login in 3 seconds ⏳</p>
          </div>
        )}

        <section className="section delivery-address">
          <h2>📍 Delivery Address</h2>
          <div className="address-info">
            <div className="address-column">
              <p><strong>Andrei Lapuz Narito</strong></p>
              <p>(+63) 962 417 6786</p>
            </div>
            <div className="address-column">
              <p>1367 Santol St. 1B, B. F. International Village</p>
              <p>Las Pinas City, Metro Manila</p>
            </div>
            <div className="actions">
              <span>Default</span>
              <a href="#" className="change-link">Change</a>
            </div>
          </div>
        </section>

        <section className="section products-ordered">
          <h2>🛍️ Products Ordered</h2>
          {cartItems.length > 0 ? (
            cartItems.map((item) => (
              <div key={item.id} className="product-item">
                <div className="product-info">
                  <img 
                    src={item.image} 
                    alt={item.name}
                    onError={(e) => {
                      e.target.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2Y1ZjVmNSIvPjx0ZXh0IHg9IjUwJSIgeT0iNTAlIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTIiIGZpbGw9IiM5OTkiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGRvbWluYW50LWJhc2VsaW5lPSJjZW50cmFsIj5ObyBJbWFnZTwvdGV4dD48L3N2Zz4=';
                    }}
                  />
                  <div className="product-details">
                    <p>{item.name}</p>
                    {/* 🔥 DEBUG: Show seller_id */}
                    {item.seller_id && <small style={{color: '#666', fontSize: '11px'}}>Seller ID: {item.seller_id}</small>}
                  </div>
                </div>
                <div className="price-col">₱{item.price.toLocaleString('en-PH', { minimumFractionDigits: 2 })}</div>
                <div className="qty-col">{item.quantity}</div>
                <div className="price-col">₱{(item.price * item.quantity).toLocaleString('en-PH', { minimumFractionDigits: 2 })}</div>

                <div className="remove-col">
                  <button 
                    className="remove-btn"
                    onClick={() => handleRemoveItem(item.id)}
                    title="Remove item"
                  >
                    🗑️ Remove
                  </button>
                </div>
              </div>
            ))
          ) : (
            <p className="no-items">
              No items in cart. <a href="/buyer_shop" className="shop-link">Go to Shop →</a>
            </p>
          )}
        </section>

        <div className="section payment-method">
          <h2>💳 Payment Method</h2>
          <p><strong>Cash on Delivery</strong></p>
          <a href="#" className="change-link">Change</a>
        </div>

        <section className="section order-summary">
          <p>Subtotal: ₱{subtotal.toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
          <p>Shipping: ₱{shipping.toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
          <p className="total">Total: ₱{total.toLocaleString('en-PH', { minimumFractionDigits: 2 })}</p>
        </section>

        <button onClick={debugState} style={{marginBottom: '10px', padding: '5px 10px', fontSize: '12px'}}>
          🐛 Debug State (F12)
        </button>

        <button 
          className="place-order-btn" 
          onClick={handlePlaceOrder}
          disabled={loading || cartItems.length === 0 || !buyerId || authStatus !== 'logged_in'}
        >
          {loading ? (
            <>
              <div className="loading-spinner"></div>
              Processing Order...
            </>
          ) : (
            `Place Order (${cartItems.length} items)`
          )}
        </button>
      </div>

      {showCancelModal && (
        <div className="modal-overlay">
          <div className="cancel-modal">
            <div className="modal-header">
              <h3>Are you sure you want to cancel this order?</h3>
            </div>
            <div className="modal-body">
              <p>This action cannot be undone.</p>
            </div>
            <div className="modal-footer">
              <button className="btn btn-secondary" onClick={handleCancelConfirmNo}>No</button>
              <button className="btn btn-danger" onClick={handleCancelConfirmYes}>Yes, I want to cancel</button>
            </div>
          </div>
        </div>
      )}

      {showReasonModal && (
        <div className="modal-overlay">
          <div className="cancel-reason-modal">
            <div className="modal-header">
              <h3>Please choose a reason why you want to cancel</h3>
            </div>
            <div className="modal-body">
              <div className="reason-options">
                <label className="reason-option">
                  <input type="radio" name="cancelReason" value="changed my mind" onChange={(e) => handleReasonSelect(e.target.value)} />
                  <span>Changed my mind</span>
                </label>
                <label className="reason-option">
                  <input type="radio" name="cancelReason" value="found better price elsewhere" onChange={(e) => handleReasonSelect(e.target.value)} />
                  <span>Found better price elsewhere</span>
                </label>
                <label className="reason-option">
                  <input type="radio" name="cancelReason" value="no longer need it" onChange={(e) => handleReasonSelect(e.target.value)} />
                  <span>No longer need it</span>
                </label>
                <label className="reason-option">
                  <input type="radio" name="cancelReason" value="prefer different color/size" onChange={(e) => handleReasonSelect(e.target.value)} />
                  <span>Prefer different color/size</span>
                </label>
                <label className="reason-option">
                  <input type="radio" name="cancelReason" value="other" onChange={(e) => handleReasonSelect(e.target.value)} />
                  <span>Other</span>
                </label>
              </div>
            </div>
            <div className="modal-footer">
              <button className="btn btn-secondary" onClick={handleReasonClose}>Back</button>
              <button className="btn btn-danger" onClick={handleReasonSubmit} disabled={!selectedReason}>
                Submit Cancellation
              </button>
            </div>
          </div>
        </div>
      )}

      <footer className="footer">
        <p>
          <a href="/privacy" className="footer-link">Privacy Policy</a> | 
          <a href="/terms" className="footer-link">Terms and Conditions</a>
        </p>
        <div>
          Follow us on:
          <span className="social-icons">
            <a href="https://www.facebook.com/share/1as5kdEkMr/" target="_blank" rel="noopener noreferrer">
              <img src={facebookIcon} alt="Facebook" />
            </a>
            <a href="https://www.instagram.com/hoopersfits.ph?igsh=ZTFtNmw1YTR0OGZ6" target="_blank" rel="noopener noreferrer">
              <img src={instagramIcon} alt="Instagram" />
            </a>
          </span>
        </div>
      </footer>
    </>
  );
};

export default Checkout;