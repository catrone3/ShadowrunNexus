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
  
      // Fix edit section brackets size
      const fixEditSectionBrackets = () => {
        const editSections = document.querySelectorAll(".mw-editsection")
  
        editSections.forEach((section) => {
          // Add a class to help with styling
          section.classList.add("sr-nexus-fixed-edit")
  
          // Force inline style on brackets and dividers
          const brackets = section.querySelectorAll(".mw-editsection-bracket")
          const dividers = section.querySelectorAll(".mw-editsection-divider")
          const links = section.querySelectorAll("a")
  
          brackets.forEach((bracket) => {
            bracket.style.fontSize = "0.75rem"
            bracket.style.color = "#a0a0a0"
            bracket.style.opacity = "0.5"
            bracket.style.fontWeight = "normal"
          })
  
          dividers.forEach((divider) => {
            divider.style.fontSize = "0.75rem"
            divider.style.color = "#a0a0a0"
            divider.style.opacity = "0.5"
            divider.style.fontWeight = "normal"
          })
  
          links.forEach((link) => {
            link.style.fontSize = "0.75rem"
            link.style.color = "#a0a0a0"
            link.style.backgroundColor = "rgba(0, 0, 0, 0.2)"
            link.style.padding = "0.1rem 0.3rem"
            link.style.borderRadius = "3px"
            link.style.margin = "0 0.1rem"
            link.style.display = "inline-block"
            link.style.fontWeight = "normal"
  
            // Add hover effect with event listeners
            link.addEventListener("mouseover", () => {
              link.style.color = "#0099cc"
              link.style.backgroundColor = "rgba(0, 0, 0, 0.3)"
            })
  
            link.addEventListener("mouseout", () => {
              link.style.color = "#a0a0a0"
              link.style.backgroundColor = "rgba(0, 0, 0, 0.2)"
            })
          })
  
          // Set the entire section to be smaller and superscript
          section.style.fontSize = "0.75rem"
          section.style.verticalAlign = "super"
          section.style.lineHeight = "1"
          section.style.opacity = "0.7"
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
  
      // Run the fix
      fixEditSectionBrackets()
  
      // Also run it after a short delay to catch any elements that might load later
      setTimeout(fixEditSectionBrackets, 1000)
  
      // Run initialization
      init()
    })
  })()
  
  