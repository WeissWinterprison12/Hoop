import React, { useRef, useState } from "react";
import logo from "../Images/HoopersFits.png";
import heroBg from "../Images/sapatos.jpg";
import facebookIcon from "../Images/facebook.png";
import instagramIcon from "../Images/Instagram.png";

const Login = () => {
  const loginBoxRef = useRef(null);

  // States for inline errors
  const [usernameError, setUsernameError] = useState("");
  const [passwordError, setPasswordError] = useState("");

  const handleLogin = async (e) => {
    e.preventDefault();

    const username = e.target.username.value;
    const password = e.target.password.value;

    // Reset errors before request
    setUsernameError("");
    setPasswordError("");

    try {
      const response = await fetch(
        "http://localhost/hooper_fits_api/login.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            username: username,
            password: password,
          }),
        }
      );

      const data = await response.json();

      if (data.status === "success") {
        loginBoxRef.current.classList.add("slide-out");
        setTimeout(() => {
          window.location.href = "/buyer_home";
        }, 600);
      } else {
        // Set inline errors depending on response
        if (data.errorField === "username") {
          setUsernameError("Invalid username");
        }
        if (data.errorField === "password") {
          setPasswordError("Invalid password");
        }
      }
    } catch (error) {
      console.error("Login error:", error);
      setPasswordError("Server error. Please try again.");
    }
  };

  const goRegister = () => {
    loginBoxRef.current.classList.add("slide-out");
    setTimeout(() => {
      window.location.href = "/register";
    }, 600);
  };

  return (
    <>
      <style>{`
        * { box-sizing: border-box; }

        html, body { width: 100vw; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; background-color: #000; color: #fff; overflow-x: hidden; }

        .hero { position: relative; width: 100vw; min-height: 80vh; overflow: hidden; }

        .header { display: flex; justify-content: space-between; align-items: center; padding: 20px 50px; position: absolute; top: 0; width: 100%; z-index: 10; background: linear-gradient(rgba(0,0,0,0.95), rgba(0,0,0,0.85)); }

        .logo { width: 100px; }

        .nav a { color: #fff; text-decoration: none; margin-left: 20px; font-size: 14px; }
        .nav a:hover { color: #dc3545; }

        .hero::before {
          content: "";
          position: absolute;
          top: -10%;
          left: -5%;
          width: 110%;
          height: 130%;
          background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url(${heroBg}) no-repeat center center / cover;
          transform: skewY(-5deg);
          transform-origin: top left;
          z-index: 1;
        }

        .hero-content { position: relative; z-index: 2; display: flex; justify-content: space-between; align-items: center; min-height: 80vh; padding: 0 80px; }

        .text-section h2 { font-size: 38px; margin: 0; text-transform: uppercase; }
        .text-section h2:first-child { color: #dc3545; }

        .login-section { width: 360px; background: rgba(255,255,255,0.95); color: #333; border-radius: 12px; padding: 30px; backdrop-filter: blur(6px); }

        .login-tabs { display: flex; justify-content: space-around; margin-bottom: 20px; }
        .login-tabs button { background: none; border: none; font-size: 16px; padding: 10px; cursor: pointer; border-bottom: 2px solid transparent; }
        .login-tabs button.active { border-color: #dc3545; color: #dc3545; font-weight: 600; }

        .form-group { margin-bottom: 15px; }
        .form-group label { font-size: 14px; margin-bottom: 5px; display: block; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .form-group input.error { border-color: red; }

        .error-text { color: red; font-size: 13px; margin-top: 5px; }

        .login-button { width: 100%; background-color: #dc3545; color: #fff; padding: 10px; border: none; border-radius: 20px; cursor: pointer; }
        .login-button:hover { background-color: #b02a37; }

        .forgot-password { text-align: center; margin-top: 10px; }
        .forgot-password a { color: #777; font-size: 13px; text-decoration: none; }

        .slide-out { animation: slideOut 0.6s ease forwards; }
        @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }

        .footer { display: flex; justify-content: space-between; align-items: center; padding: 20px 50px; font-size: 12px; }
        .footer-link { color: #fff; text-decoration: none; margin: 0 5px; }
        .footer-link:hover { color: #dc3545; }

        .social-icons img { width: 20px; margin-left: 10px; }
        @media (max-width: 900px) { .hero-content { flex-direction: column; text-align: center; } .login-section { margin-top: 30px; } }
        .social-icons a img { width: 20px; margin-left: 10px; transition: transform 0.3s ease, filter 0.3s ease; }
        .social-icons a:hover img { transform: scale(1.2); filter: brightness(1.5); }
      `}</style>

      <section className="hero">
        <div className="header">
          <img src={logo} className="logo" alt="Hoopers Fits Logo" />
          <nav className="nav">
            <a href="#">HOME</a>
            <a href="#">PRODUCT</a>
            <a href="#">ABOUT</a>
            <a href="#">CONTACT</a>
          </nav>
        </div>

        <div className="hero-content">
          <div className="text-section">
            <h2>ELEVATE YOUR GAME</h2>
            <h2>ELEVATE YOUR FIT</h2>
          </div>

          <div className="login-section" ref={loginBoxRef}>
            <div className="login-tabs">
              <button className="active">Login</button>
              <button onClick={goRegister}>Register</button>
            </div>

            <form onSubmit={handleLogin}>
              <div className="form-group">
                <label>Username</label>
                <input
                  name="username"
                  type="text"
                  required
                  className={usernameError ? "error" : ""}
                />
                {usernameError && <div className="error-text">{usernameError}</div>}
              </div>

              <div className="form-group">
                <label>Password</label>
                <input
                  name="password"
                  type="password"
                  required
                  className={passwordError ? "error" : ""}
                />
                {passwordError && <div className="error-text">{passwordError}</div>}
              </div>

              <button className="login-button">Login</button>
            </form>

            <div className="forgot-password">
              <a href="#">Forgot password?</a>
            </div>
          </div>
        </div>
      </section>

      <footer className="footer">
        <p>
          <a href="/privacy" className="footer-link">Privacy Policy</a> |
          <a href="/terms" className="footer-link">Terms & Conditions</a>
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

export default Login;