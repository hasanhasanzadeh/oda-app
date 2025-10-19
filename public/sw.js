// Service Worker for API ODA PWA
// Version 1.0.0

const CACHE_NAME = 'api-oda-pwa-v1.0.0';
const STATIC_CACHE = 'api-oda-static-v1.0.0';
const DYNAMIC_CACHE = 'api-oda-dynamic-v1.0.0';
const OFFLINE_CACHE = 'api-oda-offline-v1.0.0';

// Files to cache immediately
const STATIC_FILES = [
    '/',
    '/manifest.json',
    '/css/all.min.css',
    '/css/select2.min.css',
    '/js/jquery.min.js',
    '/js/sweet-alert.min.js',
    '/js/alpine.min.js',
    '/js/select2.min.js',
    '/js/app.bundle.js',
    '/js/buttons.js',
    '/images/default-image.png',
    '/images/no-image.png',
    '/images/illustration.png',
    '/favicon.ico'
];

// API routes to cache
const API_ROUTES = [
    '/api/products',
    '/api/categories',
    '/api/settings',
    '/api/user/profile'
];

// Install event - cache static files
self.addEventListener('install', event => {
    console.log('Service Worker: Installing...');
    
    event.waitUntil(
        Promise.all([
            caches.open(STATIC_CACHE).then(cache => {
                console.log('Service Worker: Caching static files');
                return cache.addAll(STATIC_FILES);
            }),
            caches.open(OFFLINE_CACHE).then(cache => {
                console.log('Service Worker: Caching offline page');
                return cache.add('/offline');
            })
        ]).then(() => {
            console.log('Service Worker: Installation complete');
            return self.skipWaiting();
        })
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', event => {
    console.log('Service Worker: Activating...');
    
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME && 
                        cacheName !== STATIC_CACHE && 
                        cacheName !== DYNAMIC_CACHE && 
                        cacheName !== OFFLINE_CACHE) {
                        console.log('Service Worker: Deleting old cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        }).then(() => {
            console.log('Service Worker: Activation complete');
            return self.clients.claim();
        })
    );
});

// Fetch event - serve from cache or network
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);
    
    // Skip non-GET requests
    if (request.method !== 'GET') {
        return;
    }
    
    // Handle different types of requests
    if (request.destination === 'document') {
        // HTML pages - try network first, fallback to cache
        event.respondWith(handlePageRequest(request));
    } else if (request.destination === 'image') {
        // Images - cache first strategy
        event.respondWith(handleImageRequest(request));
    } else if (url.pathname.startsWith('/api/')) {
        // API requests - network first with cache fallback
        event.respondWith(handleApiRequest(request));
    } else if (request.destination === 'style' || request.destination === 'script') {
        // CSS/JS files - cache first
        event.respondWith(handleStaticRequest(request));
    } else {
        // Other requests - network first
        event.respondWith(handleOtherRequest(request));
    }
});

// Handle HTML page requests
async function handlePageRequest(request) {
    try {
        // Try network first
        const networkResponse = await fetch(request);
        
        if (networkResponse.ok) {
            // Cache successful responses
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, networkResponse.clone());
            return networkResponse;
        }
        
        throw new Error('Network response not ok');
    } catch (error) {
        console.log('Service Worker: Network failed, trying cache for:', request.url);
        
        // Try cache
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        // Fallback to offline page for navigation requests
        if (request.mode === 'navigate') {
            const offlineResponse = await caches.match('/offline');
            return offlineResponse || new Response('Offline', { status: 503 });
        }
        
        throw error;
    }
}

// Handle image requests
async function handleImageRequest(request) {
    try {
        // Try cache first
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        // Try network
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, networkResponse.clone());
            return networkResponse;
        }
        
        // Fallback to default image
        return await caches.match('/images/no-image.png');
    } catch (error) {
        console.log('Service Worker: Image fetch failed:', request.url);
        return await caches.match('/images/no-image.png');
    }
}

// Handle API requests
async function handleApiRequest(request) {
    try {
        // Try network first
        const networkResponse = await fetch(request);
        
        if (networkResponse.ok) {
            // Cache successful API responses
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, networkResponse.clone());
            return networkResponse;
        }
        
        throw new Error('API response not ok');
    } catch (error) {
        console.log('Service Worker: API failed, trying cache for:', request.url);
        
        // Try cache
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        // Return offline response for API
        return new Response(
            JSON.stringify({ 
                error: 'Offline', 
                message: 'You are currently offline. Please check your connection.' 
            }),
            { 
                status: 503,
                headers: { 'Content-Type': 'application/json' }
            }
        );
    }
}

// Handle static file requests (CSS, JS)
async function handleStaticRequest(request) {
    try {
        // Try cache first
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        // Try network
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(STATIC_CACHE);
            cache.put(request, networkResponse.clone());
            return networkResponse;
        }
        
        throw new Error('Static file not found');
    } catch (error) {
        console.log('Service Worker: Static file fetch failed:', request.url);
        throw error;
    }
}

// Handle other requests
async function handleOtherRequest(request) {
    try {
        // Try network first
        const networkResponse = await fetch(request);
        
        if (networkResponse.ok) {
            // Cache successful responses
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, networkResponse.clone());
            return networkResponse;
        }
        
        throw new Error('Network response not ok');
    } catch (error) {
        console.log('Service Worker: Network failed, trying cache for:', request.url);
        
        // Try cache
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        throw error;
    }
}

// Background sync for offline actions
self.addEventListener('sync', event => {
    console.log('Service Worker: Background sync triggered');
    
    if (event.tag === 'background-sync') {
        event.waitUntil(doBackgroundSync());
    }
});

// Push notifications
self.addEventListener('push', event => {
    console.log('Service Worker: Push notification received');
    
    const options = {
        body: event.data ? event.data.text() : 'New notification from API ODA',
        icon: '/pwa-icons/icon-192x192.png',
        badge: '/pwa-icons/icon-72x72.png',
        vibrate: [100, 50, 100],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1
        },
        actions: [
            {
                action: 'explore',
                title: 'View Details',
                icon: '/pwa-icons/icon-72x72.png'
            },
            {
                action: 'close',
                title: 'Close',
                icon: '/pwa-icons/icon-72x72.png'
            }
        ]
    };
    
    event.waitUntil(
        self.registration.showNotification('API ODA', options)
    );
});

// Notification click handler
self.addEventListener('notificationclick', event => {
    console.log('Service Worker: Notification clicked');
    
    event.notification.close();
    
    if (event.action === 'explore') {
        event.waitUntil(
            clients.openWindow('/')
        );
    }
});

// Background sync function
async function doBackgroundSync() {
    try {
        // Sync offline data when connection is restored
        console.log('Service Worker: Performing background sync');
        
        // You can add specific sync logic here
        // For example, sync cart data, user preferences, etc.
        
        return Promise.resolve();
    } catch (error) {
        console.error('Service Worker: Background sync failed:', error);
        return Promise.reject(error);
    }
}

// Message handler for communication with main thread
self.addEventListener('message', event => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
    
    if (event.data && event.data.type === 'GET_VERSION') {
        event.ports[0].postMessage({ version: CACHE_NAME });
    }
});

// Periodic background sync (if supported)
self.addEventListener('periodicsync', event => {
    if (event.tag === 'content-sync') {
        event.waitUntil(doBackgroundSync());
    }
});

console.log('Service Worker: Script loaded successfully');
