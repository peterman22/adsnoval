// service-worker.js
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open('pwa-cache').then((cache) => {
      return cache.addAll([
        '/',
        '/core/resources/views/templates/ptc_diamond/home.blade.php',
        '/core/resources/views/templates/ptc_diamond/home/assets/vendor/bootstrap-icons/bootstrap-icons.css',
        '/core/resources/views/templates/ptc_diamond/home/assets/vendor/swiper/swiper-bundle.min.css',
        'core/resources/views/templates/ptc_diamond/home/assets/css/style.css',
        '/core/resources/views/templates/ptc_diamond/home/assets/js/functions.js'
      ]);
    })
  );
});

self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    })
  );
});