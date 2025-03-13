/**
 * ShadowrunNexus - A MediaWiki skin blending cyberpunk and magical aesthetics
 */

(function() {
    'use strict';
    
    // Add cyberpunk glitch effect to headings on hover
    function addGlitchEffect() {
      const headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
      
      headings.forEach(heading => {
        heading.addEventListener('mouseenter', () => {
          heading.classList.add('sr-glitch-active');
        });
        
        heading.addEventListener('mouseleave', () => {
          heading.classList.remove('sr-glitch-active');
        });
      });
    }
    
    // Add magic glow effect to links on hover
    function addMagicGlowEffect() {
      const links = document.querySelectorAll('#bodyContent a');
      
      links.forEach(link => {
        link.addEventListener('mouseenter', () => {
          link.classList.add('sr-magic-glow');
        });
        
        link.addEventListener('mouseleave', () => {
          link.classList.remove('sr-magic-glow');
        });
      });
    }
    
    // Add cyberpunk terminal effect to code blocks
    function addTerminalEffect() {
      const codeBlocks = document.querySelectorAll('pre');
      
      codeBlocks.forEach(block => {
        // Add a blinking cursor at the end of the code block
        const cursor = document.createElement('span');
        cursor.classList.add('sr-terminal-cursor');
        block.appendChild(cursor);
        
        // Add a "typed" effect when the code block comes into view
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              block.classList.add('sr-terminal-typing');
              observer.unobserve(block);
            }
          });
        }, { threshold: 0.5 });
        
        observer.observe(block);
      });
    }
    
    // Add parallax effect to magic rune decorations
    function addParallaxEffect() {
      const body = document.querySelector('.sr-nexus-body');
      if (!body) return;
      
      document.addEventListener('mousemove', (e) => {
        const x = e.clientX / window.innerWidth;
        const y = e.clientY / window.innerHeight;
        
        const offsetX = (x - 0.5) * 20;
        const offsetY = (y - 0.5) * 20;
        
        // Use CSS custom properties to apply the transform
        body.style.setProperty('--rune-offset-x', `${offsetX}px`);
        body.style.setProperty('--rune-offset-y', `${offsetY}px`);
      });
    }
    
    // Add neon flicker effect to neon elements
    function addNeonFlickerEffect() {
      const neonElements = document.querySelectorAll('.sr-nexus-logo-image, .sr-nexus-sitename');
      
      neonElements.forEach(element => {
        setInterval(() => {
          if (Math.random() > 0.97) {
            element.classList.add('sr-neon-flicker');
            setTimeout(() => {
              element.classList.remove('sr-neon-flicker');
            }, 100 + Math.random() * 100);
          }
        }, 1000);
      });
    }
    
    // Initialize all effects when the DOM is ready
    function initialize() {
      addGlitchEffect();
      addMagicGlowEffect();
      addTerminalEffect();
      addParallaxEffect();
      addNeonFlickerEffect();
      
      // Make collapsible elements work
      if (typeof mw !== 'undefined' && typeof mw.hook !== 'undefined') {
        mw.hook('wikipage.content').add(function($content) {
          if (typeof mw.loader !== 'undefined') {
            mw.loader.using('jquery.makeCollapsible', function() {
              $content.find('.mw-collapsible').makeCollapsible();
            });
          }
        });
      }
    }
    
    // Run initialization when the document is ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initialize);
    } else {
      initialize();
    }
  })();
  