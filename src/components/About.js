import React from 'react';
import '../styles/About.css';

const About = () => {
  return (
    <section id="about" className="about">
      <div className="container about-container">
        <h2 className="section-title slide-up">About Me</h2>
        <div className="about-content">
          <div className="about-text">
            <p>
              Highly motivated Computer Science graduate specializing in Software Technology. 
              Proven ability in web development and software testing. Seeking a Graduate Talent 
              opportunity to leverage strong analytical skills, rapid prototyping, and team 
              collaboration to drive organizational efficiency and innovation.

            </p>
            <p>
              My journey in web development started with a curiosity about how
              things work on the internet, and it has evolved into a professional
              career where I continuously learn and adapt to new technologies.
            </p>
          </div>
          <div className="about-stats">
            <div className="stat-item fade-in">
              <span className="stat-number">2+</span>
              <span className="stat-label">Years Experience</span>
            </div>
            <div className="stat-item fade-in">
              <span className="stat-number">10+</span>
              <span className="stat-label">Projects Completed</span>
            </div>
            <div className="stat-item fade-in">
              <span className="stat-number">5+</span>
              <span className="stat-label">Happy Clients</span>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default About;