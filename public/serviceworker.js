const CACHE_NAME = "bk-alqadri-v1.0";
const OFFLINE_URL = "/offline.html";

// Cache essential resources for BK application
const urlsToCache = [
    "/",
    "/login",
    "/offline.html",
    "/css/app.css",
    "/js/app.js",
    "/images/icons/icon-192x192.png",
    "/images/icons/icon-512x512.png",
];

// Install event - cache core resources
self.addEventListener("install", (event) => {
    console.log("[BK Service Worker] Installing...");
    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) => {
                console.log("[BK Service Worker] Caching app shell");
                return cache.addAll(
                    urlsToCache.map(
                        (url) => new Request(url, { cache: "reload" })
                    )
                );
            })
            .catch((error) => {
                console.error("[BK Service Worker] Cache failed:", error);
            })
    );
    self.skipWaiting();
});

// Activate event - cleanup old caches
self.addEventListener("activate", (event) => {
    console.log("[BK Service Worker] Activating...");
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        console.log(
                            "[BK Service Worker] Deleting old cache:",
                            cacheName
                        );
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// Fetch event - implement caching strategy for BK app
self.addEventListener("fetch", (event) => {
    // Skip cross-origin requests
    if (!event.request.url.startsWith(self.location.origin)) {
        return;
    }

    // Handle different types of requests
    if (event.request.destination === "document") {
        // For navigation requests, try network first, then cache, then offline page
        event.respondWith(
            fetch(event.request)
                .then((response) => {
                    // Cache successful responses
                    if (response.status === 200) {
                        const responseClone = response.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(event.request, responseClone);
                        });
                    }
                    return response;
                })
                .catch(() => {
                    return caches.match(event.request).then((response) => {
                        return response || caches.match(OFFLINE_URL);
                    });
                })
        );
    } else if (event.request.destination === "image") {
        // For images, try cache first, then network
        event.respondWith(
            caches.match(event.request).then((response) => {
                if (response) {
                    return response;
                }
                return fetch(event.request).then((networkResponse) => {
                    if (networkResponse.status === 200) {
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(event.request, responseClone);
                        });
                    }
                    return networkResponse;
                });
            })
        );
    } else {
        // For other requests (CSS, JS, etc.), try cache first
        event.respondWith(
            caches.match(event.request).then((response) => {
                return (
                    response ||
                    fetch(event.request).then((networkResponse) => {
                        if (networkResponse.status === 200) {
                            const responseClone = networkResponse.clone();
                            caches.open(CACHE_NAME).then((cache) => {
                                cache.put(event.request, responseClone);
                            });
                        }
                        return networkResponse;
                    })
                );
            })
        );
    }
});

// Background sync for offline counseling data
self.addEventListener("sync", (event) => {
    if (event.tag === "counseling-sync") {
        console.log("[BK Service Worker] Background sync: counseling data");
        event.waitUntil(syncCounselingData());
    }
    if (event.tag === "violation-sync") {
        console.log("[BK Service Worker] Background sync: violation reports");
        event.waitUntil(syncViolationData());
    }
});

// Push notifications for BK updates
self.addEventListener("push", (event) => {
    console.log("[BK Service Worker] Push received");

    let notificationData = {
        title: "BK SMP AL QADRI",
        body: "Ada update baru dari Bimbingan Konseling",
        icon: "/images/icons/icon-192x192.png",
        badge: "/images/icons/icon-96x96.png",
        tag: "bk-notification",
    };

    if (event.data) {
        try {
            const data = event.data.json();
            notificationData = {
                ...notificationData,
                title: data.title || notificationData.title,
                body: data.body || notificationData.body,
                data: data.data || {},
            };
        } catch (e) {
            console.log(
                "[BK Service Worker] Error parsing notification data:",
                e
            );
        }
    }

    event.waitUntil(
        self.registration.showNotification(
            notificationData.title,
            notificationData
        )
    );
});

// Handle notification clicks
self.addEventListener("notificationclick", (event) => {
    console.log("[BK Service Worker] Notification clicked");
    event.notification.close();

    event.waitUntil(clients.openWindow(event.notification.data?.url || "/"));
});

// Sync functions
async function syncCounselingData() {
    try {
        // Sync pending counseling session data
        const cache = await caches.open(CACHE_NAME);
        const pendingData = await cache.match("/api/sync/counseling");
        if (pendingData) {
            // Send to server when online
            await fetch("/api/counseling/sync", {
                method: "POST",
                body: await pendingData.blob(),
            });
        }
    } catch (error) {
        console.error("[BK Service Worker] Counseling sync failed:", error);
    }
}

async function syncViolationData() {
    try {
        // Sync pending violation reports
        const cache = await caches.open(CACHE_NAME);
        const pendingData = await cache.match("/api/sync/violations");
        if (pendingData) {
            await fetch("/api/violations/sync", {
                method: "POST",
                body: await pendingData.blob(),
            });
        }
    } catch (error) {
        console.error("[BK Service Worker] Violation sync failed:", error);
    }
}
