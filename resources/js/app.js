import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// ==========================================
// Global Functions
// ==========================================

// Toast Notification
window.showToast = function(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 left-1/2 -translate-x-1/2 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-bold animate-fade-in ${
        type === 'success' ? 'bg-green-600' :
            type === 'error' ? 'bg-red-600' :
                type === 'warning' ? 'bg-yellow-600' :
                    'bg-blue-600'
    }`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('opacity-0', 'transition-opacity', 'duration-500');
        setTimeout(() => toast.remove(), 500);
    }, 3000);
};

// Loading Overlay
window.showLoading = function() {
    const overlay = document.createElement('div');
    overlay.id = 'loading-overlay';
    overlay.className = 'fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center';
    overlay.innerHTML = `
        <div class="bg-white rounded-lg p-8 flex flex-col items-center gap-4">
            <div class="spinner"></div>
            <p class="text-gray-700 font-bold">در حال بارگذاری...</p>
        </div>
    `;
    document.body.appendChild(overlay);
};

window.hideLoading = function() {
    const overlay = document.getElementById('loading-overlay');
    if (overlay) overlay.remove();
};

// Format Number (Persian)
window.formatNumber = function(number) {
    return new Intl.NumberFormat('fa-IR').format(number);
};

// Scroll to Top
window.scrollToTop = function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

// ==========================================
// Cart Functions
// ==========================================

window.addToCart = function(productId, quantity = 1) {
    showLoading();

    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity })
    })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                updateCartCount(data.cartCount);
                showToast('محصول به سبد خرید اضافه شد', 'success');
            } else {
                showToast('خطا در افزودن محصول', 'error');
            }
        })
        .catch(error => {
            hideLoading();
            showToast('خطا در برقراری ارتباط', 'error');
            console.error('Error:', error);
        });
};

window.updateCartCount = function(count) {
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
        cartCountElement.classList.add('animate-pulse');
        setTimeout(() => {
            cartCountElement.classList.remove('animate-pulse');
        }, 500);
    }
};

// ==========================================
// Favorite Functions
// ==========================================

window.toggleFavorite = function(productId) {
    fetch(`/user/favorites/toggle/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                // Reload page to update favorite icon
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast('خطا در انجام عملیات', 'error');
            }
        })
        .catch(error => {
            showToast('خطا در برقراری ارتباط', 'error');
            console.error('Error:', error);
        });
};

// ==========================================
// Search Functions
// ==========================================

// Live Search (Debounced)
let searchTimeout;
window.liveSearch = function(input) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const query = input.value.trim();
        if (query.length >= 3) {
            // Perform search
            window.location.href = `/products?search=${encodeURIComponent(query)}`;
        }
    }, 500);
};

// ==========================================
// Image Gallery & Zoom
// ==========================================

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Image Zoom on Product Page
    initializeImageZoom();

    // Initialize Sliders
    initializeSliders();

    // Lazy Loading Images
    initializeLazyLoading();

    // Back to Top Button
    initializeBackToTop();

    // Form Validation
    initializeFormValidation();
});

function initializeImageZoom() {
    const container = document.getElementById('main-image-container');
    if (!container) return;

    const img = document.getElementById('main-image');
    const lens = document.getElementById('zoom-lens');
    const result = document.getElementById('zoom-result');
    const zoomImg = document.getElementById('zoom-image');

    container.addEventListener('mouseenter', () => {
        lens.classList.remove('hidden');
        result.classList.remove('hidden');
    });

    container.addEventListener('mouseleave', () => {
        lens.classList.add('hidden');
        result.classList.add('hidden');
    });

    container.addEventListener('mousemove', (e) => {
        const rect = container.getBoundingClientRect();
        let x = e.clientX - rect.left;
        let y = e.clientY - rect.top;

        x = Math.max(lens.offsetWidth / 2, Math.min(x, rect.width - lens.offsetWidth / 2));
        y = Math.max(lens.offsetHeight / 2, Math.min(y, rect.height - lens.offsetHeight / 2));

        lens.style.left = (x - lens.offsetWidth / 2) + 'px';
        lens.style.top = (y - lens.offsetHeight / 2) + 'px';

        const cx = result.offsetWidth / lens.offsetWidth;
        const cy = result.offsetHeight / lens.offsetHeight;

        zoomImg.style.width = (img.width * cx) + 'px';
        zoomImg.style.height = (img.height * cy) + 'px';
        zoomImg.style.left = -(x * cx - result.offsetWidth / 2) + 'px';
        zoomImg.style.top = -(y * cy - result.offsetHeight / 2) + 'px';
    });
}

function initializeSliders() {
    // Auto-play sliders
    const sliders = document.querySelectorAll('[data-slider]');
    sliders.forEach(slider => {
        const interval = slider.dataset.interval || 5000;
        setInterval(() => {
            const nextButton = slider.querySelector('[data-next]');
            if (nextButton) nextButton.click();
        }, interval);
    });
}

function initializeLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));
}

function initializeBackToTop() {
    const backToTop = document.createElement('button');
    backToTop.id = 'back-to-top';
    backToTop.className = 'fixed left-4 bottom-4 w-12 h-12 bg-blue-600 text-white rounded-full shadow-lg hidden hover:bg-blue-700 transition z-40';
    backToTop.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTop.onclick = scrollToTop;
    document.body.appendChild(backToTop);

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTop.classList.remove('hidden');
        } else {
            backToTop.classList.add('hidden');
        }
    });
}

function initializeFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('border-red-500');
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                e.preventDefault();
                showToast('لطفا تمام فیلدهای الزامی را پر کنید', 'error');
            }
        });
    });
}

// ==========================================
// Utility Functions
// ==========================================

// Copy to Clipboard
window.copyToClipboard = function(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('کپی شد', 'success');
    }).catch(() => {
        showToast('خطا در کپی کردن', 'error');
    });
};

// Share
window.shareProduct = function(title, url) {
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        }).catch(err => console.log('Error sharing:', err));
    } else {
        copyToClipboard(url);
    }
};

// Print
window.printPage = function() {
    window.print();
};

// Console Log for Development
if (import.meta.env.DEV) {
    console.log('%c🛒 فروشگاه آنلاین', 'color: #3b82f6; font-size: 24px; font-weight: bold;');
    console.log('%cDeveloped with ❤️ using Laravel & Tailwind CSS', 'color: #6b7280;');
}
