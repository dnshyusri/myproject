import React from 'react';
import '../styles/Hero.css';

const Hero = () => {
  return (
    <section id="hero" className="hero">
      <div className="container hero-container">
        <div className="hero-content">
          <h1 className="hero-title slide-up">
            Hi, I'm <span className="highlight">Danish</span>
          </h1>
          <p className="hero-subtitle slide-up">
            A passionate Full Stack Developer building digital experiences
          </p>
          <div className="hero-buttons fade-in">
            <button className="primary-btn">View My Work</button>
            <button className="secondary-btn">Contact Me</button>
          </div>
        </div>
        <div className="hero-image fade-in">
          {/* You can add your image here */}
          <div className="placeholder-image"></div>
        </div>
      </div>
    </section>
  );
};

export default Hero;