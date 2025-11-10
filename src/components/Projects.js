import React from 'react';
import '../styles/Projects.css';

const Projects = () => {
  const projects = [
    {
      title: 'Project 1',
      description: 'A modern web application built with React and Node.js',
      image: 'placeholder',
      tags: ['React', 'Node.js', 'MongoDB'],
      links: {
        github: '#',
        live: '#'
      }
    },
    {
      title: 'Project 2',
      description: 'Mobile-responsive e-commerce platform',
      image: 'placeholder',
      tags: ['React', 'Express', 'PostgreSQL'],
      links: {
        github: '#',
        live: '#'
      }
    },
    {
      title: 'Project 3',
      description: 'Real-time chat application',
      image: 'placeholder',
      tags: ['React', 'Socket.io', 'Node.js'],
      links: {
        github: '#',
        live: '#'
      }
    }
  ];

  return (
    <section id="projects" className="projects">
      <div className="container">
        <h2 className="section-title slide-up">My Projects</h2>
        <div className="projects-grid">
          {projects.map((project, index) => (
            <div key={index} className="project-card fade-in">
              <div className="project-image">
                <div className="placeholder-project"></div>
              </div>
              <div className="project-content">
                <h3 className="project-title">{project.title}</h3>
                <p className="project-description">{project.description}</p>
                <div className="project-tags">
                  {project.tags.map((tag, tagIndex) => (
                    <span key={tagIndex} className="tag">{tag}</span>
                  ))}
                </div>
                <div className="project-links">
                  <a href={project.links.github} className="project-link">GitHub</a>
                  <a href={project.links.live} className="project-link">Live Demo</a>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Projects;