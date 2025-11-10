import React from 'react';
import '../styles/Footer.css';

const Footer = () => {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="footer">
      <div className="container footer-container">
        <div className="footer-content">
          <p className="copyright">
            © {currentYear} Your Name. All rights reserved.
          </p>
          <div className="social-links">
            <a href="https://github.com/yourusername" className="social-link">
              GitHub
            </a>
            <a href="https://linkedin.com/in/yourprofile" className="social-link">
              LinkedIn
            </a>
            <a href="https://twitter.com/yourusername" className="social-link">
              Twitter
            </a>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;