import React, { useState } from "react";
import logo from "../Images/HoopersFits.png";
import profileIcon from "../Images/Profile.png";
import cartIcon from "../Images/Cart.png";
import facebookIcon from "../Images/facebook.png";
import instagramIcon from "../Images/Instagram.png";
import "../components/Contact.css";

const Contact = () => {
  const [formData, setFormData] = useState({
    fullname: "",
    email: "",
    message: ""
  });
  const [loading, setLoading] = useState(false);
  const [success, setSuccess] = useState(false);
  const [error, setError] = useState("");

  const logout = () => {
    window.location.href = "/login";
  };

  const handleFacebookRedirect = () => {
    window.open("https://www.facebook.com/share/1as5kdEkMr/", "_blank");
  };

  const handleInputChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
    if (error) setError("");
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError("");
    
    try {
      // Get current user ID from localStorage (adjust based on your auth)
      const userId = localStorage.getItem('userId') || 2; // fallback for testing
      
      const response = await fetch("http://localhost/hooper_fits_api/process_contact.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          ...formData,
          sender_id: parseInt(userId),
          receiver_id: 1 // Admin ID
        }),
      });
      
      if (!response.ok) {
        throw new Error("Failed to send message");
      }
      
      const result = await response.json();
      
      if (result.success) {
        setSuccess(true);
        setFormData({ fullname: "", email: "", message: "" });
      } else {
        setError(result.error || "Failed to send message");
      }
    } catch (err) {
      setError("Failed to send message. Please try again.");
      console.error("Contact form error:", err);
    } finally {
      setLoading(false);
    }
  };

  if (success) {
    return (
      <>
        <header className="header">
          <img src={logo} className="logo" alt="Hoopers Fits Logo" />
          <nav className="nav">
            <a href="/buyer_home">Home</a>
            <a href="/buyer_shop">Shop</a>
            <a href="#">New Fits</a>
            <a href="/contact" className="active">Contact Us</a>
          </nav>
          <div className="search-bar">
            <input type="text" placeholder="Search products..." />
          </div>
          <div className="icons">
            <a href="/buyer_dashboard">
              <img src={profileIcon} alt="Profile" />
            </a>
            <a href="/checkout">
              <img src={cartIcon} alt="Cart" />
            </a>
          </div>
          <span className="logout-btn" onClick={logout}>Logout</span>
        </header>
        
        <div className="success-container">
          <div className="success-icon">✅</div>
          <h1 className="success-title">Message Sent Successfully!</h1>
          <p className="success-message">
            Thank you for reaching out! We'll get back to you within 24-48 hours.
          </p>
          <button className="continue-btn" onClick={() => setSuccess(false)}>
            Send Another Message
          </button>
        </div>
        
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
  }

  return (
    <>
      <header className="header">
        <img src={logo} className="logo" alt="Hoopers Fits Logo" />
        <nav className="nav">
          <a href="/buyer_home">Home</a>
          <a href="/buyer_shop">Shop</a>
          <a href="#">New Fits</a>
          <a href="/contact" className="active">Contact Us</a>
        </nav>
        <div className="search-bar">
          <input type="text" placeholder="Search products..." />
        </div>
        <div className="icons">
          <a href="/buyer_dashboard">
            <img src={profileIcon} alt="Profile" />
          </a>
          <a href="/checkout">
            <img src={cartIcon} alt="Cart" />
          </a>
        </div>
        <span className="logout-btn" onClick={logout}>Logout</span>
      </header>

      <section className="contact-container">
        {error && (
          <div className="error-message">
            ⚠️ {error}
          </div>
        )}
        
        <div className="contact-section">
          <div className="contact-info">
            <h1>Get In Touch.</h1>
            <p>Have a question about our products? Need help with your order? We're here to help!</p>
            
            <div className="contact-details">
              <div className="contact-item">
                <div className="contact-icon">📧</div>
                <div className="contact-text">
                  <h3>Email</h3>
                  <p>
                    <span 
                      className="clickable-email"
                      onClick={handleFacebookRedirect}
                      style={{
                        color: '#4267B2',
                        textDecoration: 'underline',
                        cursor: 'pointer',
                        display: 'inline-block'
                      }}
                      title="Click to message us on Facebook"
                    >
                      support@hoopersfits.ph
                    </span>
                  </p>
                </div>
              </div>
              <div className="contact-item">
                <div className="contact-icon">📱</div>
                <div className="contact-text">
                  <h3>Phone</h3>
                  <p>(+63) 939 601 4810</p>
                </div>
              </div>
              <div className="contact-item">
                <div className="contact-icon">📍</div>
                <div className="contact-text">
                  <h3>Location</h3>
                  <p>Imus City, Cavite</p>
                </div>
              </div>
            </div>
          </div>
          
          <div className="contact-form">
            <form onSubmit={handleSubmit}>
              <div className="form-group">
                <label htmlFor="fullname">Full Name</label>
                <input
                  type="text"
                  id="fullname"
                  name="fullname"
                  value={formData.fullname}
                  onChange={handleInputChange}
                  required
                  placeholder="Enter your full name"
                />
              </div>
              
              <div className="form-group">
                <label htmlFor="email">Email Address</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  value={formData.email}
                  onChange={handleInputChange}
                  required
                  placeholder="your@email.com"
                />
              </div>
              
              <div className="form-group">
                <label htmlFor="message">Message</label>
                <textarea
                  id="message"
                  name="message"
                  value={formData.message}
                  onChange={handleInputChange}
                  required
                  placeholder="Tell us about your inquiry..."
                />
              </div>
              
              <button 
                type="submit" 
                className="submit-btn"
                disabled={loading}
              >
                {loading ? (
                  <>
                    <div className="loading-spinner"></div>
                    Sending Message...
                  </>
                ) : (
                  'Send Message'
                )}
              </button>
            </form>
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

export default Contact;