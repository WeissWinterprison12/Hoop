import React from "react";

import logo from "../Images/HoopersFits.png";
import profileIcon from "../Images/Profile.png";
import cartIcon from "../Images/Cart.png";
import facebookIcon from "../Images/facebook.png";
import instagramIcon from "../Images/Instagram.png";

import BassBro from "../Images/BassBro.jpg";
import ChromeJersey from "../Images/ChromeJersey.jpg";
import StussyProduct from "../Images/StussyProduct.jpg";
import ChromeCap from "../Images/ChromeCap.jpg";
import BLCKSZN from "../Images/BLCKSZN.jpg";
import ChromeZip from "../Images/ChromeZip.jpg";
import Saint from "../Images/Saint.jpg";
import CDGxStussy from "../Images/CDGxStussy.jpg";
import FormTeam from "../Images/FormTeam.jpg";
import ChromeHAzure from "../Images/ChromeHAzure.jpg";

const BuyerShop = () => {
  const logout = () => {
    window.location.href = "/login";
  };

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

        /* HEADER */

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

        .nav a:hover,
        .nav a.active {
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

        /* SHOP */

        .shop-container {
          width: 100vw;
          padding: 50px;
        }

        .product-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
          gap: 30px;
          width: 100%;
        }
        
        #root {
          width: 100%;
        }

        .product-card {
          background: #fff;
          border-radius: 10px;
          padding: 15px;
          display: flex;
          flex-direction: column;
          align-items: center;
          text-align: center;
          transition: transform 0.25s ease, box-shadow 0.25s ease;
          width: 100%;
          max-width: 100%;
        }

        .product-card:hover {
          transform: translateY(-6px);
          box-shadow: 0 10px 20px rgba(0,0,0,0.25);
        }

        .product-card img {
          width: 100%;
          height: 220px;
          object-fit: cover;
          border-radius: 8px;
          margin-bottom: 10px;
        }

        .product-title {
          font-size: 14px;
          font-weight: 600;
          margin-bottom: 5px;
        }

        .product-price {
          font-size: 13px;
          color: #555;
        }

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
          transition: transform 0.3s ease, filter 0.3s ease;
        }

        .social-icons a:hover img {
          transform: scale(1.2);
          filter: brightness(1.5);
        }

        @media (max-width: 900px) {
          .product-grid {
            grid-template-columns: 1fr;
          }

          .shop-container {
            padding: 50px;
            width: 100%;
          }

          .header {
            flex-direction: column;
            gap: 15px;
          }

          .footer {
            flex-direction: column;
            gap: 15px;
            text-align: center;
          }
        }
      `}</style>

      <header className="header">
        <img src={logo} className="logo" alt="Hoopers Fits Logo" />

        <nav className="nav">
          <a href="/buyer_home">Home</a>
          <a href="/buyer_shop" className="active">Shop</a>
          <a href="#">New Fits</a>
          <a href="/contact">Contact Us</a>
        </nav>

        <div className="search-bar">
          <input type="text" placeholder="Search" />
        </div>

        <div className="icons">
          <a href="/buyer_dashboard">
            <img src={profileIcon} alt="User" />
          </a>

          <a href="/checkout">
            <img src={cartIcon} alt="Cart" />
          </a>
        </div>

        <span className="logout-btn" onClick={logout}>
          Logout
        </span>
      </header>

      <section className="shop-container">
        <div className="product-grid">

          <div className="product-card">
            <img src={BassBro} alt="Bas Bro Shop Cap" />
            <div className="product-title">Bas Bro Shop Cap</div>
            <div className="product-price">From ₱1,999.99</div>
          </div>

          <div className="product-card">
            <img src={ChromeJersey} alt="Chrome Heart Baseball Jersey" />
            <div className="product-title">Chrome Heart Baseball Jersey</div>
            <div className="product-price">From ₱999.50</div>
          </div>

          <div className="product-card">
            <img src={StussyProduct} alt="Stussy" />
            <div className="product-title">Stussy</div>
            <div className="product-price">From ₱699.99</div>
          </div>

          <div className="product-card">
            <img src={ChromeCap} alt="Chrome Heart Net Cap" />
            <div className="product-title">Chrome Heart Net Cap</div>
            <div className="product-price">From ₱549.25</div>
          </div>

          <div className="product-card">
            <img src={BLCKSZN} alt="BLKZN Cap" />
            <div className="product-title">BLKZN Cap</div>
            <div className="product-price">From ₱299.50</div>
          </div>

          <div className="product-card">
            <img src={ChromeZip} alt="Chrome Heart Zipper Jacket" />
            <div className="product-title">Chrome Heart Zipper Jacket</div>
            <div className="product-price">From ₱875.50</div>
          </div>

          <div className="product-card">
            <img src={Saint} alt="Saint of God Hoodie" />
            <div className="product-title">Saint of God Hoodie</div>
            <div className="product-price">From ₱950.99</div>
          </div>

          <div className="product-card">
            <img src={CDGxStussy} alt="CDG x Stussy Varsity Jacket" />
            <div className="product-title">CDG x Stussy Varsity Jacket</div>
            <div className="product-price">From ₱6,555.50</div>
          </div>

          <div className="product-card">
            <img src={FormTeam} alt="Chrome Hearts Form Team Jersey" />
            <div className="product-title">Chrome Hearts Form Team Jersey</div>
            <div className="product-price">From ₱749.99</div>
          </div>

          <div className="product-card">
            <img src={ChromeHAzure} alt="Chrome Hearts Azure" />
            <div className="product-title">Chrome Hearts Azure</div>
            <div className="product-price">From ₱865.25</div>
          </div>

        </div>
      </section>

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