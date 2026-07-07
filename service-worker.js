self.addEventListener('install', function(e) {
  console.log('Service Worker Installed');
  e.waitUntil(
    caches.open('adsnoval-store').then(function(cache) {
      return cache.addAll([
        '/',
        '/offline.html',
         '/core/resources/views/templates/ptc_diamond/home.blade.php',
        '/core/resources/views/templates/ptc_diamond/home/assets/vendor/bootstrap-icons/bootstrap-icons.css',
        '/core/resources/views/templates/ptc_diamond/home/assets/vendor/swiper/swiper-bundle.min.css',
        '/assets/templates/ptc_diamond/css/custom.css',
        '/assets/templates/ptc_diamond/css/main.css',
        '/assets/templates/ptc_diamond/js/app.js',

        'core/resources/views/templates/ptc_diamond/home/assets/css/style.css',
        '/core/resources/views/templates/ptc_diamond/home/assets/js/functions.js'
      ]);
    })
  );
});

self.addEventListener('fetch', function(e) {
  e.respondWith(
    fetch(e.request).catch(() => caches.match('/offline.html'))
  );
});
