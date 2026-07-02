const CACHE = 'dolza-v5';
const STATIC_CACHE = 'dolza-static-v5';
const IMAGE_CACHE = 'dolza-images-v5';

const URLS = [
  '/', '/index.html', '/about.html', '/properties.html',
  '/contact.html', '/admin.html',
  '/offline.html', '/manifest.json', '/favicon.png',
  '/images/logo.png', '/images/icon-192.png', '/images/icon-512.png'
];

self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE)
      .then(c => Promise.allSettled(URLS.map(u => c.add(u))))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', e => {
  e.waitUntil(
    caches.keys().then(keys => Promise.all(
      keys.filter(k => k !== CACHE && k !== STATIC_CACHE && k !== IMAGE_CACHE).map(k => caches.delete(k))
    )).then(() => clients.claim())
  );
});

self.addEventListener('fetch', e => {
  const url = new URL(e.request.url);

  if (url.pathname.startsWith('/api/')) {
    e.respondWith(
      fetch(e.request).then(res => {
        const clone = res.clone();
        caches.open(STATIC_CACHE).then(c => c.put(e.request, clone));
        return res;
      }).catch(() => {
        return caches.match(e.request).then(r => r || new Response(JSON.stringify({ error: 'offline' }), {
          status: 503, headers: { 'Content-Type': 'application/json' }
        }));
      })
    );
    return;
  }

  const isHTML = e.request.headers.get('Accept')?.includes('text/html');

  if (isHTML) {
    e.respondWith(
      fetch(e.request).then(res => {
        const clone = res.clone();
        caches.open(CACHE).then(c => c.put(e.request, clone));
        return res;
      }).catch(() => caches.match(e.request).then(r => r || caches.match('/offline.html')))
    );
    return;
  }

  if (url.pathname.startsWith('/images/') || url.pathname.startsWith('/uploads/') || /\.(png|jpg|jpeg|gif|webp|svg|ico)$/i.test(url.pathname)) {
    e.respondWith(
      caches.open(IMAGE_CACHE).then(c => c.match(e.request)).then(r => {
        return r || fetch(e.request).then(res => {
          if (res.status === 200) {
            const clone = res.clone();
            caches.open(IMAGE_CACHE).then(c => c.put(e.request, clone));
          }
          return res;
        }).catch(() => caches.match('/images/logo.png'));
      })
    );
    return;
  }

  if (/\.(css|js|woff2?|ttf|otf)$/i.test(url.pathname)) {
    e.respondWith(
      caches.match(e.request).then(r => r || fetch(e.request).then(res => {
        if (res.status === 200) {
          const clone = res.clone();
          caches.open(STATIC_CACHE).then(c => c.put(e.request, clone));
        }
        return res;
      }))
    );
    return;
  }

  e.respondWith(
    fetch(e.request).catch(() => caches.match(e.request))
  );
});
