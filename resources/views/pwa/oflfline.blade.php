<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BK SMP AL QADRI - Offline</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #065f46 0%, #059669 50%, #10b981 100%);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .offline-container {
            text-align: center;
            max-width: 500px;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .school-logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            animation: pulse 2s infinite;
        }

        .offline-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffffff, #d1fae5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .offline-subtitle {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #d1fae5;
            font-weight: 600;
        }

        .offline-message {
            font-size: 1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.6;
            color: #ecfdf5;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            padding: 0.75rem;
            background: rgba(239, 68, 68, 0.2);
            border-radius: 10px;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            animation: blink 1s infinite;
        }

        .retry-button {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 1rem;
            text-decoration: none;
            display: inline-block;
        }

        .retry-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .features-available {
            margin-top: 2rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .features-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #d1fae5;
        }

        .feature-list {
            list-style: none;
            text-align: left;
        }

        .feature-list li {
            padding: 0.5rem 0;
            font-size: 0.9rem;
            opacity: 0.8;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .feature-list li::before {
            content: '🕌';
            font-size: 1rem;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .connection-status {
            margin-top: 1rem;
            font-size: 0.9rem;
            opacity: 0.7;
        }

        .islamic-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.05;
            pointer-events: none;
            background-image: radial-gradient(circle at 25% 25%, white 2px, transparent 2px);
            background-size: 50px 50px;
        }
    </style>
</head>

<body>
    <div class="islamic-pattern"></div>

    <div class="offline-container">
        <div class="school-logo">🕌</div>

        <h1 class="offline-title">Offline</h1>
        <h2 class="offline-subtitle">BK SMP AL QADRI Islamic School</h2>

        <div class="status-indicator">
            <div class="status-dot"></div>
            <span>Tidak ada koneksi internet</span>
        </div>

        <p class="offline-message">
            Aplikasi Bimbingan dan Konseling sedang offline. Silakan periksa koneksi internet Anda
            dan coba lagi. Beberapa fitur masih dapat diakses secara offline.
        </p>

        <button class="retry-button" onclick="window.location.reload()">
            🔄 Coba Lagi
        </button>

        <div class="features-available">
            <div class="features-title">Fitur yang Tersedia Offline:</div>
            <ul class="feature-list">
                <li>Melihat data siswa yang sudah disimpan</li>
                <li>Membaca panduan konseling Islami</li>
                <li>Mengakses formulir offline</li>
                <li>Melihat jadwal konseling tersimpan</li>
            </ul>
        </div>

        <div class="connection-status" id="connectionStatus">
            Menunggu koneksi internet...
        </div>
    </div>

    <script>
        // Check connection status
        function updateConnectionStatus() {
            const statusElement = document.getElementById('connectionStatus');
            if (navigator.onLine) {
                statusElement.textContent = 'Koneksi internet terdeteksi! Memuat ulang...';
                statusElement.style.color = '#d1fae5';
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                statusElement.textContent = 'Menunggu koneksi internet...';
                statusElement.style.color = '#fca5a5';
            }
        }

        // Listen for online/offline events
        window.addEventListener('online', updateConnectionStatus);
        window.addEventListener('offline', updateConnectionStatus);

        // Initial check
        updateConnectionStatus();

        // Auto-retry every 10 seconds
        setInterval(() => {
            if (navigator.onLine) {
                window.location.reload();
            }
        }, 10000);

        // Add Islamic greeting based on time
        const hour = new Date().getHours();
        let greeting = '';
        if (hour < 12) {
            greeting = '☀️ Assalamu\'alaikum wa rahmatullahi wa barakatuh';
        } else if (hour < 15) {
            greeting = '🌅 Selamat siang, semoga berkah';
        } else if (hour < 18) {
            greeting = '🌆 Selamat sore, barakallahu fiikum';
        } else {
            greeting = '🌙 Selamat malam, semoga dalam lindungan Allah';
        }

        // Add greeting to page
        const greetingElement = document.createElement('div');
        greetingElement.style.marginTop = '1rem';
        greetingElement.style.fontSize = '0.9rem';
        greetingElement.style.opacity = '0.8';
        greetingElement.style.fontStyle = 'italic';
        greetingElement.textContent = greeting;
        document.querySelector('.offline-container').appendChild(greetingElement);
    </script>
</body>

</html>
