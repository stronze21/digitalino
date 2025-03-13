// public/service-worker.js

const CACHE_NAME = 'digitalino-v1';

// Assets to cache for offline use
const assetsToCache = [
  '/',
  '/game-hub',
  '/about',
  '/games/number-recognition',
  '/games/counting-game',
  '/games/addition-game',
  '/games/shapes-game',
  '/games/subtraction-game',
  '/css/app.css',
  '/js/app.js',
  '/manifest.json',
  '/images/logo.png',
  '/images/mascot.png',
  // Character images
  '/images/characters/panda.png',
  '/images/characters/fox.png',
  '/images/characters/owl.png',
  '/images/characters/rabbit.png',
  '/images/characters/turtle.png',
  '/images/characters/penguin.png',
  '/images/characters/lion.png',
  '/images/characters/monkey.png',
  '/images/characters/panda-happy.png',
  '/images/characters/fox-smile.png',
  '/images/characters/rabbit-thinking.png',
  // Game images
  '/images/games/number-recognition.png',
  '/images/games/counting-game.png',
  '/images/games/addition-game.png',
  '/images/games/shapes-game.png',
  '/images/games/subtraction-game.png',
  '/images/games/measurement-game.png',
  // Avatar images
  '/images/avatars/fox.png',
  '/images/avatars/panda.png',
  '/images/avatars/owl.png',
  '/images/avatars/rabbit.png',
  '/images/avatars/turtle.png',
  '/images/avatars/penguin.png',
  '/images/avatars/lion.png',
  '/images/avatars/monkey.png',
  // Sound effects
  '/sounds/correct.mp3',
  '/sounds/incorrect.mp3',
  '/sounds/complete.mp3',
  // PWA icons
  '/images/icons/icon-72x72.png',
  '/images/icons/icon-96x96.png',
  '/images/icons/icon-128x128.png',
  '/images/icons/icon-144x144.png',
  '/images/icons/icon-152x152.png',
  '/images/icons/icon-192x192.png',
  '/images/icons/icon-384x384.png',
  '/images/icons/icon-512x512.png'
];

// Install event - cache assets
self.addEventListener('install', event => {
  // Skip waiting so the new service worker activates immediately
  self.skipWaiting();

  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('Caching app assets');
        return cache.addAll(assetsToCache);
      })
      .catch(error => {
        console.error('Error during service worker installation:', error);
      })
  );
});

// Activate event - clean up old caches
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            console.log('Removing old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );

  // Ensure the service worker takes control immediately
  return self.clients.claim();
});

// Fetch event - serve from cache or network
self.addEventListener('fetch', event => {
  // Skip non-GET requests
  if (event.request.method !== 'GET') {
    return;
  }

  // Skip browser extension requests and remote requests
  const url = new URL(event.request.url);
  if (url.origin !== location.origin) {
    return;
  }

  // Cache-first strategy
  event.respondWith(
    caches.match(event.request)
      .then(cachedResponse => {
        // Return cached response if available
        if (cachedResponse) {
          return cachedResponse;
        }

        // Otherwise, fetch from network
        return fetch(event.request)
          .then(response => {
            // Don't cache errors
            if (!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }

            // Clone the response - one to cache, one to return
            const responseToCache = response.clone();

            // Add new resources to cache
            caches.open(CACHE_NAME)
              .then(cache => {
                cache.put(event.request, responseToCache);
              });

            return response;
          })
          .catch(error => {
            console.error('Fetch failed:', error);

            // Check if request is for an HTML page
            if (event.request.headers.get('accept').includes('text/html')) {
              // Return the offline page
              return caches.match('/');
            }
          });
      })
  );
});

// Handle push notifications (if added later)
self.addEventListener('push', event => {
  if (event.data) {
    const data = event.data.json();

    const options = {
      body: data.body || 'Time to play and learn!',
      icon: '/images/icons/icon-192x192.png',
      badge: '/images/icons/icon-72x72.png',
      vibrate: [100, 50, 100],
      data: {
        url: data.url || '/'
      }
    };

    event.waitUntil(
      self.registration.showNotification(
        data.title || 'DIGITALINO',
        options
      )
    );
  }
});

// Handle notification clicks
self.addEventListener('notificationclick', event => {
  event.notification.close();

  event.waitUntil(
    clients.openWindow(event.notification.data.url)
  );
});
