const cacheName = 'news-v1';
const staticAssets = [
  'assets/css/style.css',
  'assets/css/sweetalert2.min.css',
  'assets/js/jquery-3.2.1.min.js',
  'assets/js/main.js',
  'assets/js/sweetalert2.min.js',
  'assets/css/animate.css',
  'assets/css/lightgallery.min.css',
  'assets/css/flaticon.css',
  'assets/vendor/fontawesome-free-5.10.2-web/css/all.css',
  'assets-2/bootstrap-4.4.0/dist/css/bootstrap.min.css',
  'assets/css/jquery-ui.min.css',
  'assets-2/bootstrap-select-1.13.12/dist/css/bootstrap-select.min.css',
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
  'assets-2/css/Chart.min.css',
  'assets-2/fontawesome-free-5.10.2-web/css/all.min.css',
  'assets-2/fontawesome-free-5.10.2-web/js/all.min.js',
  'assets-2/js/Chart.min.js',
  'assets/images/user.png',
  'assets/images/20190502_091550_Richtone(HDR).jpg',
  'assets/images/logo-title.png'
];
self.addEventListener('install', async e => {
  const cache = await caches.open(cacheName);
  await cache.addAll(staticAssets);
  return self.skipWaiting();
});

self.addEventListener('activate', e => {
  self.clients.claim();
});

self.addEventListener('fetch', async e => {
  const req = e.request;
  const url = new URL(req.url);

  if (url.origin === location.origin) {
    e.respondWith(cacheFirst(req));
  } else {
    e.respondWith(networkAndCache(req));
  }
});

async function cacheFirst(req) {
  const cache = await caches.open(cacheName);
  const cached = await cache.match(req);
  return cached || fetch(req);
}

async function networkAndCache(req) {
  const cache = await caches.open(cacheName);
  try {
    const fresh = await fetch(req);
    await cache.put(req, fresh.clone());
    return fresh;
  } catch (e) {
    const cached = await cache.match(req);
    return cached;
  }
}

function cleanResponse(response) {
  const clonedResponse = response.clone();

  // Not all browsers support the Response.body stream, so fall back to reading
  // the entire body into memory as a blob.
  const bodyPromise = 'body' in clonedResponse ?
    Promise.resolve(clonedResponse.body) :
    clonedResponse.blob();

  return bodyPromise.then((body) => {
    // new Response() is happy when passed either a stream or a Blob.
    return new Response(body, {
      headers: clonedResponse.headers,
      status: clonedResponse.status,
      statusText: clonedResponse.statusText,
    });
  });
}