const CACHE_NAME = "bk-alqadri-v1.2";
const OFFLINE_URL = "/offline.html";
const FALLBACK_IMAGE = "/images/offline-placeholder.png";

// Enhanced cache strategy dengan lebih banyak URL
const urlsToCache = [
    "/",
    "/login",
    "/offline.html",
    "/css/app.css",
    "/js/app.js",
    "/images/icons/icon-192x192.png",
    "/images/icons/icon-512x512.png",
    // Tambahkan route-route penting sistem BK
    "/siswa/dashboard",
    "/siswa/profil-siswa",
    "/siswa/konseling",
    "/siswa/pelanggaran",
    "/siswa/laporan",
    "/guru/dashboard",
    "/guru/profil",
    "/guru/siswa",
    "/bk/dashboard",
    "/bk/profil",
    "/bk/siswa",
    "/bk/konseling",
    "/admin/dashboard",
];

// Dynamic cache patterns untuk halaman yang sering diakses
const CACHE_PATTERNS = [
    /^\/siswa\//,
    /^\/guru\//,
    /^\/bk\//,
    /^\/admin\//,
    /\.css$/,
    /\.js$/,
    /\.png$/,
    /\.jpg$/,
    /\.jpeg$/,
    /\.gif$/,
    /\.svg$/,
];

self.addEventListener("install", (event) => {
    console.log("[BK Service Worker] Installing v1.2...");
    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) => {
                console.log(
                    "[BK Service Worker] Caching app shell and essential pages"
                );
                return cache.addAll(
                    urlsToCache.map((url) => {
                        const request = new Request(url, {
                            cache: "reload",
                            credentials: "same-origin",
                        });
                        return request;
                    })
                );
            })
            .catch((error) => {
                console.error("[BK Service Worker] Cache failed:", error);
                // Fallback: cache minimal essentials jika ada yang gagal
                return caches.open(CACHE_NAME).then((cache) => {
                    return cache.addAll(["/", "/offline.html"]);
                });
            })
    );
    self.skipWaiting();
});

self.addEventListener("activate", (event) => {
    console.log("[BK Service Worker] Activating v1.2...");
    event.waitUntil(
        Promise.all([
            // Cleanup old caches
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
            }),
            // Claim clients immediately
            self.clients.claim(),
        ])
    );
});

// Enhanced fetch handler dengan better offline support
self.addEventListener("fetch", (event) => {
    // Skip cross-origin dan chrome-extension requests
    if (
        !event.request.url.startsWith(self.location.origin) ||
        event.request.url.startsWith("chrome-extension://")
    ) {
        return;
    }

    // Skip POST, PUT, DELETE requests untuk avoid caching form submissions
    if (event.request.method !== "GET") {
        return;
    }

    const url = new URL(event.request.url);

    // Handle navigation requests (HTML pages)
    if (
        event.request.destination === "document" ||
        event.request.headers.get("accept")?.includes("text/html")
    ) {
        event.respondWith(handleNavigationRequest(event.request));
    }
    // Handle images
    else if (event.request.destination === "image") {
        event.respondWith(handleImageRequest(event.request));
    }
    // Handle CSS, JS, and other static assets
    else if (isStaticAsset(event.request)) {
        event.respondWith(handleStaticAssetRequest(event.request));
    }
    // Handle API requests
    else if (url.pathname.startsWith("/api/")) {
        event.respondWith(handleApiRequest(event.request));
    }
    // Default handling
    else {
        event.respondWith(handleDefaultRequest(event.request));
    }
});

// Navigation request handler - prioritas network, fallback ke cache, then offline page
async function handleNavigationRequest(request) {
    try {
        // Try network first
        const networkResponse = await fetch(request);

        if (networkResponse.ok) {
            // Cache successful responses
            const responseClone = networkResponse.clone();
            caches.open(CACHE_NAME).then((cache) => {
                cache.put(request, responseClone);
            });
            return networkResponse;
        }
        throw new Error("Network response not ok");
    } catch (error) {
        console.log("[SW] Network failed for navigation, trying cache...");

        // Try cache
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }

        // Check if URL matches dynamic patterns
        if (shouldCacheDynamically(request.url)) {
            // Try to find similar cached page
            const similarPage = await findSimilarCachedPage(request.url);
            if (similarPage) {
                return similarPage;
            }
        }

        // Fallback to offline page
        console.log("[SW] Serving offline page for:", request.url);
        return caches.match(OFFLINE_URL);
    }
}

// Image request handler
async function handleImageRequest(request) {
    try {
        // Try cache first for images
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }

        // Try network
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            // Cache successful image responses
            const responseClone = networkResponse.clone();
            caches.open(CACHE_NAME).then((cache) => {
                cache.put(request, responseClone);
            });
            return networkResponse;
        }
        throw new Error("Image network response not ok");
    } catch (error) {
        // Return placeholder image or fallback
        console.log("[SW] Image failed, serving placeholder");
        return (
            caches.match(FALLBACK_IMAGE) ||
            new Response("", {
                status: 200,
                statusText: "Image not available offline",
            })
        );
    }
}

// Static asset handler (CSS, JS)
async function handleStaticAssetRequest(request) {
    try {
        // Try cache first for static assets
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }

        // Try network with timeout
        const networkResponse = await Promise.race([
            fetch(request),
            new Promise((_, reject) =>
                setTimeout(() => reject(new Error("Timeout")), 3000)
            ),
        ]);

        if (networkResponse.ok) {
            // Cache static assets aggressively
            const responseClone = networkResponse.clone();
            caches.open(CACHE_NAME).then((cache) => {
                cache.put(request, responseClone);
            });
            return networkResponse;
        }
        throw new Error("Static asset network response not ok");
    } catch (error) {
        console.log("[SW] Static asset failed:", request.url);
        return new Response("/* Asset not available offline */", {
            status: 200,
            statusText: "Asset cached version not available",
            headers: {
                "Content-Type": request.url.endsWith(".css")
                    ? "text/css"
                    : "application/javascript",
            },
        });
    }
}

// API request handler
async function handleApiRequest(request) {
    try {
        const networkResponse = await fetch(request);

        // Only cache GET API requests that are successful
        if (networkResponse.ok && request.method === "GET") {
            const responseClone = networkResponse.clone();
            caches.open(CACHE_NAME).then((cache) => {
                cache.put(request, responseClone);
            });
        }

        return networkResponse;
    } catch (error) {
        // For API requests, try cache for GET requests
        if (request.method === "GET") {
            const cachedResponse = await caches.match(request);
            if (cachedResponse) {
                return cachedResponse;
            }
        }

        // Return offline API response
        return new Response(
            JSON.stringify({
                error: "Offline",
                message: "API not available offline",
            }),
            {
                status: 503,
                statusText: "Service Unavailable",
                headers: { "Content-Type": "application/json" },
            }
        );
    }
}

// Default request handler
async function handleDefaultRequest(request) {
    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            // Cache if it matches patterns
            if (shouldCacheDynamically(request.url)) {
                const responseClone = networkResponse.clone();
                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(request, responseClone);
                });
            }
            return networkResponse;
        }
        throw new Error("Default network response not ok");
    } catch (error) {
        const cachedResponse = await caches.match(request);
        return (
            cachedResponse ||
            new Response("Not available offline", {
                status: 503,
                statusText: "Service Unavailable",
            })
        );
    }
}

// Helper functions
function isStaticAsset(request) {
    return (
        request.destination === "style" ||
        request.destination === "script" ||
        request.url.match(/\.(css|js)$/)
    );
}

function shouldCacheDynamically(url) {
    return CACHE_PATTERNS.some((pattern) => pattern.test(url));
}

async function findSimilarCachedPage(url) {
    const cache = await caches.open(CACHE_NAME);
    const keys = await cache.keys();

    // Cari halaman dengan pattern mirip
    for (const request of keys) {
        if (request.url.includes("/siswa/") && url.includes("/siswa/")) {
            return cache.match(request);
        }
        if (request.url.includes("/guru/") && url.includes("/guru/")) {
            return cache.match(request);
        }
        if (request.url.includes("/bk/") && url.includes("/bk/")) {
            return cache.match(request);
        }
        if (request.url.includes("/admin/") && url.includes("/admin/")) {
            return cache.match(request);
        }
    }

    return null;
}

// Background sync untuk data BK
self.addEventListener("sync", (event) => {
    console.log("[SW] Background sync triggered:", event.tag);

    if (event.tag === "counseling-sync") {
        event.waitUntil(syncCounselingData());
    }
    if (event.tag === "violation-sync") {
        event.waitUntil(syncViolationData());
    }
    if (event.tag === "profile-sync") {
        event.waitUntil(syncProfileData());
    }
});

// Push notifications untuk update BK
self.addEventListener("push", (event) => {
    console.log("[BK Service Worker] Push received");

    let notificationData = {
        title: "BK SMP AL QADRI",
        body: "Ada update baru dari Bimbingan Konseling",
        icon: "/images/icons/icon-192x192.png",
        badge: "/images/icons/icon-96x96.png",
        tag: "bk-notification",
        actions: [
            {
                action: "view",
                title: "Lihat",
                icon: "/images/icons/view-icon.png",
            },
            {
                action: "dismiss",
                title: "Tutup",
            },
        ],
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
    console.log("[BK Service Worker] Notification clicked:", event.action);
    event.notification.close();

    if (event.action === "view") {
        event.waitUntil(
            clients.openWindow(
                event.notification.data?.url || "/siswa/dashboard"
            )
        );
    } else if (event.action === "dismiss") {
        // Just close, no action needed
    } else {
        // Default click
        event.waitUntil(
            clients.openWindow(event.notification.data?.url || "/")
        );
    }
});

// Sync functions
async function syncCounselingData() {
    try {
        console.log("[SW] Syncing counseling data...");
        // Implementation untuk sync data konseling
        const cache = await caches.open(CACHE_NAME);
        // Logika sync sesuai dengan API endpoints
    } catch (error) {
        console.error("[BK Service Worker] Counseling sync failed:", error);
    }
}

async function syncViolationData() {
    try {
        console.log("[SW] Syncing violation data...");
        // Implementation untuk sync data pelanggaran
    } catch (error) {
        console.error("[BK Service Worker] Violation sync failed:", error);
    }
}

async function syncProfileData() {
    try {
        console.log("[SW] Syncing profile data...");
        // Implementation untuk sync data profil
    } catch (error) {
        console.error("[BK Service Worker] Profile sync failed:", error);
    }
} 
