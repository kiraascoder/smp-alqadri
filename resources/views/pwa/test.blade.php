<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perangkat Tidak Mendukung PWA - Testing Guide</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #065f46 0%, #059669 50%, #10b981 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .section {
            padding: 30px;
            border-bottom: 1px solid #e5e7eb;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #065f46;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .device-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .device-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .device-card.unsupported {
            border-color: #dc2626;
            background: #fef2f2;
        }

        .device-card.limited {
            border-color: #f59e0b;
            background: #fffbeb;
        }

        .device-card.simulator {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .device-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .device-icon {
            font-size: 2.5rem;
        }

        .device-name {
            font-weight: 700;
            font-size: 1.2rem;
        }

        .pwa-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .pwa-status.unsupported {
            background: #fee2e2;
            color: #991b1b;
        }

        .pwa-status.limited {
            background: #fef3c7;
            color: #92400e;
        }

        .pwa-status.simulated {
            background: #dbeafe;
            color: #1e40af;
        }

        .device-specs {
            margin: 15px 0;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .device-specs strong {
            color: #374151;
        }

        .test-method {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
            border-left: 4px solid #3b82f6;
        }

        .method-title {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 8px;
        }

        .method-steps {
            font-size: 0.875rem;
            color: #4b5563;
            line-height: 1.5;
        }

        .simulator-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 20px 0;
            border: 2px dashed #cbd5e1;
        }

        .simulator-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 20px 0;
        }

        .simulator-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .simulator-btn:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .simulator-btn.active {
            background: #dc2626;
        }

        .test-demo {
            background: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 20px 0;
            border: 2px solid #e5e7eb;
        }

        .pwa-install-btn {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            margin: 10px;
            transition: all 0.3s ease;
        }

        .pwa-install-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
        }

        .pwa-install-btn.hidden {
            display: none !important;
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            margin: 10px 0;
        }

        .status-supported {
            background: #dcfce7;
            color: #166534;
        }

        .status-unsupported {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-limited {
            background: #fef3c7;
            color: #92400e;
        }

        .warning-box {
            background: #fef3c7;
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            color: #92400e;
        }

        .warning-box h4 {
            color: #92400e;
            margin-bottom: 10px;
        }

        .code-snippet {
            background: #1f2937;
            color: #e5e7eb;
            padding: 15px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            margin: 15px 0;
            overflow-x: auto;
        }

        .price-range {
            background: #ecfdf5;
            color: #065f46;
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .device-grid {
                grid-template-columns: 1fr;
            }

            .simulator-controls {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-mobile-alt"></i> Perangkat Testing PWA</h1>
            <p>Daftar perangkat yang tidak mendukung PWA untuk testing tombol install</p>
        </div>

        <!-- Real Devices Section -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-mobile-alt"></i>
                Perangkat Real yang Tidak Mendukung PWA
            </div>

            <div class="device-grid">
                <!-- Feature Phones -->
                <div class="device-card unsupported">
                    <div class="device-header">
                        <div class="device-icon">📱</div>
                        <div>
                            <div class="device-name">Feature Phones (KaiOS)</div>
                            <div class="pwa-status unsupported">❌ Tidak Mendukung</div>
                        </div>
                    </div>
                    <div class="device-specs">
                        <strong>Contoh:</strong> Nokia 8110 4G, Nokia 2720 Flip<br>
                        <strong>OS:</strong> KaiOS 2.5 atau lebih lama<br>
                        <strong>Browser:</strong> Basic browser tanpa Service Worker
                    </div>
                    <div class="price-range">💰 Rp 500K - 1.5 Juta</div>
                    <div class="test-method">
                        <div class="method-title">Cara Testing:</div>
                        <div class="method-steps">
                            1. Buka website BK di browser bawaan<br>
                            2. Tombol install PWA akan otomatis hidden<br>
                            3. Hanya tersedia bookmark/shortcut biasa
                        </div>
                    </div>
                </div>

                <!-- Old Android -->
                <div class="device-card unsupported">
                    <div class="device-header">
                        <div class="device-icon">🤖</div>
                        <div>
                            <div class="device-name">Android Lama</div>
                            <div class="pwa-status unsupported">❌ Tidak Mendukung</div>
                        </div>
                    </div>
                    <div class="device-specs">
                        <strong>Versi:</strong> Android 4.4 KitKat dan dibawah<br>
                        <strong>Browser:</strong> Android Browser (bukan Chrome)<br>
                        <strong>Contoh:</strong> Samsung Galaxy S4, HTC One M7
                    </div>
                    <div class="price-range">💰 Bekas: Rp 300K - 800K</div>
                    <div class="test-method">
                        <div class="method-title">Cara Testing:</div>
                        <div class="method-steps">
                            1. Gunakan browser bawaan Android (bukan Chrome)<br>
                            2. Service Worker tidak tersedia<br>
                            3. Install button akan hidden otomatis
                        </div>
                    </div>
                </div>

                <!-- Old iPhone -->
                <div class="device-card limited">
                    <div class="device-header">
                        <div class="device-icon">📱</div>
                        <div>
                            <div class="device-name">iPhone Lama</div>
                            <div class="pwa-status limited">⚠️ Dukungan Terbatas</div>
                        </div>
                    </div>
                    <div class="device-specs">
                        <strong>Versi:</strong> iOS 11.2 dan dibawah<br>
                        <strong>Browser:</strong> Safari tanpa Service Worker<br>
                        <strong>Contoh:</strong> iPhone 6, iPhone 5s
                    </div>
                    <div class="price-range">💰 Bekas: Rp 1-3 Juta</div>
                    <div class="test-method">
                        <div class="method-title">Cara Testing:</div>
                        <div class="method-steps">
                            1. Hanya bisa "Add to Home Screen" manual<br>
                            2. Tidak ada install prompt otomatis<br>
                            3. Service Worker tidak berfungsi
                        </div>
                    </div>
                </div>

                <!-- Smart TV -->
                <div class="device-card unsupported">
                    <div class="device-header">
                        <div class="device-icon">📺</div>
                        <div>
                            <div class="device-name">Smart TV Lama</div>
                            <div class="pwa-status unsupported">❌ Tidak Mendukung</div>
                        </div>
                    </div>
                    <div class="device-specs">
                        <strong>OS:</strong> Tizen OS lama, webOS lama<br>
                        <strong>Browser:</strong> Built-in browser basic<br>
                        <strong>Contoh:</strong> Samsung Smart TV 2018 kebawah
                    </div>
                    <div class="test-method">
                        <div class="method-title">Cara Testing:</div>
                        <div class="method-steps">
                            1. Akses via browser TV<br>
                            2. PWA features tidak tersedia<br>
                            3. Hanya bisa bookmark
                        </div>
                    </div>
                </div>

                <!-- Game Consoles -->
                <div class="device-card unsupported">
                    <div class="device-header">
                        <div class="device-icon">🎮</div>
                        <div>
                            <div class="device-name">Game Console</div>
                            <div class="pwa-status unsupported">❌ Tidak Mendukung</div>
                        </div>
                    </div>
                    <div class="device-specs">
                        <strong>Platform:</strong> PlayStation 4, Xbox One<br>
                        <strong>Browser:</strong> Basic browser tanpa PWA<br>
                        <strong>Fitur:</strong> Hanya browsing dasar
                    </div>
                    <div class="test-method">
                        <div class="method-title">Cara Testing:</div>
                        <div class="method-steps">
                            1. Buka browser di console<br>
                            2. Navigate ke website BK<br>
                            3. Install button tidak muncul
                        </div>
                    </div>
                </div>

                <!-- Old Desktop Browser -->
                <div class="device-card unsupported">
                    <div class="device-header">
                        <div class="device-icon">💻</div>
                        <div>
                            <div class="device-name">Browser Desktop Lama</div>
                            <div class="pwa-status unsupported">❌ Tidak Mendukung</div>
                        </div>
                    </div>
                    <div class="device-specs">
                        <strong>Browser:</strong> Internet Explorer, Firefox ESR lama<br>
                        <strong>Versi:</strong> IE 11, Firefox 60 kebawah<br>
                        <strong>OS:</strong> Windows 7, macOS Sierra kebawah
                    </div>
                    <div class="test-method">
                        <div class="method-title">Cara Testing:</div>
                        <div class="method-steps">
                            1. Install browser versi lama<br>
                            2. Test compatibility mode<br>
                            3. Service Worker tidak didukung
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Browser Simulator Section -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-laptop-code"></i>
                Simulator Browser Tidak Mendukung PWA
            </div>

            <div class="simulator-section">
                <h3><i class="fas fa-cogs"></i> Simulasi Real-time</h3>
                <p>Anda bisa mensimulasikan perangkat yang tidak mendukung PWA langsung di browser ini:</p>

                <div class="simulator-controls">
                    <button class="simulator-btn" onclick="simulateUnsupportedDevice('feature-phone')">
                        📱 Feature Phone
                    </button>
                    <button class="simulator-btn" onclick="simulateUnsupportedDevice('old-android')">
                        🤖 Android Lama
                    </button>
                    <button class="simulator-btn" onclick="simulateUnsupportedDevice('old-ios')">
                        📱 iOS Lama
                    </button>
                    <button class="simulator-btn" onclick="simulateUnsupportedDevice('ie11')">
                        💻 Internet Explorer
                    </button>
                    <button class="simulator-btn success" onclick="restoreNormalMode()">
                        ✅ Reset Normal
                    </button>
                </div>

                <div class="test-demo">
                    <h4>🎯 Demo Tombol Install PWA</h4>
                    <p id="device-status">Status: Browser Normal (PWA Didukung)</p>

                    <div class="status-indicator status-supported" id="pwa-status">
                        <i class="fas fa-check-circle"></i>
                        PWA Didukung - Tombol Install Muncul
                    </div>

                    <br><br>

                    <button class="pwa-install-btn" id="demo-install-btn">
                        <i class="fas fa-download"></i> Install BK App
                    </button>

                    <p style="margin-top: 15px; color: #6b7280; font-size: 0.875rem;">
                        ⬆️ Tombol ini akan hilang ketika browser tidak mendukung PWA
                    </p>
                </div>
            </div>
        </div>

        <!-- Testing Code Section -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-code"></i>
                Code untuk Hide Button pada Perangkat Tidak Mendukung
            </div>

            <div class="warning-box">
                <h4><i class="fas fa-exclamation-triangle"></i> Code Implementation</h4>
                <p>Berikut adalah code yang sudah diimplementasi di sistem BK untuk menyembunyikan tombol install:</p>
            </div>

            <div class="code-snippet">
                // Function untuk check PWA support
                function checkPWASupport() {
                const support = {
                serviceWorker: 'serviceWorker' in navigator,
                manifest: 'onbeforeinstallprompt' in window,
                cache: 'caches' in window,
                fetch: 'fetch' in window
                };

                return support.serviceWorker && support.manifest && support.cache;
                }

                // Function untuk hide/show install button
                function toggleInstallButton() {
                const installButtons = document.querySelectorAll(
                '.pwa-install-btn, #pwa-install-btn, [onclick*="install"]'
                );

                const isPWASupported = checkPWASupported();

                installButtons.forEach(button => {
                if (isPWASupported) {
                button.style.display = 'inline-block';
                button.disabled = false;
                } else {
                button.style.display = 'none';
                button.disabled = true;
                }
                });

                console.log(`PWA Support: ${isPWASupported ? 'YES' : 'NO'}`);
                console.log(`Install buttons: ${isPWASupported ? 'SHOWN' : 'HIDDEN'}`);
                }

                // Auto-run saat page load
                document.addEventListener('DOMContentLoaded', toggleInstallButton);
            </div>

            <h4 style="margin: 20px 0 10px 0; color: #059669;">🔍 Testing Steps:</h4>
            <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <ol style="padding-left: 20px; line-height: 1.8;">
                    <li><strong>Pilih perangkat</strong> dari daftar di atas yang tidak mendukung PWA</li>
                    <li><strong>Buka website BK</strong> di perangkat tersebut</li>
                    <li><strong>Check console</strong> untuk melihat PWA support detection</li>
                    <li><strong>Verifikasi</strong> bahwa tombol install tidak muncul/hidden</li>
                    <li><strong>Test fallback</strong> - pastikan website tetap berfungsi normal</li>
                </ol>
            </div>
        </div>

        <!-- Recommendations Section -->
        <div class="section">
            <div class="section-title">
                <i class="fas fa-lightbulb"></i>
                Rekomendasi Testing
            </div>

            <div class="device-grid">
                <div class="device-card simulator">
                    <div class="device-header">
                        <div class="device-icon">💰</div>
                        <div>
                            <div class="device-name">Budget Testing</div>
                            <div class="pwa-status simulated">💡 Hemat</div>
                        </div>
                    </div>
                    <div class="device-specs">
                        <strong>Option 1:</strong> Browser DevTools → Device simulation<br>
                        <strong>Option 2:</strong> Virtual Machine dengan OS lama<br>
                        <strong>Option 3:</strong> BrowserStack (online testing)
                    </div>
                    <div class="price-range">💰 Gratis - Rp 50K/bulan</div>
                </div>

                <div class="device-card simulator">
                    <div class="device-header">
                        <div class="device-icon">🎯</div>
                        <div>
                            <div class="device-name">Recommended Testing</div>
                            <div class="pwa-status simulated">⭐ Optimal</div>
                        </div>
                    </div>
                    <div class="device-specs">
                        <strong>Real Device:</strong> Nokia 8110 4G (KaiOS)<br>
                        <strong>Budget:</strong> Rp 800K - 1.2 Juta<br>
                        <strong>Benefit:</strong> Real testing experience
                    </div>
                    <div class="price-range">💰 Investasi Sekali</div>
                </div>

                <div class="device-card simulator">
                    <div class="device-header">
                        <div class="device-icon">🔄</div>
                        <div>
                            <div class="device-name">Continuous Testing</div>
                            <div class="pwa-status simulated">🚀 Advanced</div>
                        </div>
                    </div>
                    <div class="device-specs">
                        <strong>Automated:</strong> Cypress/Playwright testing<br>
                        <strong>CI/CD:</strong> GitHub Actions dengan browser matrix<br>
                        <strong>Coverage:</strong> Multiple devices & browsers
                    </div>
                    <div class="price-range">💰 Setup once, run forever</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables for simulation
        let originalNavigator = {};
        let originalWindow = {};

        // Store original values
        function storeOriginalValues() {
            originalNavigator = {
                serviceWorker: 'serviceWorker' in navigator,
                userAgent: navigator.userAgent
            };

            originalWindow = {
                caches: 'caches' in window,
                fetch: 'fetch' in window,
                onbeforeinstallprompt: 'onbeforeinstallprompt' in window
            };
        }

        // Simulate unsupported device
        function simulateUnsupportedDevice(deviceType) {
            const statusElement = document.getElementById('pwa-status');
            const deviceStatusElement = document.getElementById('device-status');
            const installButton = document.getElementById('demo-install-btn');

            // Reset any active buttons
            document.querySelectorAll('.simulator-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Mark current button as active
            event.target.classList.add('active');

            let deviceName = '';
            let shouldHideButton = false;

            switch (deviceType) {
                case 'feature-phone':
                    deviceName = 'Nokia Feature Phone (KaiOS)';
                    shouldHideButton = true;
                    // Simulate no Service Worker support
                    Object.defineProperty(window, 'caches', {
                        value: undefined,
                        configurable: true
                    });
                    Object.defineProperty(navigator, 'serviceWorker', {
                        value: undefined,
                        configurable: true
                    });
                    break;

                case 'old-android':
                    deviceName = 'Android 4.4 KitKat';
                    shouldHideButton = true;
                    // Simulate old Android browser
                    Object.defineProperty(navigator, 'userAgent', {
                        value: 'Mozilla/5.0 (Linux; Android 4.4.2; SM-G900P Build/KOT49H) AppleWebKit/537.36',
                        configurable: true
                    });
                    Object.defineProperty(window, 'caches', {
                        value: undefined,
                        configurable: true
                    });
                    break;

                case 'old-ios':
                    deviceName = 'iPhone iOS 11.0 (Safari)';
                    shouldHideButton = true;
                    // Simulate old iOS
                    Object.defineProperty(navigator, 'userAgent', {
                        value: 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38',
                        configurable: true
                    });
                    Object.defineProperty(navigator, 'serviceWorker', {
                        value: undefined,
                        configurable: true
                    });
                    break;

                case 'ie11':
                    deviceName = 'Internet Explorer 11';
                    shouldHideButton = true;
                    // Simulate IE11
                    Object.defineProperty(navigator, 'userAgent', {
                        value: 'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko',
                        configurable: true
                    });
                    Object.defineProperty(window, 'fetch', {
                        value: undefined,
                        configurable: true
                    });
                    Object.defineProperty(window, 'caches', {
                        value: undefined,
                        configurable: true
                    });
                    Object.defineProperty(navigator, 'serviceWorker', {
                        value: undefined,
                        configurable: true
                    });
                    break;
            }

            // Update UI
            deviceStatusElement.textContent = `Status: ${deviceName} (PWA Tidak Didukung)`;

            if (shouldHideButton) {
                statusElement.className = 'status-indicator status-unsupported';
                statusElement.innerHTML = '<i class="fas fa-times-circle"></i> PWA Tidak Didukung - Tombol Install Hidden';
                installButton.classList.add('hidden');
            }

            console.log(`🔄 Simulating: ${deviceName}`);
            console.log(`📱 PWA Support: ${shouldHideButton ? 'NO' : 'YES'}`);
            console.log(`🔘 Install Button: ${shouldHideButton ? 'HIDDEN' : 'VISIBLE'}`);
        }

        // Restore normal mode
        function restoreNormalMode() {
            // Reset simulator buttons
            document.querySelectorAll('.simulator-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Restore original browser capabilities
            Object.defineProperty(window, 'caches', {
                value: originalWindow.caches ? window.caches : {},
                configurable: true
            });
            Object.defineProperty(window, 'fetch', {
                value: originalWindow.fetch ? window.fetch : function() {},
                configurable: true
            });
            Object.defineProperty(navigator, 'serviceWorker', {
                value: originalNavigator.serviceWorker ? navigator.serviceWorker : undefined,
                configurable: true
            });
            Object.defineProperty(navigator, 'userAgent', {
                value: originalNavigator.userAgent,
                configurable: true
            });

            // Update UI
            const statusElement = document.getElementById('pwa-status');
            const deviceStatusElement = document.getElementById('device-status');
            const installButton = document.getElementById('demo-install-btn');

            deviceStatusElement.textContent = 'Status: Browser Normal (PWA Didukung)';
            statusElement.className = 'status-indicator status-supported';
            statusElement.innerHTML = '<i class="fas fa-check-circle"></i> PWA Didukung - Tombol Install Muncul';
            installButton.classList.remove('hidden');

            console.log('✅ Normal mode restored');
            console.log('📱 PWA Support: YES');
            console.log('🔘 Install Button: VISIBLE');
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            storeOriginalValues();
            console.log('🚀 PWA Testing Suite Ready');
            console.log('📋 Available simulations: Feature Phone, Old Android, Old iOS, IE11');
        });

        // Real PWA support check (for reference)
        function checkRealPWASupport() {
            const support = {
                serviceWorker: 'serviceWorker' in navigator,
                manifest: 'onbeforeinstallprompt' in window,
                cache: 'caches' in window,
                fetch: 'fetch' in window,
                notification: 'Notification' in window
            };

            const overallSupport = support.serviceWorker && support.manifest && support.cache;

            console.log('🔍 Real PWA Support Check:');
            console.log('- Service Worker:', support.serviceWorker ? '✅' : '❌');
            console.log('- Manifest:', support.manifest ? '✅' : '❌');
            console.log('- Cache API:', support.cache ? '✅' : '❌');
            console.log('- Fetch API:', support.fetch ? '✅' : '❌');
            console.log('- Notifications:', support.notification ? '✅' : '❌');
            console.log('- Overall PWA Support:', overallSupport ? '✅ SUPPORTED' : '❌ NOT SUPPORTED');

            return overallSupport;
        }

        // Auto-check on load
        setTimeout(checkRealPWASupport, 1000);
    </script>
</body>

</html>
