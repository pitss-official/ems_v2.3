// const cacheName = 'svc1';
//
// // Call Install Event
// self.addEventListener('install', e => {
//     console.log('Service Worker: Installed');
// });
//
// // Call Activate Event
// self.addEventListener('activate', e => {
//     console.log('Service Worker: Activated');
//     // Remove unwanted caches
//     e.waitUntil(
//         caches.keys().then(cacheNames => {
//             return Promise.all(
//                 cacheNames.map(cache => {
//                     if (cache !== cacheName) {
//                         console.log('Service Worker: Clearing Old Cache');
//                         return caches.delete(cache);
//                     }
//                 })
//             );
//         })
//     );
// });
//
// // Call Fetch Event
// self.addEventListener('fetch', e => {
//     console.log('Service Worker: Fetching');
//     e.respondWith(
//         fetch(e.request)
//             .then(res => {
//                 // Make copy/clone of response
//                 const resClone = res.clone();
//                 // Open cahce
//                 caches.open(cacheName).then(cache => {
//                     // Add response to cache
//                     cache.put(e.request, resClone).catch(reason => {
//                         console.log(cache);
//                     });
//                 });
//                 return res;
//             })
//             .catch(err => caches.match(e.request).then(res => res).catch(reason=>console.log(reason)))
//     );
// });



/////////////////////////////////////
const cacheName = 'svc1.2';
//
// Call Install Event
// self.addEventListener('install', e => {
// });

// Call Activate Event
// self.addEventListener('activate', e => {
//     // Remove unwanted caches
//     e.waitUntil(
//         caches.keys().then(cacheNames => {
//             return Promise.all(
//                 cacheNames.map(cache => {
//                     if (cache !== cacheName) {
//                         console.log('Service Worker: Clearing Old Cache');
//                         return caches.delete(cache);
//                     }
//                 })
//             );
//         })
//     );
// });

// // Call Fetch Event

importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');

if (workbox) {
    console.log(`Yay! Workbox is loaded 🎉`);
} else {
    console.log(`Boo! Workbox didn't load 😬`);
}
workbox.core.setCacheNameDetails({
    prefix: 'OMS',
    suffix: 'v1'
});
workbox.routing.registerRoute(
    /\.js$/,
    // Use cache but update in the background.
    new workbox.strategies.StaleWhileRevalidate({
        // Use a custom cache name.
        cacheName: 'js-cache',
    })
);
workbox.routing.registerRoute(
    /\.css$/,
    // Use cache but update in the background.
    new workbox.strategies.StaleWhileRevalidate({
        // Use a custom cache name.
        cacheName: 'css-cache',
    })
);
workbox.routing.registerRoute(
    // Cache image files.
    /\.(?:png|jpg|jpeg|svg|gif|woff)$/,
    // Use the cache if it's available.
    new workbox.strategies.CacheFirst({
        // Use a custom cache name.
        cacheName: 'image-cache',
        plugins: [
            new workbox.expiration.Plugin({
                // Cache only 20 images.
                maxEntries: 10000,
                // Cache for a maximum of a week.
                maxAgeSeconds: 7 * 24 * 60 * 60,
            })
        ],
    })
);
const showNotification = () => {
    self.registration.showNotification('Background sync success!', {
        body: '🎉`🎉`🎉`'
    });
};
const bgSyncPlugin = new workbox.backgroundSync.Plugin('post-gen-sync', {
    callbacks: {
        queueDidReplay: showNotification
        // other types of callbacks could go here
    },
    // maxRetentionTime: 24 * 60 // Retry for max of 24 Hours (specified in minutes)
});
workbox.routing.registerRoute(
    new RegExp('/api/fetch/'),
    new workbox.strategies.NetworkOnly({
        cacheName: 'post-caches',
        plugins: [bgSyncPlugin]
    }),'POST'
);
workbox.routing.registerRoute(
    /.*(?:googleapis|gstatic)\.com/,
    new workbox.strategies.CacheFirst({
        cacheName: 'google-fonts-webfonts',
        plugins: [
            new workbox.cacheableResponse.Plugin({
                statuses: [0, 200],
            }),
            new workbox.expiration.Plugin({
                maxAgeSeconds: 60 * 60 * 24 * 365,
                maxEntries: 30,
            }),
        ],
    })
);
workbox.routing.registerRoute(
    new RegExp('/api/'),
    new workbox.strategies.StaleWhileRevalidate({
        cacheName: 'server-responses',
        plugins: [
            new workbox.cacheableResponse.Plugin({
                statuses: [0, 200],
            }),
            new workbox.expiration.Plugin({
                maxAgeSeconds: 60 * 60 * 24 * 365,
                maxEntries: 30,
            }),
        ],
    })
);
workbox.routing.registerRoute(
    new RegExp('/'),
    new workbox.strategies.NetworkFirst({
        cacheName: 'pages',
        plugins: [
            new workbox.cacheableResponse.Plugin({
                statuses: [0, 200],
            }),
            new workbox.expiration.Plugin({
                maxAgeSeconds: 60 * 60 * 24 * 365,
                maxEntries: 30,
            }),
        ],
    })
);

// self.addEventListener('fetch', e => {
//     e.respondWith(
//         fetch(e.request)
//             .then(res => {
//                 // Make copy/clone of response
//                 const resClone = res.clone();
//                 // Open cahce
//                 caches.open(cacheName).then(cache => {
//                     // Add response to cache
//                     cache.put(e.request, resClone).catch(reason => {
//                     });
//                 });
//                 return res;
//             })
//             .catch(err => caches.match(e.request).then(res => res).catch(reason=>console.log(reason)))
//     );
// });
