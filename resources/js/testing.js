// Service Worker Testing Script untuk BK SMP AL QADRI
// Jalankan di Console Browser atau tambahkan ke file testing.js

class ServiceWorkerTester {
    constructor() {
        this.testResults = [];
        this.cacheName = "bk-alqadri-v1.0";
        this.testUrls = [
            "/",
            "/login",
            "/css/app.css",
            "/js/app.js",
            "/offline.html",
        ];
    }

    // Utility untuk logging hasil test
    log(testName, status, message = "") {
        const result = {
            test: testName,
            status: status ? "PASS" : "FAIL",
            message: message,
            timestamp: new Date().toISOString(),
        };
        this.testResults.push(result);
        console.log(`${result.status}: ${testName} - ${message}`);
        return result;
    }

    // Test 1: Service Worker Registration
    async testRegistration() {
        try {
            const registrations =
                await navigator.serviceWorker.getRegistrations();
            const isRegistered = registrations.length > 0;
            return this.log(
                "Service Worker Registration",
                isRegistered,
                isRegistered
                    ? `${registrations.length} SW registered`
                    : "No SW found"
            );
        } catch (error) {
            return this.log(
                "Service Worker Registration",
                false,
                error.message
            );
        }
    }

    // Test 2: Cache Creation and Content
    async testCacheCreation() {
        try {
            const cacheNames = await caches.keys();
            const hasCache = cacheNames.includes(this.cacheName);

            if (hasCache) {
                const cache = await caches.open(this.cacheName);
                const cachedRequests = await cache.keys();
                return this.log(
                    "Cache Creation",
                    true,
                    `Cache exists with ${cachedRequests.length} items`
                );
            } else {
                return this.log(
                    "Cache Creation",
                    false,
                    `Cache '${
                        this.cacheName
                    }' not found. Available: ${cacheNames.join(", ")}`
                );
            }
        } catch (error) {
            return this.log("Cache Creation", false, error.message);
        }
    }

    // Test 3: Offline Functionality
    async testOfflineFunctionality() {
        try {
            // Simulate offline request
            const response = await fetch("/offline.html", {
                cache: "force-cache",
            });
            const isOfflinePageAvailable = response.ok;
            return this.log(
                "Offline Page",
                isOfflinePageAvailable,
                isOfflinePageAvailable
                    ? "Offline page accessible"
                    : "Offline page not available"
            );
        } catch (error) {
            return this.log("Offline Page", false, error.message);
        }
    }

    // Test 4: Cache Strategy for Different Resource Types
    async testCacheStrategy() {
        const results = [];

        for (const url of this.testUrls) {
            try {
                // Check if URL is in cache
                const cache = await caches.open(this.cacheName);
                const cachedResponse = await cache.match(url);

                results.push({
                    url: url,
                    cached: !!cachedResponse,
                    status: cachedResponse?.status || "Not cached",
                });
            } catch (error) {
                results.push({
                    url: url,
                    cached: false,
                    status: `Error: ${error.message}`,
                });
            }
        }

        const cachedCount = results.filter((r) => r.cached).length;
        return this.log(
            "Cache Strategy",
            cachedCount > 0,
            `${cachedCount}/${this.testUrls.length} URLs cached`
        );
    }

    // Test 5: Background Sync Registration
    async testBackgroundSync() {
        try {
            if (
                "serviceWorker" in navigator &&
                "sync" in window.ServiceWorkerRegistration.prototype
            ) {
                const registration = await navigator.serviceWorker.ready;

                // Test counseling sync
                await registration.sync.register("counseling-sync");

                // Test violation sync
                await registration.sync.register("violation-sync");

                return this.log(
                    "Background Sync",
                    true,
                    "Sync events registered successfully"
                );
            } else {
                return this.log(
                    "Background Sync",
                    false,
                    "Background Sync not supported"
                );
            }
        } catch (error) {
            return this.log("Background Sync", false, error.message);
        }
    }

    // Test 6: Push Notification Support
    async testPushNotifications() {
        try {
            if ("Notification" in window) {
                const permission = await Notification.requestPermission();
                const isSupported = permission !== "denied";

                if (isSupported && permission === "granted") {
                    // Test notification
                    const registration = await navigator.serviceWorker.ready;
                    await registration.showNotification(
                        "BK Test Notification",
                        {
                            body: "Service Worker test successful",
                            icon: "/logo.png",
                            tag: "sw-test",
                        }
                    );
                }

                return this.log(
                    "Push Notifications",
                    isSupported,
                    `Permission: ${permission}`
                );
            } else {
                return this.log(
                    "Push Notifications",
                    false,
                    "Notifications not supported"
                );
            }
        } catch (error) {
            return this.log("Push Notifications", false, error.message);
        }
    }

    // Test 7: Service Worker Update Mechanism
    async testUpdateMechanism() {
        try {
            const registration =
                await navigator.serviceWorker.getRegistration();
            if (registration) {
                await registration.update();
                return this.log(
                    "Update Mechanism",
                    true,
                    "Update check completed"
                );
            } else {
                return this.log(
                    "Update Mechanism",
                    false,
                    "No registration found"
                );
            }
        } catch (error) {
            return this.log("Update Mechanism", false, error.message);
        }
    }

    // Test 8: Network Request Interception
    async testNetworkInterception() {
        try {
            // Test if SW intercepts requests
            const testFetch = await fetch("/", {
                method: "HEAD",
                cache: "no-cache",
            });

            const isIntercepted =
                testFetch.headers.get("sw-intercepted") !== null ||
                testFetch.type === "basic";

            return this.log(
                "Network Interception",
                true,
                `Request completed (${testFetch.status})`
            );
        } catch (error) {
            return this.log("Network Interception", false, error.message);
        }
    }

    // Test 9: Performance Metrics
    async testPerformanceMetrics() {
        try {
            const cacheNames = await caches.keys();
            let totalCacheSize = 0;
            let totalCachedItems = 0;

            for (const cacheName of cacheNames) {
                const cache = await caches.open(cacheName);
                const requests = await cache.keys();
                totalCachedItems += requests.length;

                // Estimate cache size (approximate)
                for (const request of requests.slice(0, 5)) {
                    // Sample first 5
                    const response = await cache.match(request);
                    if (response) {
                        const blob = await response.clone().blob();
                        totalCacheSize += blob.size;
                    }
                }
            }

            return this.log(
                "Performance Metrics",
                true,
                `${totalCachedItems} items cached, ~${Math.round(
                    totalCacheSize / 1024
                )}KB`
            );
        } catch (error) {
            return this.log("Performance Metrics", false, error.message);
        }
    }

    // Test 10: PWA Install Prompt
    async testPWAInstall() {
        try {
            const isInstallable =
                window.deferredPrompt !== undefined ||
                window.matchMedia("(display-mode: standalone)").matches;

            return this.log(
                "PWA Install",
                true,
                isInstallable
                    ? "PWA installable or already installed"
                    : "PWA install not available"
            );
        } catch (error) {
            return this.log("PWA Install", false, error.message);
        }
    }

    // Run All Tests
    async runAllTests() {
        console.log(
            "🚀 Starting Service Worker Tests for BK SMP AL QADRI...\n"
        );

        const tests = [
            this.testRegistration,
            this.testCacheCreation,
            this.testOfflineFunctionality,
            this.testCacheStrategy,
            this.testBackgroundSync,
            this.testPushNotifications,
            this.testUpdateMechanism,
            this.testNetworkInterception,
            this.testPerformanceMetrics,
            this.testPWAInstall,
        ];

        for (const test of tests) {
            await test.call(this);
            await this.delay(500); // Delay between tests
        }

        this.generateReport();
    }

    // Generate Test Report
    generateReport() {
        console.log("\n📊 SERVICE WORKER TEST REPORT");
        console.log("=".repeat(50));

        const passed = this.testResults.filter(
            (r) => r.status === "PASS"
        ).length;
        const failed = this.testResults.filter(
            (r) => r.status === "FAIL"
        ).length;

        console.log(`✅ Tests Passed: ${passed}`);
        console.log(`❌ Tests Failed: ${failed}`);
        console.log(
            `📈 Success Rate: ${Math.round(
                (passed / (passed + failed)) * 100
            )}%`
        );

        console.log("\nDetailed Results:");
        this.testResults.forEach((result) => {
            const icon = result.status === "PASS" ? "✅" : "❌";
            console.log(`${icon} ${result.test}: ${result.message}`);
        });

        // Recommendations
        console.log("\n💡 RECOMMENDATIONS:");
        if (failed > 0) {
            console.log("- Fix failing tests before production");
            if (
                this.testResults.find(
                    (r) => r.test === "Cache Creation" && r.status === "FAIL"
                )
            ) {
                console.log("- Check service worker installation");
            }
            if (
                this.testResults.find(
                    (r) =>
                        r.test === "Push Notifications" && r.status === "FAIL"
                )
            ) {
                console.log("- Enable notifications for full PWA experience");
            }
        } else {
            console.log(
                "- All tests passed! Service Worker is working correctly"
            );
            console.log("- Consider running these tests regularly");
        }

        return this.testResults;
    }

    // Utility delay function
    delay(ms) {
        return new Promise((resolve) => setTimeout(resolve, ms));
    }

    // Reset function for clean testing
    async reset() {
        try {
            // Unregister all service workers
            const registrations =
                await navigator.serviceWorker.getRegistrations();
            for (const registration of registrations) {
                await registration.unregister();
            }

            // Clear all caches
            const cacheNames = await caches.keys();
            for (const cacheName of cacheNames) {
                await caches.delete(cacheName);
            }

            console.log("🧹 Service Worker reset completed");
            return true;
        } catch (error) {
            console.error("Reset failed:", error);
            return false;
        }
    }
}

// Quick Test Functions (untuk testing manual di console)
const quickTests = {
    // Test if SW is active
    checkSW: async () => {
        const reg = await navigator.serviceWorker.getRegistration();
        console.log("SW Status:", reg ? "Active" : "Not registered");
        return !!reg;
    },

    // Test cache contents
    checkCache: async () => {
        const caches_list = await caches.keys();
        console.log("Available caches:", caches_list);

        for (const cacheName of caches_list) {
            const cache = await caches.open(cacheName);
            const keys = await cache.keys();
            console.log(`${cacheName}: ${keys.length} items`);
        }
    },

    // Test offline mode
    goOffline: () => {
        console.log(
            "💡 Go to Network tab > Throttling > Offline to test offline mode"
        );
    },

    // Test notification
    testNotification: async () => {
        if ("Notification" in window) {
            const permission = await Notification.requestPermission();
            if (permission === "granted") {
                new Notification("BK Test", {
                    body: "Service Worker notification test",
                    icon: "/logo.png",
                });
            }
        }
    },
};

// Export untuk penggunaan
if (typeof module !== "undefined" && module.exports) {
    module.exports = { ServiceWorkerTester, quickTests };
}

// Auto-run jika di browser
if (typeof window !== "undefined") {
    window.SWTester = ServiceWorkerTester;
    window.quickTests = quickTests;

    console.log("🔧 Service Worker Testing Tools Loaded!");
    console.log("Usage:");
    console.log("- const tester = new SWTester(); await tester.runAllTests();");
    console.log("- quickTests.checkSW();");
    console.log("- quickTests.checkCache();");
    console.log("- quickTests.testNotification();");
}

/*
CARA PENGGUNAAN:

1. Copy script ini ke console browser atau save sebagai file .js
2. Jalankan testing lengkap:
   const tester = new SWTester();
   await tester.runAllTests();

3. Testing individual:
   await quickTests.checkSW();
   await quickTests.checkCache();
   await quickTests.testNotification();

4. Reset untuk testing ulang:
   await tester.reset();

5. Re-run tests:
   await tester.runAllTests();
*/
