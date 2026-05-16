import React, { useRef, useState } from "react";
import logo from "../Images/HoopersFits.png";
import heroBg from "../Images/sapatos.jpg";
import facebookIcon from "../Images/facebook.png";
import instagramIcon from "../Images/Instagram.png";

const Login = () => {
  const loginBoxRef = useRef(null);
  const [showForgotPassword, setShowForgotPassword] = useState(false);
  const [usernameError, setUsernameError] = useState("");
  const [passwordError, setPasswordError] = useState("");
  const [resetError, setResetError] = useState("");
  const [resetSuccess, setResetSuccess] = useState("");
  const [resetErrors, setResetErrors] = useState({});
  const [securityQuestions] = useState([
    "What is the name of your first pet?",
    "What is your mother's maiden name?",
    "What is the name of your father?",
    "What is the name of your first school?",
    "What city were you born in?",
    "What is your favorite childhood book?"
  ]);

  const handleLogin = async (e) => {
    e.preventDefault();
    const username = e.target.username.value.trim();
    const password = e.target.password.value;

    setUsernameError("");
    setPasswordError("");

    try {
      const response = await fetch("http://localhost/hooper_fits_api/login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password })
      });

      const data = await response.json();

      console.log("🔍 FULL LOGIN RESPONSE:", data);
      console.log("🔍 USER ROLE:", data.role, "TYPE:", typeof data.role);

      if (data.status === "success") {
        console.log('🎉 Login success');
        
        // Store user data in localStorage instead of using auth context
        localStorage.setItem('user', JSON.stringify(data));
        
        loginBoxRef.current.classList.add("slide-out");
        
        setTimeout(() => {
          if (data.role === 'seller' || data.role === 'admin') {
            console.log("🎯 REDIRECTING ADMIN/SELLER TO DASHBOARD");
            window.location.href = "/seller_dashboard";
          } else {
            console.log("🎯 REDIRECTING BUYER TO HOME");
            window.location.href = "/buyer_home";
          }
        }, 600);
      } else {
        switch(data.errorField) {
          case "username":
            setUsernameError("Username not found");
            break;
          case "password":
            setPasswordError("Wrong password");
            break;
          case "request":
            setPasswordError("Server error");
            break;
          default:
            setPasswordError("Login failed");
        }
      }
    } catch (error) {
      console.error("❌ Error:", error);
      setPasswordError("Connection failed. Is XAMPP running?");
    }
  };

  const handlePasswordReset = async (e) => {
    e.preventDefault();
    const username = e.target.username.value.trim();
    const securityQuestion = e.target.securityQuestion.value;
    const securityAnswer = e.target.securityAnswer.value.trim();
    const newPassword = e.target.newPassword.value;
    const confirmPassword = e.target.confirmPassword.value;

    setResetError("");
    setResetSuccess("");
    setResetErrors({});

    // Client-side validation
    let newErrors = {};
    
    if (!securityQuestion) {
      newErrors.securityQuestion = "Please select a security question.";
    }
    
    if (securityAnswer.trim().length < 2) {
      newErrors.securityAnswer = "Security answer must be at least 2 characters.";
    }

    // Password validation (same as register)
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,20}$/;
    
    if (!passwordRegex.test(newPassword)) {
      if (newPassword.length < 8) {
        newErrors.newPassword = "Password must be 8-20 characters";
      } else if (/[^A-Za-z0-9]/.test(newPassword)) {
        newErrors.newPassword = "No special characters allowed.";
      } else if (!/[a-z]/.test(newPassword)) {
        newErrors.newPassword = "Password should contain lowercase letters";
      } else if (!/[A-Z]/.test(newPassword)) {
        newErrors.newPassword = "Password should contain uppercase letters";
      } else if (!/\d/.test(newPassword)) {
        newErrors.newPassword = "Password should contain numerical digits";
      }
    }

    if (newErrors.newPassword) {
      newErrors.confirmPassword = newErrors.newPassword;
    } else if (newPassword !== confirmPassword) {
      newErrors.confirmPassword = "Password does not match";
    }

    setResetErrors(newErrors);
    if (Object.keys(newErrors).length > 0) return;

    try {
      const response = await fetch("http://localhost/hooper_fits_api/reset_password.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ 
          username, 
          security_question: securityQuestion,
          security_answer: securityAnswer,
          newPassword
        })
      });

      const data = await response.json();

      if (data.status === "success") {
        setResetSuccess(data.message);
        e.target.reset();
        setTimeout(() => {
          setShowForgotPassword(false);
        }, 2000);
      } else {
        setResetError(data.message || "Reset failed");
      }
    } catch (error) {
      console.error("❌ Reset Error:", error);
      setResetError("Connection failed. Is XAMPP running?");
    }
  };

  const toggleForgotPassword = () => {
    setShowForgotPassword(!showForgotPassword);
    setResetError("");
    setResetSuccess("");
    setResetErrors({});
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

        .hero { 
          position: relative; 
          width: 100vw; 
          min-height: 88vh;
          overflow: hidden; 
        }

        .header { 
          display: flex; 
          justify-content: space-between; 
          align-items: center; 
          padding: 20px 50px; 
          position: absolute; 
          top: 0; 
          width: 100%; 
          z-index: 10; 
        }

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

        .hero-content { 
          position: relative; 
          z-index: 2; 
          display: flex; 
          justify-content: space-between; 
          align-items: center; 
          min-height: 88vh; 
          padding: 0 80px; 
        }

        .text-section h2 { font-size: 38px; margin: 0; text-transform: uppercase; }
        .text-section h2:first-child { color: #dc3545; }

        .login-section { 
          width: 360px; 
          height: 360px;
          background: rgba(255,255,255,0.95); 
          color: #333; 
          border-radius: 12px; 
          padding: 20px; 
          backdrop-filter: blur(6px);
          display: flex;
          flex-direction: column;
          transition: all 0.4s ease;
          overflow: hidden;
        }

        .form-scroll { 
          flex: 1; 
          overflow-y: auto; 
          padding-right: 5px;
          scrollbar-width: thin;
          scrollbar-color: #ccc transparent;
        }
        .form-scroll::-webkit-scrollbar { width: 4px; }
        .form-scroll::-webkit-scrollbar-track { background: transparent; }
        .form-scroll::-webkit-scrollbar-thumb { background: #ccc; border-radius: 2px; }

        .login-tabs { display: flex; justify-content: space-around; margin-bottom: 10px; }
        .login-tabs button { 
          background: none; 
          border: none; 
          font-size: 16px; 
          padding: 10px; 
          cursor: pointer; 
          border-bottom: 2px solid transparent; 
        }
        .login-tabs button.active { border-color: #dc3545; color: #dc3545; font-weight: 600; }

        .form-group { margin-bottom: 12px; }
        .form-group label { font-size: 14px; margin-bottom: 5px; display: block; font-weight: 500; }
        .form-group input, .form-group select { 
          width: 100%; 
          padding: 10px; 
          border: 1px solid #ddd; 
          border-radius: 4px; 
          font-size: 14px;
        }
        .form-group select { cursor: pointer; }
        .form-group input.error, .form-group input.error-input { 
          border-color: red !important; 
          box-shadow: 0 0 5px rgba(255,0,0,0.3); 
        }

        .tooltip { 
          margin-left: 6px; 
          cursor: pointer; 
          color: #dc3545; 
          font-weight: bold; 
          font-size: 14px;
        }

        .error-text { color: red; font-size: 13px; margin-top: 5px; }
        .success-text { color: green; font-size: 13px; margin-top: 5px; }

        .login-button, .reset-button { 
          width: 100%; 
          background-color: #dc3545; 
          color: #fff; 
          padding: 12px; 
          border: none; 
          border-radius: 20px; 
          cursor: pointer; 
          margin-top: 5px; 
          font-size: 16px; 
          font-weight: 600;
        }
        .login-button:hover, .reset-button:hover { background-color: #b02a37; }

        .back-to-login { 
          background: none; 
          border: 1px solid #dc3545; 
          color: #dc3545; 
          padding: 8px 16px; 
          border-radius: 20px; 
          font-size: 13px; 
          cursor: pointer;
          text-decoration: none;
          display: inline-block;
          margin-top: 10px;
        }
        .back-to-login:hover { background: #dc3545; color: white; }

        .forgot-password { text-align: center; margin-top: 10px; }
        .forgot-password a { color: #777; font-size: 13px; text-decoration: none; cursor: pointer; }
        .forgot-password a:hover { color: #dc3545; }

        .slide-out { animation: slideOut 0.6s ease forwards; }
        @keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(100%); opacity: 0; } }

        .footer { display: flex; justify-content: space-between; align-items: center; padding: 20px 50px; font-size: 12px; }
        .footer-link { color: #fff; text-decoration: none; margin: 0 5px; }
        .footer-link:hover { color: #dc3545; }

        .social-icons a img { width: 20px; margin-left: 10px; transition: transform 0.3s ease, filter 0.3s ease; }
        .social-icons a:hover img { transform: scale(1.2); filter: brightness(1.5); }

        @media (max-width: 900px) { 
          .hero-content { flex-direction: column; text-align: center; } 
          .login-section { margin-top: 30px; width: 90%; max-width: 360px; } 
        }
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
            {!showForgotPassword ? (
              <>
                <div className="login-tabs">
                  <button className="active">Login</button>
                  <button onClick={goRegister}>Register</button>
                </div>

                <form className="form-scroll" onSubmit={handleLogin}>
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

                  <button type="submit" className="login-button">Login</button>
                </form>

                <div className="forgot-password">
                  <a onClick={toggleForgotPassword}>Forgot password?</a>
                </div>
              </>
            ) : (
              <>
                <div className="login-tabs">
                  <button className="active" onClick={toggleForgotPassword}>← Back</button>
                  <button onClick={goRegister}>Register</button>
                </div>

                <form className="form-scroll" onSubmit={handlePasswordReset}>
                  <div className="form-group">
                    <label>Username</label>
                    <input
                      name="username"
                      type="text"
                      required
                    />
                  </div>

                  <div className="form-group">
                    <label>Security Question</label>
                    <select 
                      name="securityQuestion" 
                      required
                      style={{marginBottom: '5px'}}
                    >
                      <option value="">Select your security question</option>
                      {securityQuestions.map((question, index) => (
                        <option key={index} value={question}>{question}</option>
                      ))}
                    </select>
                    {resetErrors.securityQuestion && <div className="error-text">{resetErrors.securityQuestion}</div>}
                  </div>

                  <div className="form-group">
                    <label>Security Answer<span className="tooltip" title="Answer to your security question">?</span></label>
                    <input
                      name="securityAnswer"
                      type="text"
                      className={resetErrors.securityAnswer ? "error-input" : ""}
                      required
                    />
                    {resetErrors.securityAnswer && <div className="error-text">{resetErrors.securityAnswer}</div>}
                  </div>

                  <div className="form-group">
                    <label>New Password<span className="tooltip" title="8-20 characters with uppercase, lowercase, and number. No special characters">?</span></label>
                    <input
                      name="newPassword"
                      type="password"
                      required
                      className={resetErrors.newPassword ? "error-input" : ""}
                    />
                    {resetErrors.newPassword && <div className="error-text">{resetErrors.newPassword}</div>}
                  </div>

                  <div className="form-group">
                    <label>Confirm Password</label>
                    <input
                      name="confirmPassword"
                      type="password"
                      required
                      className={resetErrors.confirmPassword ? "error-input" : ""}
                    />
                    {resetErrors.confirmPassword && <div className="error-text">{resetErrors.confirmPassword}</div>}
                  </div>

                  {resetError && <div className="error-text">{resetError}</div>}
                  {resetSuccess && <div className="success-text">{resetSuccess}</div>}

                  <button type="submit" className="reset-button">Reset Password</button>
                </form>
              </>
            )}
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