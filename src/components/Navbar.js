import React, { useState } from 'react';
import '../styles/Navbar.css';

const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false);

  const toggleMenu = () => {
    setIsOpen(!isOpen);
  };

  const scrollToSection = (sectionId, e) => {
    e.preventDefault();
    const element = document.getElementById(sectionId);
    if (element) {
      const navHeight = document.querySelector('.navbar').offsetHeight;
      const elementPosition = element.offsetTop;
      window.scrollTo({
        top: elementPosition - navHeight,
        behavior: 'smooth'
      });
      setIsOpen(false); // Close mobile menu after clicking
    }
  };

  return (
    <nav className="navbar">
      <div className="container nav-container">
        <a href="#hero" className="nav-logo" onClick={(e) => scrollToSection('hero', e)}>Portfolio</a>
        <div className={`nav-menu ${isOpen ? 'active' : ''}`}>
          <a href="#about" className="nav-link" onClick={(e) => scrollToSection('about', e)}>About</a>
          <a href="#projects" className="nav-link" onClick={(e) => scrollToSection('projects', e)}>Projects</a>
          <a href="#skills" className="nav-link" onClick={(e) => scrollToSection('skills', e)}>Skills</a>
          <a href="#contact" className="nav-link" onClick={(e) => scrollToSection('contact', e)}>Contact</a>
        </div>
        <button className="nav-toggle" onClick={toggleMenu}>
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </nav>
  );
};

export default Navbar;