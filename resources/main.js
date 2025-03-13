/**
 * ShadowrunNexus - A MediaWiki skin blending cyberpunk and magical aesthetics
 */

;(() => {
    // Wait for document to be ready
    document.addEventListener("DOMContentLoaded", () => {
      // Add cyberpunk glitch effect to links on hover
      const addGlitchEffect = () => {
        const headings = document.querySelectorAll(".firstHeading, .sr-nexus-sitename")
  
        headings.forEach((heading) => {
          heading.addEventListener("mouseover", () => {
            heading.classList.add("glitch-effect")
          })
  
          heading.addEventListener("mouseout", () => {
            heading.classList.remove("glitch-effect")
          })
        })
      }
  
      // Add responsive menu toggle for mobile
      const addMobileNavToggle = () => {
        const header = document.getElementById("sr-nexus-header")
  
        if (!header) return
  
        const navToggle = document.createElement("button")
        navToggle.className = "sr-nexus-nav-toggle"
        navToggle.setAttribute("aria-label", "Toggle navigation")
        navToggle.innerHTML = "<span></span><span></span><span></span>"
  
        const navigation = document.getElementById("sr-nexus-navigation")
  
        if (navigation) {
          header.insertBefore(navToggle, navigation)
  
          navToggle.addEventListener("click", () => {
            navigation.classList.toggle("sr-nexus-nav-open")
            navToggle.classList.toggle("sr-nexus-nav-toggle-open")
  
            const isExpanded = navigation.classList.contains("sr-nexus-nav-open")
            navToggle.setAttribute("aria-expanded", isExpanded ? "true" : "false")
          })
        }
      }
  
      // Add cyberpunk cursor trail effect
      const addCursorTrail = () => {
        const trailContainer = document.createElement("div")
        trailContainer.className = "sr-nexus-cursor-trail"
        document.body.appendChild(trailContainer)
  
        const trail = []
        const trailLength = 5
  
        for (let i = 0; i < trailLength; i++) {
          const dot = document.createElement("div")
          dot.className = "sr-nexus-cursor-dot"
          trailContainer.appendChild(dot)
          trail.push(dot)
        }
  
        document.addEventListener("mousemove", (e) => {
          const x = e.clientX
          const y = e.clientY
  
          trail.forEach((dot, index) => {
            setTimeout(() => {
              dot.style.left = x + "px"
              dot.style.top = y + "px"
              dot.style.opacity = 1 - index / trailLength
              dot.style.transform = `scale(${1 - index / trailLength})`
            }, index * 50)
          })
        })
      }
  
      // Initialize all features
      const init = () => {
        addGlitchEffect()
        addMobileNavToggle()
  
        // Only add cursor trail on non-mobile devices
        if (window.innerWidth > 768) {
          addCursorTrail()
        }
  
        // Add CSS class to body when JavaScript is enabled
        document.body.classList.remove("client-nojs")
        document.body.classList.add("client-js")
      }
  
      // Run initialization
      init()
    })
  })()
  
  