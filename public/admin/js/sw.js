importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.0.0/workbox-sw.js');
if (workbox) {
    console.log(`WB IS OK`);
    workbox.core.setCacheNameDetails({
        prefix: 'TEST-SW',
        suffix: 'v1'

    });
    workbox.precaching.precacheAndRoute([]);
    self.addEventListener("message", event => {
        if (event.data && event.data.type === "SKIP_WAITING") {
            skipWaiting();
        }
    });

    workbox.routing.registerRoute(
        /\.(?:png|jpg|jpeg|svg|gif)$/,
        new workbox.strategies.CacheFirst({
            cacheName: 'image-cache',
            plugins: [
                new workbox.expiration.Plugin({
                    maxEntries: 25,
                    maxAgeSeconds: 7 * 24 * 60 * 60,
                })
            ],
        })
    );
} else {
    console.log("WB ERROR");
}
