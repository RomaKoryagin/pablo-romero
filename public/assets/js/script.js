// DOM Elements
const navbar = document.querySelector('.navbar');
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');
const navLinks = document.querySelectorAll('.nav-link');
const scrollIndicator = document.querySelector('.scroll-indicator');
const floatingElements = document.querySelectorAll('.floating-element');
const techCarousel = document.querySelector('.tech-carousel');
const prevBtn = document.querySelector('.carousel-prev');
const nextBtn = document.querySelector('.carousel-next');
const contactForm = document.querySelector('.contact-form');

// Loading Animation
window.addEventListener('load', () => {
    const loading = document.createElement('div');
    loading.className = 'loading';
    loading.innerHTML = '<div class="spinner"></div>';
    document.body.appendChild(loading);
    
    setTimeout(() => {
        loading.classList.add('hidden');
        setTimeout(() => {
            loading.remove();
        }, 500);
    }, 1000);
});

// Navbar Scroll Effect
window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Mobile Menu Toggle
hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
    document.body.classList.toggle('no-scroll', navMenu.classList.contains('active'));
    toggleMenuOverlay(navMenu.classList.contains('active'));
});

// Smooth Scroll and close mobile menu for Navigation Links
navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        const targetId = link.getAttribute('href');
        if (targetId && targetId.startsWith('#')) {
            e.preventDefault();
            const targetSection = document.querySelector(targetId);
            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
        hamburger.classList.remove('active');
        navMenu.classList.remove('active');
        document.body.classList.remove('no-scroll');
        toggleMenuOverlay(false);
    });
});

// Mobile menu overlay handling
function toggleMenuOverlay(enable) {
    let overlay = document.querySelector('.menu-overlay');
    if (enable) {
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'menu-overlay';
            document.body.appendChild(overlay);
        }
        // place overlay below navbar but above page
        overlay.classList.add('active');
        overlay.onclick = () => {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
            document.body.classList.remove('no-scroll');
            overlay.classList.remove('active');
            setTimeout(() => overlay && overlay.remove(), 200);
        };
    } else if (overlay) {
        overlay.classList.remove('active');
        setTimeout(() => overlay && overlay.remove(), 200);
    }
}

// Hide scroll indicator when scrolling
window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        scrollIndicator.style.opacity = '0';
    } else {
        scrollIndicator.style.opacity = '1';
    }
});

// Parallax Effect for Floating Elements
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    
    floatingElements.forEach(element => {
        const speed = element.dataset.speed || 0.5;
        const yPos = -(scrolled * speed);
        element.style.transform = `translateY(${yPos}px)`;
    });
});

// Intersection Observer for Animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
            
            // Add staggered animation for service cards
            if (entry.target.classList.contains('service-card')) {
                const cards = entry.target.parentElement.children;
                Array.from(cards).forEach((card, index) => {
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            }
        }
    });
}, observerOptions);

// Observe elements for animation
const animatedElements = document.querySelectorAll('.service-card, .about-content, .contact-content');
animatedElements.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});

// Technologies Carousel
let currentSlide = 0;
const slides = document.querySelectorAll('.tech-slide');
const totalSlides = slides.length;

function showSlide(index) {
    if (index >= totalSlides) currentSlide = 0;
    if (index < 0) currentSlide = totalSlides - 1;
    
    techCarousel.style.transform = `translateX(-${currentSlide * 100}%)`;
}

function nextSlide() {
    currentSlide++;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide--;
    showSlide(currentSlide);
}

// Carousel Event Listeners
nextBtn.addEventListener('click', nextSlide);
prevBtn.addEventListener('click', prevSlide);

// Auto-play carousel
let autoPlayInterval = setInterval(nextSlide, 4000);

// Pause auto-play on hover
techCarousel.addEventListener('mouseenter', () => {
    clearInterval(autoPlayInterval);
});

techCarousel.addEventListener('mouseleave', () => {
    autoPlayInterval = setInterval(nextSlide, 4000);
});

// Touch support for carousel
let touchStartX = 0;
let touchEndX = 0;

techCarousel.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
});

techCarousel.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    if (touchEndX < touchStartX - 50) nextSlide();
    if (touchEndX > touchStartX + 50) prevSlide();
}

// Form Handling
contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(contactForm);
    const data = {
        firstname: formData.get('firstname'),
        lastname: formData.get('lastname'),
        middlename: formData.get('middlename'),
        email: formData.get('email'),
        phoneNumber: formData.get('phoneNumber'),
        telegramID: formData.get('telegramID') || null,
        description: formData.get('description') || null
    };
    
    // Validation
    if (!data.firstname || !data.lastname || !data.middlename || !data.email || !data.phoneNumber) {
        showNotification('Пожалуйста, заполните все обязательные поля', 'error');
        return;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(data.email)) {
        showNotification('Пожалуйста, введите корректный email', 'error');
        return;
    }
    
    // Phone validation
    const phoneRegex = /^\+?[0-9\s\-\(\)]{7,20}$/;
    if (!phoneRegex.test(data.phoneNumber)) {
        showNotification('Пожалуйста, введите корректный номер телефона', 'error');
        return;
    }
    
    // Submit button state
    const submitBtn = contactForm.querySelector('.btn-primary');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Отправка...';
    submitBtn.disabled = true;
    
    try {
        // Send to API
        const response = await fetch('/api/1.0/applications/submit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        if (response.ok) {
            showNotification('Спасибо за вашу заявку! Мы свяжемся с вами в ближайшее время.', 'success');
            contactForm.reset();
        } else {
            const errorData = await response.json().catch(() => ({}));
            showNotification(errorData.message || 'Произошла ошибка при отправке заявки', 'error');
        }
    } catch (error) {
        console.error('Form submission error:', error);
        showNotification('Произошла ошибка при отправке заявки. Попробуйте позже.', 'error');
    } finally {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }
});

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close">&times;</button>
        </div>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${type === 'success' ? 'var(--primary-gold)' : type === 'error' ? 'var(--primary-red)' : '#333'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: var(--shadow-medium);
        z-index: 10000;
        transform: translateX(400px);
        transition: transform 0.3s ease;
        max-width: 300px;
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Close button
    notification.querySelector('.notification-close').addEventListener('click', () => {
        closeNotification(notification);
    });
    
    // Auto close
    setTimeout(() => {
        closeNotification(notification);
    }, 5000);
}

function closeNotification(notification) {
    notification.style.transform = 'translateX(400px)';
    setTimeout(() => {
        notification.remove();
    }, 300);
}

// Button Click Effects
document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        // Create ripple effect
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        `;
        
        this.style.position = 'relative';
        this.style.overflow = 'hidden';
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});

// Add ripple animation to CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Counter Animation for Stats
function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);
    const timer = setInterval(() => {
        start += increment;
        if (start >= target) {
            element.textContent = target + '+';
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(start);
        }
    }, 16);
}

// Trigger counter animation when about section is visible
const aboutSection = document.querySelector('.about');
const statNumbers = document.querySelectorAll('.stat-number');
let countersAnimated = false;

const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !countersAnimated) {
            countersAnimated = true;
            statNumbers.forEach((stat, index) => {
                const targets = [50, 5, 30];
                setTimeout(() => {
                    animateCounter(stat, targets[index]);
                }, index * 200);
            });
        }
    });
}, { threshold: 0.5 });

if (aboutSection) {
    counterObserver.observe(aboutSection);
}

// Typing Effect for Hero Title
function typeWriter(element, text, speed = 100) {
    let i = 0;
    element.innerHTML = '';
    
    function type() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    
    type();
}

// Initialize typing effect after page load
window.addEventListener('load', () => {
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        const originalText = heroTitle.textContent;
        setTimeout(() => {
            typeWriter(heroTitle, originalText, 150);
        }, 1000);
    }
});

// Scroll to Top Button
const scrollTopBtn = document.createElement('button');
scrollTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
scrollTopBtn.className = 'scroll-top-btn';
scrollTopBtn.style.cssText = `
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: var(--gradient-gold);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-medium);
    z-index: 1000;
    font-size: 1.2rem;
`;

document.body.appendChild(scrollTopBtn);

// Show/hide scroll to top button
window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollTopBtn.style.opacity = '1';
        scrollTopBtn.style.visibility = 'visible';
    } else {
        scrollTopBtn.style.opacity = '0';
        scrollTopBtn.style.visibility = 'hidden';
    }
});

// Scroll to top functionality
scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Service Card Hover Effects
document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-15px) scale(1.02)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});

// Add CSS for enhanced hover effects
const hoverStyle = document.createElement('style');
hoverStyle.textContent = `
    .service-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .tech-item:hover {
        transform: translateY(-10px) scale(1.05);
        box-shadow: var(--shadow-gold), 0 20px 40px rgba(255, 215, 0, 0.3);
    }
    
    .contact-item:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: var(--shadow-medium);
    }
    
    .stat-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-light);
    }
    
    .btn:hover {
        transform: translateY(-3px) scale(1.05);
    }
    
    .scroll-top-btn:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-heavy);
    }
`;
document.head.appendChild(hoverStyle);

// Initialize all functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {    
    // Add some interactive elements
    const interactiveElements = document.querySelectorAll('.service-icon, .tech-item, .stat-item');
    interactiveElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            this.style.filter = 'brightness(1.2)';
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.filter = 'brightness(1)';
        });
    });
});

// Performance optimization - Debounce scroll events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Apply debounce to scroll events
const debouncedScroll = debounce(() => {
    // Scroll-based animations here
}, 10);

window.addEventListener('scroll', debouncedScroll);