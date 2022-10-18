importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');
if (workbox) {

    // top-level routes we want to precache
    //workbox.precaching.precacheAndRoute(['/', '/login']);

    // injected assets by Workbox CLI
    workbox.precaching.precacheAndRoute([
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
        '/admin/sounds/soundssound6.ogg',
        '/local/resources/views/auth/login.blade.php',
        '/local/resources/views/admin/factor/index.blade.php',
        '/local/resources/views/admin/factor/create.blade.php',
        '/local/resources/views/admin/factor/edit.blade.php',
        '/local/resources/views/admin/factor/pdf-factor.blade.php',
        '/local/resources/views/admin/factor/show.blade.php',
        '/local/resources/views/admin/brands/index.blade.php',
        '/local/resources/views/admin/brands/create.blade.php',
        '/local/resources/views/admin/brands/edit.blade.php',
        '/local/resources/views/admin/categories/index.blade.php',
        '/local/resources/views/admin/categories/create.blade.php',
        '/local/resources/views/admin/categories/edit.blade.php',
        '/local/resources/views/admin/invoice/index.blade.php',
        '/local/resources/views/admin/invoice/create.blade.php',
        '/local/resources/views/admin/invoice/show.blade.php',
        '/local/resources/views/admin/invoice/pdf-invoice.blade.php',
        '/local/resources/views/admin/products/index.blade.php',
        '/local/resources/views/admin/products/create.blade.php',
        '/local/resources/views/admin/products/edit.blade.php',
        '/local/resources/views/admin/profile/index.blade.php',
        '/local/resources/views/admin/settings/index.blade.php',
    ]);

    // match routes for homepage, blog and any sub-pages of blog
    workbox.routing.registerRoute(
        /^\/(?:(blog)?(\/.*)?)$/,
        new workbox.strategies.NetworkFirst({
            cacheName: 'static-resources',
        })
    );

    // js/css files
    workbox.routing.registerRoute(
        /\.(?:js|css)$/,
        new workbox.strategies.StaleWhileRevalidate({
            cacheName: 'static-resources',
        })
    );

    // images
    workbox.routing.registerRoute(
        // Cache image files.
        /\.(?:png|jpg|jpeg|svg|gif)$/,
        // Use the cache if it's available.
        new workbox.strategies.CacheFirst({
            // Use a custom cache name.
            cacheName: 'image-cache',
            plugins: [
                new workbox.expiration.Plugin({
                    // Cache upto 50 images.
                    maxEntries: 50,
                    // Cache for a maximum of a week.
                    maxAgeSeconds: 7 * 24 * 60 * 60,
                })
            ],
        })
    );
    workbox.addEventListener("fetch", event => {
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

}
