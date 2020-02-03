var CACHE_NAME = 'my-site-cache-v1';
var urlsToCache = [
  '/',
  'assets/css/open-iconic-bootstrap.min.css',
  'assets/css/animate.css',
  'assets/css/owl.carousel.min.css',
  'assets/css/owl.theme.default.min.css',
  'assets/css/lightgallery.min.css',
  'assets/css/lg-transitions.css',
  'assets/css/aos.css',
  'assets/css/ionicons.min.css',
  'assets/css/flaticon.css',
  'assets/css/icomoon.css',
  'assets/vendor/fontawesome-free-5.10.2-web/css/all.css',
  'assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css',
  'assets/css/style.css',
  'assets/css/font/flaticon.css',
  'assets/css/sweetalert2.min.css',
  'assets/css/jquery-ui.min.css',
  'assets-2/bootstrap-select-1.13.12/dist/css/bootstrap-select.min.css',
  'assets/css/addtohomescreen.css',
  'assets/js/jquery.min.js',
  'assets/js/jquery-migrate-3.0.1.min.js',
  'assets/js/popper.min.js',
  'assets/js/jquery-ui.min.js',
  'assets-2/bootstrap-4.4.0/dist/js/bootstrap.min.js',
  'assets/js/parallax.js',
  'assets/js/jquery.waypoints.min.js',
  'assets/js/jquery.stellar.min.js',
  'assets/js/owl.carousel.min.js',
  'assets-2/bootstrap-select-1.13.12/dist/js/bootstrap-select.min.js',
  'assets/vendor/fontawesome-free-5.10.2-web/js/all.js',
  'assets/js/lightgallery-all.min.js',
  'assets/js/aos.js',
  'assets/js/jquery.animateNumber.min.js',
  'assets/js/scrollax.min.js',
  'assets/js/jquery.easing.min.js',
  'assets/js/main.js',
  'assets/js/addtohomescreen.min.js',
  'assets-2/fontawesome-free-5.10.2-web/css/all.min.css',
  'assets-2/css/style.css',
  'assets-2/css/Chart.min.css',
  'assets-2/js/jquery-3.3.1.js',
  'assets-2/js/Popper.js',
  'assets-2/js/main.js',
  'assets-2/fontawesome-free-5.10.2-web/js/all.min.js',
  'assets-2/js/Chart.min.js',
  'assets/js/sweetalert2.min.js',
  'assets/css/font/Flaticon.woff2'
];
self.addEventListener('install', function (event) {
  // Perform install steps
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function (cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});
self.addEventListener('fetch', function (event) {
  event.respondWith(
    caches.match(event.request)
      .then(function (response) {
        // Cache hit - return response
        if (response) {
          return response;
        }
        return fetch(event.request);
      }
      )
  );
});
self.addEventListener('fetch', function (event) {
  event.respondWith(
    caches.match(event.request)
      .then(function (response) {
        // Cache hit - return response
        if (response) {
          return response;
        }

        // IMPORTANT: Clone the request. A request is a stream and
        // can only be consumed once. Since we are consuming this
        // once by cache and once by the browser for fetch, we need
        // to clone the response.
        var fetchRequest = event.request.clone();

        return fetch(fetchRequest).then(
          function (response) {
            // Check if we received a valid response
            if (!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }

            // IMPORTANT: Clone the response. A response is a stream
            // and because we want the browser to consume the response
            // as well as the cache consuming the response, we need
            // to clone it so we have two streams.
            var responseToCache = response.clone();

            caches.open(CACHE_NAME)
              .then(function (cache) {
                cache.put(event.request, responseToCache);
              });

            return response;
          }
        );
      })
  );
});