/*
 * SMP Al-Qadri - Service Worker v1.3
 * Perbaikan:
 * - URL /storage/* tidak diintersep (termasuk saat JPG dibuka sebagai dokumen).
 * - Respons HTTP 404/403 diteruskan apa adanya, tidak disamarkan menjadi halaman offline.
 * - Halaman autentikasi/dasbor/API tidak disimpan di Cache Storage.
 * - Cache lama v1.2 dibersihkan saat aktivasi untuk menghindari data privat tertinggal.
 * - Hanya offline fallback dan aset statis publik yang dapat di-cache.
 */

const CACHE_NAME = "bk-alqadri-v1.3";
const CACHE_PREFIX = "bk-alqadri-";
const OFFLINE_URL = "/offline.html";

// Hindari cache precache untuk URL yang mungkin tidak ada / memerlukan login.
const PRECACHE_URLS = [
    OFFLINE_URL,
    "/images/icons/icon-192x192.png",
    "/images/icons/icon-512x512.png",
];

const PRIVATE_PATH = /^\/(?:admin|guru|orang-tua|siswa|bk|api|login|logout|lupa-password|reset-password)(?:\/|$)/i;
const PUBLIC_ASSET_PATH = /^\/(?:css|js|build|images)\//i;
const ASSET_EXTENSION = /\.(?:css|js|png|jpe?g|webp|gif|svg|ico|woff2?)$/i;

self.addEventListener("install", (event) => {
    event.waitUntil((async () => {
        const cache = await caches.open(CACHE_NAME);
        await Promise.all(PRECACHE_URLS.map(async (path) => {
            try {
                const response = await fetch(new Request(path, {
                    cache: "reload",
                    credentials: "same-origin",
                }));
                const type = response.headers.get("content-type") || "";
                const expectedType = path === OFFLINE_URL ? "text/html" : "image/";
                if (response.ok && type.includes(expectedType)) {
                    await cache.put(path, response);
                } else {
                    console.warn("[SW] Tidak di-cache:", path, response.status);
                }
            } catch (error) {
                console.warn("[SW] Precache gagal:", path, error);
            }
        }));
        await self.skipWaiting();
    })());
});

self.addEventListener("activate", (event) => {
    event.waitUntil((async () => {
        const names = await caches.keys();
        await Promise.all(names
            .filter((name) => name.startsWith(CACHE_PREFIX) && name !== CACHE_NAME)
            .map((name) => caches.delete(name)));
        await self.clients.claim();
    })());
});

self.addEventListener("fetch", (event) => {
    const request = event.request;
    if (request.method !== "GET") return;

    const url = new URL(request.url);
    if (url.origin !== self.location.origin) return;

    // PENTING: biarkan web server mengirim gambar upload asli beserta 403/404-nya.
    // Pengecekan ini harus sebelum pemeriksaan request.mode === "navigate".
    if (url.pathname.startsWith("/storage/")) return;

    // Jangan cache konten akun pengguna, API, atau hasil login.
    if (PRIVATE_PATH.test(url.pathname)) return;

    // Saat user membuka URL .jpg secara langsung, browser dapat mengirim mode=navigate.
    // Hanya respons jaringan gagal (bukan status HTTP 404/403) yang mendapat fallback offline.
    if (request.mode === "navigate" || request.destination === "document") {
        event.respondWith(handlePublicNavigation(request));
        return;
    }

    // Aset statis publik boleh di-cache. File upload /storage tetap tidak masuk sini.
    if (PUBLIC_ASSET_PATH.test(url.pathname) && ASSET_EXTENSION.test(url.pathname)) {
        event.respondWith(handlePublicAsset(event));
        return;
    }

    // Semua URL lain menggunakan jaringan biasa tanpa caching.
});

async function handlePublicNavigation(request) {
    try {
        // Status 404/403 tetap dikembalikan; jangan dianggap gangguan internet.
        return await fetch(request);
    } catch (error) {
        const cache = await caches.open(CACHE_NAME);
        const offlinePage = await cache.match(OFFLINE_URL);
        return offlinePage || new Response("Tidak ada koneksi internet.", {
            status: 503,
            headers: { "Content-Type": "text/plain; charset=utf-8" },
        });
    }
}

async function handlePublicAsset(event) {
    const request = event.request;
    const cache = await caches.open(CACHE_NAME);
    const cached = await cache.match(request);
    if (cached) return cached;

    try {
        const response = await fetch(request);
        const type = response.headers.get("content-type") || "";
        const isValidType = /^(?:text\/css|(?:text|application)\/javascript|image\/|font\/|application\/font-)/i.test(type);
        if (response.ok && isValidType && !response.headers.has("set-cookie")) {
            // Pertahankan proses penyimpanan walaupun response sudah dikirim.
            event.waitUntil(cache.put(request, response.clone()).catch((err) => {
                console.warn("[SW] Cache aset gagal:", err);
            }));
        }
        return response;
    } catch (error) {
        return new Response("Aset tidak tersedia saat offline.", {
            status: 503,
            headers: { "Content-Type": "text/plain; charset=utf-8" },
        });
    }
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
        title: "BK SMP AL QADRI ISLAMIC SCHOOL",
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
                e,
            );
        }
    }

    event.waitUntil(
        self.registration.showNotification(
            notificationData.title,
            notificationData,
        ),
    );
});

// Handle notification clicks
self.addEventListener("notificationclick", (event) => {
    console.log("[BK Service Worker] Notification clicked:", event.action);
    event.notification.close();

    if (event.action === "view") {
        event.waitUntil(
            clients.openWindow(
                event.notification.data?.url || "/siswa/dashboard",
            ),
        );
    } else if (event.action === "dismiss") {
        // Just close, no action needed
    } else {
        // Default click
        event.waitUntil(
            clients.openWindow(event.notification.data?.url || "/"),
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
