var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    '/offline',
    '/css/styles.css',
    '/images/logo.png',
    '/images/icons/icon-72x72.png',
    '/images/icons/icon-96x96.png',
    '/images/icons/icon-128x128.png',
    '/images/icons/icon-144x144.png',
    '/images/icons/icon-152x152.png',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-384x384.png',
    '/images/icons/icon-512x512.png',
    '/images/offline.svg'
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                console.log('Intentando cachear archivos');
                // Cachear archivos uno por uno para evitar que uno fallido detenga todo el proceso
                return Promise.all(
                    filesToCache.map(file => {
                        return cache.add(file).catch(error => {
                            console.error('Error cacheando ' + file + ': ' + error);
                            // Continuar a pesar del error
                            return Promise.resolve();
                        });
                    })
                );
            })
    )
});


// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});