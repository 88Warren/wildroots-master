// Modern JavaScript for Wild Roots Kitchen & Bar
// Using ES6+ features and modern best practices

// Prevent multiple initializations
if (typeof window.WildRootsApp !== 'undefined') {
    console.log('WildRootsApp already initialized');
} else {

class WildRootsApp {
    constructor() {
        this.navbar = document.getElementById('navbar');
        this.navToggle = document.querySelector('.nav-toggle');
        this.navMenu = document.querySelector('.nav-menu');
        this.navLinks = document.querySelectorAll('.nav-link');
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.setupIntersectionObserver();
        this.setupSmoothScrolling();
        this.setupAccessibility();
    }
    
    setupEventListeners() {
        // Mobile navigation toggle
        if (this.navToggle) {
            this.navToggle.addEventListener('click', this.toggleMobileNav.bind(this));
        }
        
        // Close mobile nav when clicking on links
        this.navLinks.forEach(link => {
            link.addEventListener('click', this.closeMobileNav.bind(this));
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', this.handleNavbarScroll.bind(this));
        
        // Handle escape key for mobile nav
        document.addEventListener('keydown', this.handleKeydown.bind(this));
        
        // Handle window resize
        window.addEventListener('resize', this.handleResize.bind(this));
    }
    
    toggleMobileNav() {
        const isExpanded = this.navToggle.getAttribute('aria-expanded') === 'true';
        
        this.navToggle.setAttribute('aria-expanded', !isExpanded);
        
        // Prevent body scroll when menu is open
        if (!isExpanded) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
        
        // Focus management
        if (!isExpanded) {
            // Focus first nav link when menu opens
            setTimeout(() => {
                const firstLink = this.navMenu.querySelector('.nav-link');
                if (firstLink) firstLink.focus();
            }, 100);
        }
    }
    
    closeMobileNav() {
        this.navToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }
    
    handleNavbarScroll() {
        // Throttle scroll events for better performance
        if (!this.scrollTimeout) {
            this.scrollTimeout = setTimeout(() => {
                const scrolled = window.pageYOffset > 50;
                this.navbar.classList.toggle('scrolled', scrolled);
                this.scrollTimeout = null;
            }, 10);
        }
    }
    
    handleKeydown(event) {
        // Close mobile nav with Escape key
        if (event.key === 'Escape' && this.navToggle.getAttribute('aria-expanded') === 'true') {
            this.closeMobileNav();
            this.navToggle.focus();
        }
    }
    
    handleResize() {
        // Close mobile nav on resize to prevent layout issues
        if (window.innerWidth > 768) {
            this.closeMobileNav();
        }
    }
    
    setupIntersectionObserver() {
        // Animate elements when they come into view
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);
        
        // Observe elements that should animate in
        const animateElements = document.querySelectorAll('.service-card, .support-card, .client-card');
        animateElements.forEach(el => {
            observer.observe(el);
        });
    }
    
    setupSmoothScrolling() {
        // Enhanced smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"], a[href^="/#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                const href = anchor.getAttribute('href');
                
                // Handle cross-page navigation
                if (href.startsWith('/#')) {
                    const hash = href.substring(1); // Remove the leading /
                    if (window.location.pathname !== '/') {
                        // Navigate to home page with hash
                        window.location.href = '/' + hash;
                        return;
                    }
                    // If already on home page, treat as normal anchor
                    e.preventDefault();
                    const target = document.querySelector(hash);
                    if (target) {
                        this.scrollToTarget(target);
                    }
                } else {
                    // Handle same-page anchor links
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        this.scrollToTarget(target);
                    }
                }
            });
        });
        
        // Handle hash on page load (for direct links or cross-page navigation)
        if (window.location.hash) {
            setTimeout(() => {
                const target = document.querySelector(window.location.hash);
                if (target) {
                    this.scrollToTarget(target);
                }
            }, 100);
        }
    }
    
    scrollToTarget(target) {
        const headerOffset = 80;
        const elementPosition = target.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
        
        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
        
        // Close mobile nav if open
        this.closeMobileNav();
    }
    
    setupAccessibility() {
        // Improve focus management
        this.setupFocusTrap();
        this.setupSkipLinks();
    }
    
    setupFocusTrap() {
        // Trap focus within mobile navigation when open
        const focusableElements = this.navMenu.querySelectorAll(
            'a, button, [tabindex]:not([tabindex="-1"])'
        );
        
        if (focusableElements.length === 0) return;
        
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];
        
        this.navMenu.addEventListener('keydown', (e) => {
            if (e.key !== 'Tab') return;
            
            if (this.navToggle.getAttribute('aria-expanded') !== 'true') return;
            
            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else {
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        });
    }
    
    setupSkipLinks() {
        // Ensure skip links work properly
        const skipLink = document.querySelector('.skip-link');
        if (skipLink) {
            skipLink.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(skipLink.getAttribute('href'));
                if (target) {
                    target.focus();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }
    }
}

// Utility functions
const utils = {
    // Debounce function for performance optimization
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    // Check if element is in viewport
    isInViewport(element) {
        const rect = element.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    },
    
    // Animate counter numbers
    animateCounter(element, target, duration = 2000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            element.textContent = Math.floor(current);
            
            if (current >= target) {
                element.textContent = target;
                clearInterval(timer);
            }
        }, 16);
    }
};

// Enhanced form handling (if contact forms are present)
class FormHandler {
    constructor() {
        this.forms = document.querySelectorAll('form');
        this.init();
    }
    
    init() {
        this.forms.forEach(form => {
            form.addEventListener('submit', this.handleSubmit.bind(this));
            
            // Add real-time validation
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('blur', this.validateField.bind(this));
                input.addEventListener('input', this.clearErrors.bind(this));
            });
        });
    }
    
    handleSubmit(e) {
        e.preventDefault();
        const form = e.target;
        
        if (this.validateForm(form)) {
            this.submitForm(form);
        }
    }
    
    validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        
        inputs.forEach(input => {
            if (!this.validateField({ target: input })) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    validateField(e) {
        const field = e.target;
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';
        
        // Required field validation
        if (field.hasAttribute('required') && !value) {
            errorMessage = 'This field is required';
            isValid = false;
        }
        
        // Email validation
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                errorMessage = 'Please enter a valid email address';
                isValid = false;
            }
        }
        
        // Phone validation - allow UK numbers starting with 0
        if (field.type === 'tel' && value) {
            const cleanPhone = value.replace(/[\s\-\(\)]/g, '');
            const phoneRegex = /^(\+44[1-9]\d{8,9}|0[1-9]\d{8,9}|\d{10,15})$/;
            if (!phoneRegex.test(cleanPhone)) {
                errorMessage = 'Please enter a valid phone number';
                isValid = false;
            }
        }
        
        this.showFieldError(field, errorMessage);
        return isValid;
    }
    
    showFieldError(field, message) {
        // Remove existing error
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Add new error if message exists
        if (message) {
            const errorElement = document.createElement('div');
            errorElement.className = 'field-error';
            errorElement.textContent = message;
            errorElement.style.color = '#e74c3c';
            errorElement.style.fontSize = '0.875rem';
            errorElement.style.marginTop = '0.25rem';
            
            field.parentNode.appendChild(errorElement);
            field.setAttribute('aria-invalid', 'true');
            field.setAttribute('aria-describedby', errorElement.id = `error-${Date.now()}`);
        } else {
            field.removeAttribute('aria-invalid');
            field.removeAttribute('aria-describedby');
        }
    }
    
    clearErrors(e) {
        const field = e.target;
        const errorElement = field.parentNode.querySelector('.field-error');
        if (errorElement && field.value.trim()) {
            errorElement.remove();
            field.removeAttribute('aria-invalid');
            field.removeAttribute('aria-describedby');
        }
    }
    
    async submitForm(form) {
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        
        // Show loading state
        submitButton.textContent = 'Sending...';
        submitButton.disabled = true;
        
        try {
            const formData = new FormData(form);
            const response = await fetch(form.action || window.location.href, {
                method: 'POST',
                body: formData
            });
            
            if (response.ok) {
                this.showSuccessMessage(form);
                form.reset();
            } else {
                throw new Error('Network response was not ok');
            }
        } catch (error) {
            this.showErrorMessage(form, 'Sorry, there was an error sending your message. Please try again.');
        } finally {
            // Restore button state
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    }
    
    showSuccessMessage(form) {
        const message = document.createElement('div');
        message.className = 'form-message success';
        message.textContent = 'Thank you! Your message has been sent successfully.';
        message.style.cssText = `
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            border: 1px solid #c3e6cb;
        `;
        
        form.appendChild(message);
        setTimeout(() => message.remove(), 5000);
    }
    
    showErrorMessage(form, text) {
        const message = document.createElement('div');
        message.className = 'form-message error';
        message.textContent = text;
        message.style.cssText = `
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            border: 1px solid #f5c6cb;
        `;
        
        form.appendChild(message);
        setTimeout(() => message.remove(), 5000);
    }
}

// Performance monitoring
class PerformanceMonitor {
    constructor() {
        this.metrics = {};
        this.init();
    }
    
    init() {
        // Monitor page load performance
        window.addEventListener('load', () => {
            setTimeout(() => {
                this.collectMetrics();
            }, 0);
        });
    }
    
    collectMetrics() {
        if ('performance' in window) {
            const navigation = performance.getEntriesByType('navigation')[0];
            
            this.metrics = {
                loadTime: navigation.loadEventEnd - navigation.loadEventStart,
                domContentLoaded: navigation.domContentLoadedEventEnd - navigation.domContentLoadedEventStart,
                firstPaint: this.getFirstPaint(),
                largestContentfulPaint: this.getLCP()
            };
            
            // Log metrics in development
            if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
                console.log('Performance Metrics:', this.metrics);
            }
        }
    }
    
    getFirstPaint() {
        const paintEntries = performance.getEntriesByType('paint');
        const firstPaint = paintEntries.find(entry => entry.name === 'first-paint');
        return firstPaint ? firstPaint.startTime : null;
    }
    
    getLCP() {
        return new Promise((resolve) => {
            new PerformanceObserver((entryList) => {
                const entries = entryList.getEntries();
                const lastEntry = entries[entries.length - 1];
                resolve(lastEntry.startTime);
            }).observe({ entryTypes: ['largest-contentful-paint'] });
        });
    }
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize main app
    window.WildRootsApp = new WildRootsApp();
    
    // Initialize form handling
    new FormHandler();
    
    // Initialize performance monitoring
    new PerformanceMonitor();
    
    // Add animation classes for CSS
    const style = document.createElement('style');
    style.textContent = `
        .service-card,
        .support-card,
        .client-card {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }
        
        .service-card.animate-in,
        .support-card.animate-in,
        .client-card.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
    `;
    document.head.appendChild(style);
});

} // End of WildRootsApp initialization check

// Service Worker registration for PWA capabilities (optional)
// Commented out since sw.js doesn't exist
// if ('serviceWorker' in navigator) {
//     window.addEventListener('load', () => {
//         navigator.serviceWorker.register('/sw.js')
//             .then(registration => {
//                 console.log('SW registered: ', registration);
//             })
//             .catch(registrationError => {
//                 console.log('SW registration failed: ', registrationError);
//             });
//     });
// }