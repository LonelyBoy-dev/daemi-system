
const staticCachName='site-static';
const assets=[
    '/',
    '/login',
    '/admin/factors',
    '/admin/css/animate.css',
    '/admin/css/app-style-rtl.css',
    '/admin/css/app-style.css',
    '/admin/css/bootstrap.css',
    '/admin/css/bootstrap.min.css',
    '/admin/css/icons.css',
    '/admin/css/lobibox.min.css',
    '/admin/css/select2.min.css',
    '/admin/css/sidebar-menu.css',
    '/admin/css/skins.css',
    '/admin/css/table.mobile.css',
    '/admin/fonts/Vazir/Vazir.eot',
    '/admin/fonts/Vazir/Vazir.ttf',
    '/admin/fonts/Vazir/Vazir.woff',
    '/admin/js/app-script.js',
    '/admin/js/bootstrap.js',
    '/admin/js/bootstrap.min.js',
    '/admin/js/dashboard-digital-marketing.js',
    '/admin/js/dashboard-human-resources.js',
    '/admin/js/dashboard-logistics.js',
    '/admin/js/dashboard-property-listing.js',
    '/admin/js/dashboard-service-support.js',
    '/admin/js/data-widgets.js',
    '/admin/js/index.js',
    '/admin/js/jquery.dataTables.min.js',
    '/admin/js/jquery.loading-indicator.js',
    '/admin/js/jquery.min.js',
    '/admin/js/jquery-3.2.1.min.js',
    '/admin/js/lobibox.min.js',
    '/admin/js/popper.min.js',
    '/admin/js/script.js',
    '/admin/js/select2.min.js',
    '/admin/js/sidebar-menu.js',
    '/images/308111617557611_Untitled-1.jpg',
    '/admin/sounds/soundssound1.ogg',
    '/admin/sounds/soundssound2.ogg',
    '/admin/sounds/soundssound3.ogg',
    '/admin/sounds/soundssound4.ogg',
    '/admin/sounds/soundssound5.ogg',
    '/admin/sounds/soundssound6.ogg'
];
self.addEventListener('install',evt => {
    evt.waitUntil(
        caches.open(staticCachName).then(cache=>{
        cache.addAll(assets);
    }));
})
self.addEventListener('activate',evt => {

})
*/



self.addEventListener('fetch',evt => {
    evt.respondWith(
        caches.match(evt.request).then(cachRes=>{
            return cachRes || fetch(evt.request)
        })
    )
})

/*
const TGAbxApp = "TG-ABX-App-v1"
const assets = [
    '/',
    '/login',
    '/admin/factors',
    '/admin/css/animate.css',
    '/admin/css/app-style-rtl.css',
    '/admin/css/app-style.css',
    '/admin/css/bootstrap.css',
    '/admin/css/bootstrap.min.css',
    '/admin/css/icons.css',
    '/admin/css/lobibox.min.css',
    '/admin/css/select2.min.css',
    '/admin/css/sidebar-menu.css',
    '/admin/css/skins.css',
    '/admin/css/table.mobile.css',
    '/admin/fonts/Vazir/Vazir.eot',
    '/admin/fonts/Vazir/Vazir.ttf',
    '/admin/fonts/Vazir/Vazir.woff',
    '/admin/js/app-script.js',
    '/admin/js/bootstrap.js',
    '/admin/js/bootstrap.min.js',
    '/admin/js/dashboard-digital-marketing.js',
    '/admin/js/dashboard-human-resources.js',
    '/admin/js/dashboard-logistics.js',
    '/admin/js/dashboard-property-listing.js',
    '/admin/js/dashboard-service-support.js',
    '/admin/js/data-widgets.js',
    '/admin/js/index.js',
    '/admin/js/jquery.dataTables.min.js',
    '/admin/js/jquery.loading-indicator.js',
    '/admin/js/jquery.min.js',
    '/admin/js/jquery-3.2.1.min.js',
    '/admin/js/lobibox.min.js',
    '/admin/js/popper.min.js',
    '/admin/js/script.js',
    '/admin/js/select2.min.js',
    '/admin/js/sidebar-menu.js',
    '/images/308111617557611_Untitled-1.jpg',
    '/admin/sounds/soundssound1.ogg',
    '/admin/sounds/soundssound2.ogg',
    '/admin/sounds/soundssound3.ogg',
    '/admin/sounds/soundssound4.ogg',
    '/admin/sounds/soundssound5.ogg',
    '/admin/sounds/soundssound6.ogg'

]

self.addEventListener("install", installEvent => {
    installEvent.waitUntil(
        caches.open(TGAbxApp).then(cache => {
            cache.addAll(assets)
        })
    )
})

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                    // Cache hit - return response
                    if (response) {
                        return response;
                    }
                    return fetch(event.request);
                }
            )
    );
});
*/
/*const cacheName = 'js13kPWA-v1';
const appShellFiles = [
    '/admin/css/animate.css',
    '/admin/css/app-style-rtl.css',
    '/admin/css/app-style.css',
    '/admin/css/bootstrap.css',
    '/admin/css/bootstrap.min.css',
    '/admin/css/icons.css',
    '/admin/css/lobibox.min.css',
    '/admin/css/select2.min.css',
    '/admin/css/sidebar-menu.css',
    '/admin/css/skins.css',
    '/admin/css/table.mobile.css',
    '/admin/fonts/Vazir/Vazir.eot',
    '/admin/fonts/Vazir/Vazir.ttf',
    '/admin/fonts/Vazir/Vazir.woff',
    '/admin/js/app-script.js',
    '/admin/js/bootstrap.js',
    '/admin/js/bootstrap.min.js',
    '/admin/js/dashboard-digital-marketing.js',
    '/admin/js/dashboard-human-resources.js',
    '/admin/js/dashboard-logistics.js',
    '/admin/js/dashboard-property-listing.js',
    '/admin/js/dashboard-service-support.js',
    '/admin/js/data-widgets.js',
    '/admin/js/index.js',
    '/admin/js/jquery.dataTables.min.js',
    '/admin/js/jquery.loading-indicator.js',
    '/admin/js/jquery.min.js',
    '/admin/js/jquery-3.2.1.min.js',
    '/admin/js/lobibox.min.js',
    '/admin/js/popper.min.js',
    '/admin/js/script.js',
    '/admin/js/select2.min.js',
    '/admin/js/sidebar-menu.js',
    '/images/308111617557611_Untitled-1.jpg'
];

const contentToCache = appShellFiles.concat();
self.addEventListener('install', (e) => {
    e.waitUntil((async () => {
        const cache = await caches.open(cacheName);
        await cache.addAll(contentToCache);
    })());
});
self.addEventListener('fetch', (e) => {
    e.respondWith((async () => {
        const r = await caches.match(e.request);
        if (r) { return r; }
        const response = await fetch(e.request);
        const cache = await caches.open(cacheName);
        cache.put(e.request, response.clone());
        return response;
    })());
});*/
