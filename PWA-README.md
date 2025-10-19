# 🚀 PWA (Progressive Web App) Setup for Laravel Blade

This project includes a comprehensive PWA implementation with TailwindCSS integration.

## 📋 Features

### ✅ **PWA Core Features**
- **Service Worker**: Advanced caching strategies and offline support
- **Web App Manifest**: Complete app configuration with Persian RTL support
- **Installation Prompts**: Beautiful, user-friendly install prompts
- **Offline Support**: Full offline functionality with custom offline page
- **Push Notifications**: Real-time notifications with action buttons
- **Background Sync**: Sync data when connection is restored

### ✅ **TailwindCSS Integration**
- **Optimized Build**: Fast, efficient builds with PWA support
- **PWA Utilities**: Custom Tailwind classes for PWA components
- **Responsive Design**: Mobile-first design with PWA optimizations
- **Performance**: Optimized CSS with tree-shaking and minification

### ✅ **Professional UI/UX**
- **Persian RTL Support**: Complete right-to-left layout support
- **Modern Design**: Beautiful, professional interface
- **Touch Optimized**: Perfect for mobile devices
- **Accessibility**: WCAG compliant with proper focus management

## 🛠 Installation & Setup

### 1. **Install Dependencies**
```bash
npm install
```

### 2. **Build for Production**
```bash
# Standard build
npm run build

# PWA optimized build
npm run pwa:build

# Clean and rebuild
npm run rebuild
```

### 3. **Development**
```bash
# Start development server
npm run dev

# Test PWA features
npm run pwa:test
```

## 📁 File Structure

```
├── public/
│   ├── sw.js                    # Service Worker
│   ├── manifest.json            # PWA Manifest
│   ├── browserconfig.xml        # Microsoft Tiles
│   ├── offline.html             # Offline page
│   ├── pwa-test.html            # PWA testing suite
│   └── build/                   # Built assets
├── resources/
│   ├── css/
│   │   ├── app.css              # Main TailwindCSS file
│   │   └── pwa.css              # PWA-specific styles
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php     # Main layout with PWA integration
│       └── components/
│           └── pwa/
│               └── install-prompt.blade.php
├── scripts/
│   └── pwa-build.js             # PWA build optimization script
├── tailwind.config.js           # TailwindCSS configuration
├── vite.config.js               # Vite configuration
└── package.json                 # Dependencies and scripts
```

## 🎯 Available Scripts

| Script | Description |
|--------|-------------|
| `npm run dev` | Start development server |
| `npm run build` | Build for production |
| `npm run build:pwa` | PWA optimized build |
| `npm run rebuild` | Clean and rebuild |
| `npm run pwa:build` | Build with PWA optimization |
| `npm run pwa:test` | Test PWA features |
| `npm run clean` | Clean build directory |
| `npm run preview` | Preview production build |

## 🔧 Configuration

### **TailwindCSS Configuration**
The `tailwind.config.js` includes:
- PWA-specific content paths
- Custom PWA utilities and components
- Persian font support
- PWA-specific animations and keyframes
- Custom color palette for PWA elements

### **Vite Configuration**
The `vite.config.js` includes:
- PWA-optimized build settings
- Terser minification
- Chunk splitting for better caching
- Asset optimization

### **Service Worker**
The `public/sw.js` includes:
- Multiple caching strategies
- Offline fallbacks
- Background sync
- Push notifications
- Cache management

## 🎨 PWA TailwindCSS Classes

### **Core PWA Classes**
```css
.pwa-app              /* Main PWA container */
.pwa-header           /* Sticky header with backdrop blur */
.pwa-main             /* Main content area */
.pwa-footer           /* Footer with auto margin */
```

### **Touch Interactions**
```css
.pwa-touchable        /* Touch-optimized elements */
.pwa-touch-manipulation /* Touch manipulation */
.pwa-touch-pan-x      /* Horizontal pan only */
.pwa-touch-pan-y      /* Vertical pan only */
```

### **Loading States**
```css
.pwa-loading          /* Loading skeleton */
.pwa-skeleton         /* Shimmer effect */
```

### **Notifications**
```css
.pwa-notification     /* Notification container */
.pwa-notification-success /* Success notification */
.pwa-notification-error   /* Error notification */
.pwa-notification-warning /* Warning notification */
.pwa-notification-info    /* Info notification */
```

### **Install Prompts**
```css
.pwa-install-prompt   /* Install prompt container */
.pwa-install-prompt-container /* Prompt wrapper */
```

### **Status Indicators**
```css
.pwa-offline-indicator /* Offline status */
.pwa-status-online    /* Online status */
.pwa-status-offline   /* Offline status */
.pwa-status-syncing   /* Syncing status */
.pwa-status-error     /* Error status */
```

### **Safe Areas**
```css
.pwa-safe-area-all    /* All safe areas */
.pwa-safe-area-top    /* Top safe area */
.pwa-safe-area-bottom /* Bottom safe area */
.pwa-safe-area-left   /* Left safe area */
.pwa-safe-area-right  /* Right safe area */
```

### **Responsive Utilities**
```css
.pwa-mobile-only      /* Mobile only */
.pwa-desktop-only     /* Desktop only */
.pwa-tablet-only      /* Tablet only */
.pwa-mobile-hidden    /* Hidden on mobile */
.pwa-desktop-hidden   /* Hidden on desktop */
```

### **Animation Utilities**
```css
.pwa-fade-in          /* Fade in animation */
.pwa-slide-in-up      /* Slide in from bottom */
.pwa-slide-in-right   /* Slide in from right */
.pwa-slide-in-left    /* Slide in from left */
.pwa-scale-in         /* Scale in animation */
.pwa-bounce-in        /* Bounce in animation */
```

## 🧪 Testing PWA Features

### **1. PWA Test Suite**
Visit `/pwa-test.html` to test:
- Service Worker registration
- Manifest validation
- PWA features support
- Performance metrics
- Cache management

### **2. Offline Testing**
Visit `/offline` to test:
- Offline page functionality
- Connection status monitoring
- Auto-redirect when online

### **3. Installation Testing**
- Test install prompts on mobile devices
- Verify app shortcuts work
- Check notification permissions

## 📱 Browser Support

### **Full PWA Support**
- Chrome 68+
- Firefox 70+
- Safari 11.1+
- Edge 79+

### **Partial Support**
- iOS Safari 11.1+ (limited features)
- Samsung Internet 7.0+

## 🚀 Deployment

### **1. Build for Production**
```bash
npm run pwa:build
```

### **2. Deploy Files**
Ensure these files are deployed:
- `public/sw.js`
- `public/manifest.json`
- `public/browserconfig.xml`
- `public/offline.html`
- `public/build/` (all built assets)

### **3. Server Configuration**
- Enable HTTPS (required for PWA)
- Set proper MIME types
- Configure caching headers

## 🔍 Performance Optimization

### **Build Optimizations**
- Terser minification
- CSS purging
- Asset optimization
- Chunk splitting
- Gzip compression

### **Runtime Optimizations**
- Service Worker caching
- Lazy loading
- Image optimization
- Font optimization
- Critical CSS inlining

## 🐛 Troubleshooting

### **Common Issues**

1. **Service Worker not registering**
   - Check HTTPS requirement
   - Verify file paths
   - Check browser console for errors

2. **Install prompt not showing**
   - Ensure manifest.json is valid
   - Check PWA criteria
   - Test on different browsers

3. **Offline functionality not working**
   - Verify Service Worker is active
   - Check cache strategies
   - Test network conditions

4. **Build errors**
   - Run `npm run clean && npm run build`
   - Check for missing dependencies
   - Verify file permissions

### **Debug Tools**
- Chrome DevTools > Application tab
- Lighthouse PWA audit
- PWA Builder (Microsoft)
- Web App Manifest Validator

## 📚 Resources

- [PWA Documentation](https://web.dev/progressive-web-apps/)
- [TailwindCSS Documentation](https://tailwindcss.com/docs)
- [Vite Documentation](https://vitejs.dev/guide/)
- [Laravel Vite Plugin](https://laravel.com/docs/vite)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test PWA functionality
5. Submit a pull request

## 📄 License

This PWA implementation is part of the main project and follows the same license terms.

---

**Happy PWA Development! 🚀**
