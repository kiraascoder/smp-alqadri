// Enhanced PWA Installation Handler untuk BK SMP AL QADRI
let deferredPrompt = null;
let installButton = null;
let pwaSupported = false;

// Check PWA support pada browser
function checkPWASupport() {
    const support = {
        serviceWorker: "serviceWorker" in navigator,
        manifest: "onbeforeinstallprompt" in window,
        notification: "Notification" in window,
        localStorage: "localStorage" in window,
        fetch: "fetch" in window,
        cache: "caches" in window,
        backgroundSync:
            "serviceWorker" in navigator &&
            "sync" in window.ServiceWorkerRegistration.prototype,
        pushManager: "serviceWorker" in navigator && "PushManager" in window,
    };

    // Overall PWA support
    pwaSupported = support.serviceWorker && support.manifest && support.fetch;

    console.log("[PWA] Browser Support Check:", support);
    console.log("[PWA] Overall PWA Supported:", pwaSupported);

    return support;
}

// Deteksi jenis device dan browser
function getDeviceInfo() {
    const userAgent = navigator.userAgent;
    const platform = navigator.platform;

    return {
        isMobile:
            /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
                userAgent
            ),
        isIOS: /iPad|iPhone|iPod/.test(userAgent),
        isAndroid: /Android/.test(userAgent),
        isChrome: /Chrome/.test(userAgent) && !/Edge/.test(userAgent),
        isFirefox: /Firefox/.test(userAgent),
        isSafari: /Safari/.test(userAgent) && !/Chrome/.test(userAgent),
        isEdge: /Edge/.test(userAgent),
        platform: platform,
        userAgent: userAgent,
    };
}

// Handle beforeinstallprompt event
window.addEventListener("beforeinstallprompt", (e) => {
    console.log("[PWA] beforeinstallprompt event fired");
    e.preventDefault();
    deferredPrompt = e;

    showInstallButton();
    logInstallPromptEvent();
});

// Show install button dengan berbagai opsi
function showInstallButton() {
    installButton = document.getElementById("pwa-install-btn");
    const installContainer = document.getElementById("pwa-install-container");
    const deviceInfo = getDeviceInfo();

    if (installButton) {
        installButton.style.display = "block";
        installButton.classList.add("pwa-ready");

        // Customize button text berdasarkan device
        if (deviceInfo.isAndroid) {
            installButton.textContent = "Install App Android";
            installButton.innerHTML = `
                <i class="fas fa-download"></i>
                Install BK App
            `;
        } else if (deviceInfo.isIOS) {
            installButton.textContent = "Add to Home Screen";
            installButton.innerHTML = `
                <i class="fas fa-plus-square"></i>
                Add to Home Screen
            `;
        } else {
            installButton.textContent = "Install BK App";
            installButton.innerHTML = `
                <i class="fas fa-download"></i>
                Install App
            `;
        }
    }

    // Show install container jika ada
    if (installContainer) {
        installContainer.style.display = "block";
        installContainer.classList.add("pwa-ready");
    }

    // Show install notification
    showInstallNotification();
}

// Show notification untuk install
function showInstallNotification() {
    const notification = document.createElement("div");
    notification.id = "pwa-install-notification";
    notification.className = "pwa-install-notification";
    notification.innerHTML = `
        <div class="pwa-notification-content">
            <div class="pwa-notification-icon">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="pwa-notification-text">
                <strong>Install BK App</strong>
                <p>Install aplikasi untuk akses yang lebih cepat dan notifikasi</p>
            </div>
            <div class="pwa-notification-actions">
                <button id="pwa-install-notification-btn" class="btn btn-primary btn-sm">
                    Install
                </button>
                <button id="pwa-dismiss-notification-btn" class="btn btn-secondary btn-sm">
                    Nanti
                </button>
            </div>
        </div>
    `;

    // Add styles
    const style = document.createElement("style");
    style.textContent = `
        .pwa-install-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 16px;
            max-width: 300px;
            z-index: 10000;
            border-left: 4px solid #007bff;
            animation: slideInRight 0.3s ease-out;
        }
        
        .pwa-notification-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .pwa-notification-icon {
            color: #007bff;
            font-size: 24px;
        }
        
        .pwa-notification-text {
            flex: 1;
        }
        
        .pwa-notification-text strong {
            display: block;
            margin-bottom: 4px;
            color: #333;
        }
        
        .pwa-notification-text p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        
        .pwa-notification-actions {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .pwa-notification-actions .btn {
            font-size: 12px;
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .pwa-notification-actions .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .pwa-notification-actions .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @media (max-width: 480px) {
            .pwa-install-notification {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }
    `;

    document.head.appendChild(style);
    document.body.appendChild(notification);

    // Handle notification buttons
    document
        .getElementById("pwa-install-notification-btn")
        .addEventListener("click", () => {
            installPWA();
            dismissInstallNotification();
        });

    document
        .getElementById("pwa-dismiss-notification-btn")
        .addEventListener("click", () => {
            dismissInstallNotification();
            // Set timer untuk show lagi nanti
            setTimeout(showInstallNotification, 30 * 60 * 1000); // 30 menit
        });

    // Auto dismiss after 10 seconds
    setTimeout(() => {
        if (document.getElementById("pwa-install-notification")) {
            dismissInstallNotification();
        }
    }, 10000);
}

// Dismiss install notification
function dismissInstallNotification() {
    const notification = document.getElementById("pwa-install-notification");
    if (notification) {
        notification.style.animation = "slideOutRight 0.3s ease-out";
        setTimeout(() => {
            notification.remove();
        }, 300);
    }
}

// Main install function
async function installPWA() {
    if (!deferredPrompt) {
        handleInstallFallback();
        return;
    }

    try {
        console.log("[PWA] Showing install prompt...");
        deferredPrompt.prompt();

        const { outcome } = await deferredPrompt.userChoice;
        console.log("[PWA] User response to install prompt:", outcome);

        if (outcome === "accepted") {
            console.log("[PWA] User accepted the install prompt");
            trackInstallEvent("accepted");
            showInstallSuccess();
        } else {
            console.log("[PWA] User dismissed the install prompt");
            trackInstallEvent("dismissed");
            showInstallFallback();
        }

        // Hide install button
        hideInstallButton();
        deferredPrompt = null;
    } catch (error) {
        console.error("[PWA] Error during installation:", error);
        trackInstallEvent("error", error.message);
        handleInstallFallback();
    }
}

// Handle install fallback untuk browser yang tidak support
function handleInstallFallback() {
    const deviceInfo = getDeviceInfo();

    if (deviceInfo.isIOS) {
        showIOSInstallInstructions();
    } else if (deviceInfo.isAndroid && !deviceInfo.isChrome) {
        showAndroidInstallInstructions();
    } else {
        showGenericInstallInstructions();
    }
}

// Show iOS install instructions
function showIOSInstallInstructions() {
    const modal = createInstructionModal(
        "iOS Installation",
        `
        <div class="ios-install-steps">
            <h5><i class="fab fa-safari"></i> Install BK App di Safari iOS</h5>
            <ol>
                <li>Buka website ini di <strong>Safari</strong></li>
                <li>Tap tombol <strong>Share</strong> <i class="fas fa-share"></i></li>
                <li>Scroll dan pilih <strong>"Add to Home Screen"</strong> <i class="fas fa-plus-square"></i></li>
                <li>Tap <strong>"Add"</strong> untuk install</li>
            </ol>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                Aplikasi akan muncul di home screen seperti app native
            </div>
        </div>
    `
    );

    document.body.appendChild(modal);
    setTimeout(() => modal.classList.add("show"), 100);
}

// Show Android install instructions
function showAndroidInstallInstructions() {
    const modal = createInstructionModal(
        "Android Installation",
        `
        <div class="android-install-steps">
            <h5><i class="fab fa-chrome"></i> Install BK App di Chrome Android</h5>
            <ol>
                <li>Buka website ini di <strong>Chrome Browser</strong></li>
                <li>Tap menu <strong>⋮</strong> (tiga titik)</li>
                <li>Pilih <strong>"Add to Home screen"</strong> atau <strong>"Install app"</strong></li>
                <li>Tap <strong>"Add"</strong> atau <strong>"Install"</strong></li>
            </ol>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                App akan ter-install seperti aplikasi Android biasa
            </div>
        </div>
    `
    );

    document.body.appendChild(modal);
    setTimeout(() => modal.classList.add("show"), 100);
}

// Show generic install instructions
function showGenericInstallInstructions() {
    const deviceInfo = getDeviceInfo();
    let browserSpecific = "";

    if (deviceInfo.isChrome) {
        browserSpecific = `
            <li>Klik ikon <strong>install</strong> <i class="fas fa-download"></i> di address bar</li>
            <li>Atau klik menu ⋮ → "Install BK App"</li>
        `;
    } else if (deviceInfo.isFirefox) {
        browserSpecific = `
            <li>Klik menu ☰ → "Install This Site as App"</li>
        `;
    } else if (deviceInfo.isEdge) {
        browserSpecific = `
            <li>Klik menu ⋯ → "Apps" → "Install this site as an app"</li>
        `;
    } else {
        browserSpecific = `
            <li>Cari opsi "Install App" atau "Add to Home Screen" di browser menu</li>
        `;
    }

    const modal = createInstructionModal(
        "Install BK App",
        `
        <div class="generic-install-steps">
            <h5><i class="fas fa-desktop"></i> Install BK App di Browser</h5>
            <ol>
                ${browserSpecific}
                <li>Follow petunjuk untuk install aplikasi</li>
            </ol>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                Jika opsi install tidak tersedia, browser Anda mungkin tidak mendukung PWA
            </div>
            <div class="alternative-options">
                <h6>Alternatif:</h6>
                <button class="btn btn-outline-primary btn-sm" onclick="addBookmark()">
                    <i class="fas fa-bookmark"></i> Bookmark Website
                </button>
                <button class="btn btn-outline-success btn-sm" onclick="enableNotifications()">
                    <i class="fas fa-bell"></i> Enable Notifikasi
                </button>
            </div>
        </div>
    `
    );

    document.body.appendChild(modal);
    setTimeout(() => modal.classList.add("show"), 100);
}

// Create instruction modal
function createInstructionModal(title, content) {
    const modal = document.createElement("div");
    modal.className = "pwa-instruction-modal";
    modal.innerHTML = `
        <div class="pwa-modal-overlay" onclick="closeInstructionModal()"></div>
        <div class="pwa-modal-content">
            <div class="pwa-modal-header">
                <h4>${title}</h4>
                <button class="pwa-modal-close" onclick="closeInstructionModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="pwa-modal-body">
                ${content}
            </div>
            <div class="pwa-modal-footer">
                <button class="btn btn-secondary" onclick="closeInstructionModal()">
                    Tutup
                </button>
            </div>
        </div>
    `;

    // Add modal styles
    if (!document.getElementById("pwa-modal-styles")) {
        const style = document.createElement("style");
        style.id = "pwa-modal-styles";
        style.textContent = `
            .pwa-instruction-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 10001;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            
            .pwa-instruction-modal.show {
                opacity: 1;
            }
            
            .pwa-modal-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
            }
            
            .pwa-modal-content {
                background: white;
                border-radius: 8px;
                max-width: 500px;
                width: 90%;
                max-height: 80%;
                overflow-y: auto;
                position: relative;
                box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            }
            
            .pwa-modal-header {
                padding: 16px 20px;
                border-bottom: 1px solid #eee;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .pwa-modal-header h4 {
                margin: 0;
                color: #333;
            }
            
            .pwa-modal-close {
                background: none;
                border: none;
                font-size: 18px;
                color: #666;
                cursor: pointer;
                padding: 4px;
            }
            
            .pwa-modal-body {
                padding: 20px;
            }
            
            .pwa-modal-body ol {
                padding-left: 20px;
            }
            
            .pwa-modal-body li {
                margin-bottom: 8px;
                line-height: 1.4;
            }
            
            .pwa-modal-footer {
                padding: 16px 20px;
                border-top: 1px solid #eee;
                text-align: right;
            }
            
            .alternative-options {
                margin-top: 16px;
                padding-top: 16px;
                border-top: 1px solid #eee;
            }
            
            .alternative-options .btn {
                margin-right: 8px;
                margin-bottom: 8px;
            }
            
            .alert {
                padding: 12px;
                border-radius: 4px;
                margin: 12px 0;
            }
            
            .alert-info {
                background: #d1ecf1;
                border: 1px solid #bee5eb;
                color: #0c5460;
            }
            
            .alert-success {
                background: #d4edda;
                border: 1px solid #c3e6cb;
                color: #155724;
            }
            
            .alert-warning {
                background: #fff3cd;
                border: 1px solid #ffeaa7;
                color: #856404;
            }
        `;
        document.head.appendChild(style);
    }

    return modal;
}

// Close instruction modal
function closeInstructionModal() {
    const modal = document.querySelector(".pwa-instruction-modal");
    if (modal) {
        modal.classList.remove("show");
        setTimeout(() => modal.remove(), 300);
    }
}

// Alternative functions
function addBookmark() {
    if (window.sidebar && window.sidebar.addPanel) {
        // Firefox
        window.sidebar.addPanel(document.title, window.location.href, "");
    } else if (window.external && "AddFavorite" in window.external) {
        // Internet Explorer
        window.external.AddFavorite(window.location.href, document.title);
    } else {
        // Other browsers
        alert("Untuk bookmark: Tekan Ctrl+D (Windows) atau Cmd+D (Mac)");
    }
}

function enableNotifications() {
    if ("Notification" in window) {
        Notification.requestPermission().then((permission) => {
            if (permission === "granted") {
                new Notification("BK SMP AL QADRI", {
                    body: "Notifikasi berhasil diaktifkan!",
                    icon: "/images/icons/icon-192x192.png",
                });
            }
        });
    } else {
        alert("Browser Anda tidak mendukung notifikasi");
    }
}

// Show install success message
function showInstallSuccess() {
    const successMsg = document.createElement("div");
    successMsg.className = "pwa-install-success";
    successMsg.innerHTML = `
        <div class="success-content">
            <i class="fas fa-check-circle"></i>
            <h5>BK App Berhasil Diinstall!</h5>
            <p>Aplikasi sudah tersedia di device Anda</p>
        </div>
    `;

    const style = document.createElement("style");
    style.textContent = `
        .pwa-install-success {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            text-align: center;
            z-index: 10002;
            border: 3px solid #28a745;
        }
        
        .success-content i {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 16px;
        }
        
        .success-content h5 {
            color: #28a745;
            margin-bottom: 8px;
        }
        
        .success-content p {
            color: #666;
            margin: 0;
        }
    `;

    document.head.appendChild(style);
    document.body.appendChild(successMsg);

    setTimeout(() => {
        successMsg.remove();
        style.remove();
    }, 3000);
}

// Hide install button
function hideInstallButton() {
    if (installButton) {
        installButton.style.display = "none";
    }

    const installContainer = document.getElementById("pwa-install-container");
    if (installContainer) {
        installContainer.style.display = "none";
    }
}

// Track install events for analytics
function trackInstallEvent(action, details = "") {
    console.log("[PWA] Install Event:", action, details);

    // Send to analytics jika ada
    if (typeof gtag !== "undefined") {
        gtag("event", "pwa_install", {
            event_category: "PWA",
            event_label: action,
            value: details,
        });
    }

    // Send to custom analytics endpoint
    if (typeof fetch !== "undefined") {
        fetch("/api/analytics/pwa-install", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                action: action,
                details: details,
                userAgent: navigator.userAgent,
                timestamp: new Date().toISOString(),
            }),
        }).catch((error) => {
            console.log("[PWA] Analytics failed:", error);
        });
    }
}

// Log install prompt event
function logInstallPromptEvent() {
    const deviceInfo = getDeviceInfo();
    console.log("[PWA] Install prompt available for:", deviceInfo);
    trackInstallEvent("prompt_available", JSON.stringify(deviceInfo));
}

// Handle app installed event
window.addEventListener("appinstalled", () => {
    console.log("[PWA] PWA was installed successfully");
    trackInstallEvent("installed");
    hideInstallButton();

    // Show success message
    showInstallSuccess();

    // Clear deferred prompt
    deferredPrompt = null;
});

// DOMContentLoaded event handler
document.addEventListener("DOMContentLoaded", () => {
    console.log("[PWA] DOM loaded, initializing PWA install handler...");

    // Check PWA support
    const support = checkPWASupport();
    const deviceInfo = getDeviceInfo();

    // Initialize install button
    installButton = document.getElementById("pwa-install-btn");

    if (installButton) {
        installButton.addEventListener("click", installPWA);

        // Show alternative options jika PWA tidak fully supported
        if (!pwaSupported) {
            installButton.textContent = "App Options";
            installButton.onclick = handleInstallFallback;
            installButton.style.display = "block";
        }
    }

    // Check if already installed
    if (
        window.matchMedia &&
        window.matchMedia("(display-mode: standalone)").matches
    ) {
        console.log("[PWA] App is running in standalone mode");
        hideInstallButton();
    }

    // For iOS devices without prompt support
    if (deviceInfo.isIOS && !support.manifest) {
        setTimeout(() => {
            if (!deferredPrompt && installButton) {
                installButton.style.display = "block";
                installButton.textContent = "Add to Home Screen";
                installButton.onclick = showIOSInstallInstructions;
            }
        }, 2000);
    }

    // Log initialization
    console.log("[PWA] Install handler initialized with support:", support);
    trackInstallEvent("initialized", JSON.stringify({ support, deviceInfo }));
});

// Check if running as PWA
function isPWAMode() {
    return (
        window.matchMedia("(display-mode: standalone)").matches ||
        window.navigator.standalone === true
    );
}

// Export functions untuk testing/debugging
window.PWAInstaller = {
    checkPWASupport,
    getDeviceInfo,
    installPWA,
    handleInstallFallback,
    isPWAMode,
    trackInstallEvent,
};
