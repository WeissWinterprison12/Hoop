import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom"; // ✅ Added for navigation

import logo from "../Images/HoopersFits.png";
import profileIcon from "../Images/Profile.png";
import cartIcon from "../Images/Cart.png";
import facebookIcon from "../Images/facebook.png";
import instagramIcon from "../Images/Instagram.png";

const BuyerShop = () => {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const navigate = useNavigate(); // ✅ Navigation hook

  const logout = () => {
    sessionStorage.clear();
    localStorage.clear();
    window.location.href = "/login";
  };

  // ✅ IMPROVED: Handle product click - redirect to checkout with product data
  const handleProductClick = (product) => {
    if (parseInt(product.stock || 0) > 0) {
      // Store product in sessionStorage and navigate to checkout
      sessionStorage.setItem('selectedProduct', JSON.stringify(product));
      navigate('/checkout');
    } else {
      alert('This product is out of stock!');
    }
  };

  const fetchProducts = async () => {
    try {
      setLoading(true);
      setError(null);
      
      console.log('🔍 Fetching products...');
      const response = await fetch("http://localhost/hooper_fits_api/get_all_products.php");
      
      if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
      }
      
      const result = await response.json();
      console.log('📦 API Response:', result);
      
      if (result.success) {
        console.table(result.products?.map(p => ({name: p.product_name, image: p.image})));
        setProducts(result.products || []);
      } else {
        setError(result.error || 'No products found');
      }
    } catch (error) {
      console.error('❌ Error:', error);
      setError('Failed to load products');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchProducts();
  }, []);

  return (
    <>
      <style>{`
        * {
          box-sizing: border-box;
          margin: 0;
          padding: 0;
        }

        body, html {
          margin: 0;
          padding: 0;
          width: 100%;
          min-height: 100vh;
          overflow-x: hidden;
          font-family: 'Poppins', sans-serif;
          background-color: #fff;
        }

        .header {
          width: 100vw;
          display: flex;
          align-items: center;
          justify-content: space-between;
          padding: 20px 50px;
          background-color: #000;
        }

        .logo {
          width: 110px;
        }

        .nav {
          display: flex;
          align-items: center;
          gap: 25px;
        }

        .nav a {
          color: #fff;
          text-decoration: none;
          font-size: 14px;
        }

        .nav a:hover, .nav a.active {
          color: #dc3545;
          font-weight: 600;
        }

        .search-bar input {
          background: #333;
          border: 1px solid #555;
          color: #fff;
          padding: 6px 12px;
          border-radius: 20px;
          outline: none;
          font-size: 13px;
          width: 200px;
        }

        .icons {
          display: flex;
          align-items: center;
          gap: 15px;
        }

        .icons img {
          width: 22px;
          cursor: pointer;
          transition: transform 0.2s ease;
        }

        .icons img:hover {
          transform: scale(1.15);
        }

        /* ✅ NEW: Cart badge styles */
        .cart-badge {
          position: absolute;
          top: -5px;
          right: -5px;
          background: #dc3545;
          color: white;
          border-radius: 50%;
          width: 18px;
          height: 18px;
          font-size: 12px;
          font-weight: bold;
          display: flex;
          align-items: center;
          justify-content: center;
          animation: pulse 2s infinite;
        }

        @keyframes pulse {
          0% { transform: scale(1); }
          50% { transform: scale(1.1); }
          100% { transform: scale(1); }
        }

        .logout-btn {
          color: #fff;
          text-decoration: none;
          font-size: 14px;
          margin-left: 15px;
          cursor: pointer;
        }

        .logout-btn:hover {
          color: #dc3545;
          font-weight: 600;
        }

        .shop-container {
          width: 100vw;
          padding: 50px;
        }

        .loading-container {
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          min-height: 400px;
          color: #666;
        }

        .loading-spinner {
          width: 50px;
          height: 50px;
          border: 4px solid #f3f3f3;
          border-top: 4px solid #dc3545;
          border-radius: 50%;
          animation: spin 1s linear infinite;
          margin-bottom: 20px;
        }

        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }

        .error-container {
          text-align: center;
          padding: 60px 20px;
          color: #dc3545;
        }

        .error-container h3 {
          margin-bottom: 15px;
          color: #333;
        }

        .retry-btn {
          background: #dc3545;
          color: white;
          border: none;
          padding: 12px 24px;
          border-radius: 25px;
          font-size: 16px;
          font-weight: 600;
          cursor: pointer;
          margin-top: 15px;
          transition: all 0.3s;
        }

        .retry-btn:hover {
          background: #c82333;
          transform: translateY(-2px);
        }

        .no-products {
          text-align: center;
          padding: 80px 20px;
          color: #666;
        }

        .no-products-icon {
          font-size: 64px;
          margin-bottom: 20px;
        }

        /* ✅ MATCHING SIZES FROM YOUR PHP VERSION */
        .product-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
          gap: 30px;
          max-width: 1400px;
          margin: 0 auto;
        }

        .product-card {
          background: #fff;
          border-radius: 12px;
          padding: 20px;
          text-align: center;
          transition: all 0.3s ease;
          border: 2px solid transparent;
          cursor: pointer;
          box-shadow: 0 4px 15px rgba(0,0,0,0.1);
          /* ✅ SAME HEIGHT FOR ALL CARDS */
          height: 100%;
          display: flex;
          flex-direction: column;
        }

        .product-card:hover {
          transform: translateY(-8px);
          box-shadow: 0 15px 30px rgba(0,0,0,0.2);
          border-color: #dc3545;
        }

        /* ✅ FIXED IMAGE SIZE - MATCHES PHP VERSION */
        .product-image {
          width: 100%;
          height: 220px; /* ✅ EXACT SAME HEIGHT */
          object-fit: cover;
          border-radius: 8px;
          margin-bottom: 15px;
          background: linear-gradient(45deg, #f8f9fa, #e9ecef);
          flex-shrink: 0; /* Prevents image from shrinking */
        }

        .product-title {
          font-size: 16px;
          font-weight: 600;
          color: #333;
          margin-bottom: 8px;
          min-height: 44px; /* ✅ SAME HEIGHT */
          display: flex;
          align-items: center;
          justify-content: center;
          flex-grow: 1; /* Takes remaining space */
        }

        .product-price {
          font-size: 20px;
          font-weight: 700;
          color: #dc3545;
          margin-bottom: 8px;
        }

        .stock-badge {
          display: inline-block;
          padding: 6px 12px;
          border-radius: 20px;
          font-size: 12px;
          font-weight: 600;
          margin-top: 8px;
        }

        .in-stock {
          background: #d4edda;
          color: #155724;
        }

        .out-of-stock {
          background: #f8d7da;
          color: #721c24;
        }

        /* ✅ FOOTER - ALREADY PERFECTLY IMPLEMENTED */
        .footer {
          width: 100%;
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 20px 50px;
          font-size: 12px;
          border-top: 1px solid #ddd;
          background-color: #000;
          color: #fff;
          margin-top: auto; /* Pushes footer to bottom */
        }

        .footer-link {
          color: #fff;
          text-decoration: none;
          margin: 0 5px;
        }

        .footer-link:hover {
          color: #dc3545;
        }

        .social-icons a img {
          width: 20px;
          margin-left: 10px;
          transition: transform 0.3s ease;
        }

        .social-icons a:hover img {
          transform: scale(1.2);
        }

        @media (max-width: 900px) {
          .header {
            flex-direction: column;
            gap: 20px;
            padding: 20px;
          }
          
          .shop-container {
            padding: 30px 20px;
          }
          
          .product-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
          }
          
          .footer {
            flex-direction: column;
            gap: 15px;
            text-align: center;
            padding: 20px;
          }
        }
      `}</style>

      {/* ✅ UPDATED HEADER WITH SMART CART */}
      <header className="header">
        <img src={logo} className="logo" alt="Hoopers Fits Logo" />
        <nav className="nav">
          <a href="/buyer_home">Home</a>
          <a href="/buyer_shop" className="active">Shop</a>
          <a href="#">New Fits</a>
          <a href="/contact">Contact Us</a>
        </nav>
        <div className="search-bar">
          <input type="text" placeholder="Search products..." />
        </div>
        <div className="icons">
          <a href="/buyer_dashboard">
            <img src={profileIcon} alt="Profile" />
          </a>
          {/* ✅ SMART CART WITH BADGE & VALIDATION */}
          <div 
            className="cart-link"
            style={{
              position: 'relative',
              cursor: 'pointer'
            }}
            onClick={() => {
              const selectedProduct = sessionStorage.getItem('selectedProduct');
              if (selectedProduct) {
                navigate('/checkout');
              } else {
                alert('Please select a product first! 🛍️');
              }
            }}
            title={sessionStorage.getItem('selectedProduct') ? 'Go to Checkout' : 'Select a product first'}
          >
            <img src={cartIcon} alt="Cart" style={{width: '22px'}} />
            {sessionStorage.getItem('selectedProduct') && (
              <span className="cart-badge">1</span>
            )}
          </div>
        </div>
        <span className="logout-btn" onClick={logout}>Logout</span>
      </header>

      <section className="shop-container">
        {loading ? (
          <div className="loading-container">
            <div className="loading-spinner"></div>
            <p>Loading shop products...</p>
          </div>
        ) : error ? (
          <div className="error-container">
            <h3>⚠️ {error}</h3>
            <p>Please check your connection and try again</p>
            <button className="retry-btn" onClick={fetchProducts}>
              🔄 Reload Products
            </button>
          </div>
        ) : products.length === 0 ? (
          <div className="no-products">
            <div className="no-products-icon">📦</div>
            <h2>No products available</h2>
            <p>Check back soon for new arrivals!</p>
          </div>
        ) : (
          <div className="product-grid">
            {products.map((product, index) => {
              const stock = parseInt(product.stock || 0);
              const isInStock = stock > 0;
              
              const imageUrl = product.image && product.image.trim() ? 
                `http://localhost/hooper_fits_api/uploads/products/${product.image.trim()}` : 
                'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjVmNWY1Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZG9taW5hbnQtYmFzZWxpbmU9ImNlbnRyYWwiPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg==';
              
              return (
                // ✅ CLICK HANDLER ADDED HERE
                <div 
                  key={product.id || index} 
                  className="product-card"
                  onClick={() => handleProductClick(product)}
                >
                  <img 
                    src={imageUrl} 
                    alt={product.product_name}
                    className="product-image"
                    loading="lazy"
                    onError={(e) => {
                      e.target.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjVmNWY1Ii8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZG9taW5hbnQtYmFzZWxpbmU9ImNlbnRyYWwiPk5vIEltYWdlPC90ZXh0Pjwvc3ZnPg==';
                    }}
                  />
                  <div className="product-title">{product.product_name}</div>
                  <div className="product-price">
                    ₱{parseFloat(product.price || 0).toLocaleString('en-PH', { 
                      minimumFractionDigits: 2 
                    })}
                  </div>
                  <div className={`stock-badge ${isInStock ? 'in-stock' : 'out-of-stock'}`}>
                    {isInStock ? `In Stock (${stock})` : 'Out of Stock'}
                  </div>
                </div>
              );
            })}
          </div>
        )}
      </section>

      {/* ✅ FOOTER - ALREADY PERFECTLY VISIBLE */}
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

export default BuyerShop;