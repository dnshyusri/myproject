import React from 'react';
import '../styles/Skills.css';

const Skills = () => {
  const skills = {
    'Frontend': ['HTML5', 'CSS3', 'JavaScript', 'React', 'Redux', 'Responsive Design'],
    'Backend': ['Node.js', 'Express', 'Python', 'RESTful APIs'],
    'Database': ['MongoDB', 'PostgreSQL', 'MySQL'],
    'Tools': ['Git', 'VS Code', 'npm', 'Webpack', 'Docker']
  };

  return (
    <section id="skills" className="skills">
      <div className="container">
        <h2 className="section-title slide-up">Skills & Technologies</h2>
        <div className="skills-container">
          {Object.entries(skills).map(([category, items], index) => (
            <div key={index} className="skill-category fade-in">
              <h3 className="category-title">{category}</h3>
              <div className="skills-grid">
                {items.map((skill, skillIndex) => (
                  <div key={skillIndex} className="skill-item">
                    {skill}
                  </div>
                ))}
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Skills;