<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PWAController extends Controller
{
    /**
     * Handle PWA install analytics
     */
    public function trackInstallEvent(Request $request)
    {
        try {
            $data = $request->validate([
                'action' => 'required|string|in:initialized,prompt_available,accepted,dismissed,error,installed',
                'details' => 'nullable|string',
                'userAgent' => 'nullable|string',
                'timestamp' => 'required|date'
            ]);

            // Log untuk monitoring
            Log::info('PWA Install Event', [
                'action' => $data['action'],
                'details' => $data['details'] ?? '',
                'user_agent' => $data['userAgent'] ?? $request->userAgent(),
                'ip' => $request->ip(),
                'timestamp' => $data['timestamp'],
                'user_id' => auth()->id()
            ]);

            // Store dalam cache untuk quick access
            $cacheKey = 'pwa_stats_' . Carbon::now()->format('Y-m-d');
            $stats = Cache::get($cacheKey, [
                'initialized' => 0,
                'prompt_available' => 0,
                'accepted' => 0,
                'dismissed' => 0,
                'error' => 0,
                'installed' => 0
            ]);

            if (isset($stats[$data['action']])) {
                $stats[$data['action']]++;
                Cache::put($cacheKey, $stats, now()->addDays(7));
            }

            return response()->json([
                'success' => true,
                'message' => 'Event tracked successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('PWA Analytics Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to track event'
            ], 500);
        }
    }

    /**
     * Get PWA statistics for admin dashboard
     */
    public function getInstallStats(Request $request)
    {
        try {
            $days = $request->input('days', 7);
            $stats = [];

            for ($i = 0; $i < $days; $i++) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $cacheKey = 'pwa_stats_' . $date;
                $dayStats = Cache::get($cacheKey, [
                    'initialized' => 0,
                    'prompt_available' => 0,
                    'accepted' => 0,
                    'dismissed' => 0,
                    'error' => 0,
                    'installed' => 0
                ]);

                $stats[$date] = $dayStats;
            }

            return response()->json([
                'success' => true,
                'stats' => $stats,
                'summary' => $this->calculateSummary($stats)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get stats'
            ], 500);
        }
    }

    /**
     * Generate manifest.json dynamically
     */
    public function manifest(Request $request)
    {
        $user = auth()->user();
        $role = $user ? $user->role : 'guest';

        // Customize manifest berdasarkan role user
        $manifest = [
            "name" => "BK SMP AL QADRI",
            "short_name" => "BK AL QADRI",
            "description" => "Sistem Bimbingan Konseling SMP AL QADRI",
            "start_url" => $this->getStartUrl($role),
            "display" => "standalone",
            "background_color" => "#6777ef",
            "theme_color" => "#6777ef",
            "orientation" => "portrait-primary",
            "scope" => "/",
            "lang" => "id",
            "dir" => "ltr",
            "categories" => ["education", "productivity"],
            "icons" => [
                [
                    "src" => "/images/icons/icon-72x72.png",
                    "sizes" => "72x72",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => "/images/icons/icon-96x96.png",
                    "sizes" => "96x96",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => "/images/icons/icon-128x128.png",
                    "sizes" => "128x128",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => "/images/icons/icon-144x144.png",
                    "sizes" => "144x144",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => "/images/icons/icon-152x152.png",
                    "sizes" => "152x152",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => "/images/icons/icon-192x192.png",
                    "sizes" => "192x192",
                    "type" => "image/png",
                    "purpose" => "any maskable"
                ],
                [
                    "src" => "/images/icons/icon-384x384.png",
                    "sizes" => "384x384",
                    "type" => "image/png",
                    "purpose" => "any"
                ],
                [
                    "src" => "/images/icons/icon-512x512.png",
                    "sizes" => "512x512",
                    "type" => "image/png",
                    "purpose" => "any maskable"
                ]
            ],
            "shortcuts" => $this->getShortcuts($role),
            "screenshots" => [
                [
                    "src" => "/images/screenshots/mobile-1.png",
                    "sizes" => "390x844",
                    "type" => "image/png",
                    "form_factor" => "narrow"
                ],
                [
                    "src" => "/images/screenshots/desktop-1.png",
                    "sizes" => "1280x720",
                    "type" => "image/png",
                    "form_factor" => "wide"
                ]
            ]
        ];

        return response()->json($manifest, 200, [
            'Content-Type' => 'application/manifest+json',
            'Cache-Control' => 'public, max-age=3600'
        ]);
    }

    /**
     * Handle offline data sync
     */
    public function syncOfflineData(Request $request)
    {
        try {
            $type = $request->input('type'); // counseling, violations, profile
            $data = $request->input('data', []);

            switch ($type) {
                case 'counseling':
                    return $this->syncCounselingData($data);

                case 'violations':
                    return $this->syncViolationData($data);

                case 'profile':
                    return $this->syncProfileData($data);

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid sync type'
                    ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Offline Sync Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Sync failed'
            ], 500);
        }
    }

    /**
     * Get cached pages info
     */
    public function getCachedPages(Request $request)
    {
        try {
            $role = $request->input('role', auth()->user()->role ?? 'guest');

            $pages = $this->getImportantPages($role);

            return response()->json([
                'success' => true,
                'pages' => $pages,
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get cached pages'
            ], 500);
        }
    }

    /**
     * Check PWA compatibility
     */
    public function checkCompatibility(Request $request)
    {
        $userAgent = $request->userAgent();
        $compatibility = [
            'serviceWorker' => true, // Assume modern browser
            'manifest' => true,
            'notification' => true,
            'cache' => true,
            'backgroundSync' => true,
            'pushManager' => true,
            'installPrompt' => $this->checkInstallPromptSupport($userAgent),
            'standalone' => $this->checkStandaloneSupport($userAgent),
            'device' => $this->getDeviceType($userAgent),
            'browser' => $this->getBrowserType($userAgent)
        ];

        return response()->json([
            'success' => true,
            'compatibility' => $compatibility,
            'recommendations' => $this->getRecommendations($compatibility)
        ]);
    }

    /**
     * Handle push notification subscription
     */
    public function subscribePushNotification(Request $request)
    {
        try {
            $subscription = $request->validate([
                'endpoint' => 'required|url',
                'keys' => 'required|array',
                'keys.p256dh' => 'required|string',
                'keys.auth' => 'required|string'
            ]);

            // Store subscription untuk user
            $user = auth()->user();
            if ($user) {
                // Update atau create push subscription
                // Implementasi sesuai dengan model PushSubscription
                Log::info('Push subscription registered', [
                    'user_id' => $user->id,
                    'endpoint' => $subscription['endpoint']
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Push notification subscribed'
            ]);
        } catch (\Exception $e) {
            Log::error('Push Subscription Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to subscribe'
            ], 500);
        }
    }

    // Private helper methods

    private function getStartUrl($role)
    {
        switch ($role) {
            case 'admin':
                return '/admin/dashboard';
            case 'guru':
                return '/guru/dashboard';
            case 'guru_bk':
                return '/bk/dashboard';
            case 'siswa':
                return '/siswa/dashboard';
            default:
                return '/login';
        }
    }

    private function getShortcuts($role)
    {
        $shortcuts = [
            [
                "name" => "Login",
                "short_name" => "Login",
                "description" => "Login ke sistem",
                "url" => "/login",
                "icons" => [
                    [
                        "src" => "/images/icons/login-icon.png",
                        "sizes" => "96x96"
                    ]
                ]
            ]
        ];

        switch ($role) {
            case 'siswa':
                $shortcuts[] = [
                    "name" => "Profil Siswa",
                    "short_name" => "Profil",
                    "description" => "Lihat profil siswa",
                    "url" => "/siswa/profil-siswa",
                    "icons" => [["src" => "/images/icons/profile-icon.png", "sizes" => "96x96"]]
                ];
                $shortcuts[] = [
                    "name" => "Konseling",
                    "short_name" => "Konseling",
                    "description" => "Jadwal konseling",
                    "url" => "/siswa/konseling",
                    "icons" => [["src" => "/images/icons/counseling-icon.png", "sizes" => "96x96"]]
                ];
                break;

            case 'guru_bk':
                $shortcuts[] = [
                    "name" => "Dashboard BK",
                    "short_name" => "Dashboard",
                    "description" => "Dashboard Guru BK",
                    "url" => "/bk/dashboard",
                    "icons" => [["src" => "/images/icons/dashboard-icon.png", "sizes" => "96x96"]]
                ];
                break;
        }

        return $shortcuts;
    }

    private function getImportantPages($role)
    {
        $pages = [
            ['url' => '/', 'name' => 'Beranda', 'icon' => '🏠'],
            ['url' => '/login', 'name' => 'Login', 'icon' => '🔐'],
        ];

        switch ($role) {
            case 'siswa':
                $pages = array_merge($pages, [
                    ['url' => '/siswa/dashboard', 'name' => 'Dashboard Siswa', 'icon' => '👨‍🎓'],
                    ['url' => '/siswa/profil-siswa', 'name' => 'Profil Siswa', 'icon' => '👤'],
                    ['url' => '/siswa/konseling', 'name' => 'Konseling', 'icon' => '💬'],
                    ['url' => '/siswa/pelanggaran', 'name' => 'Pelanggaran', 'icon' => '⚠️'],
                    ['url' => '/siswa/laporan', 'name' => 'Laporan', 'icon' => '📋']
                ]);
                break;

            case 'guru':
                $pages = array_merge($pages, [
                    ['url' => '/guru/dashboard', 'name' => 'Dashboard Guru', 'icon' => '👨‍🏫'],
                    ['url' => '/guru/profil', 'name' => 'Profil Guru', 'icon' => '👤'],
                    ['url' => '/guru/siswa', 'name' => 'Data Siswa', 'icon' => '👥']
                ]);
                break;

            case 'guru_bk':
                $pages = array_merge($pages, [
                    ['url' => '/bk/dashboard', 'name' => 'Dashboard BK', 'icon' => '🎯'],
                    ['url' => '/bk/profil', 'name' => 'Profil BK', 'icon' => '👤'],
                    ['url' => '/bk/siswa', 'name' => 'Data Siswa', 'icon' => '👥'],
                    ['url' => '/bk/konseling', 'name' => 'Konseling', 'icon' => '💬'],
                    ['url' => '/bk/skorsing', 'name' => 'Skorsing', 'icon' => '⚡']
                ]);
                break;

            case 'admin':
                $pages = array_merge($pages, [
                    ['url' => '/admin/dashboard', 'name' => 'Dashboard Admin', 'icon' => '👑'],
                    ['url' => '/admin/guru', 'name' => 'Data Guru', 'icon' => '👨‍🏫'],
                    ['url' => '/admin/siswa', 'name' => 'Data Siswa', 'icon' => '👥'],
                    ['url' => '/admin/bk', 'name' => 'Data Guru BK', 'icon' => '🎯']
                ]);
                break;
        }

        return $pages;
    }

    private function checkInstallPromptSupport($userAgent)
    {
        // Chrome Android, Chrome Desktop, Edge
        return preg_match('/Chrome|Edge/i', $userAgent) &&
            !preg_match('/iPhone|iPad/i', $userAgent);
    }

    private function checkStandaloneSupport($userAgent)
    {
        return !preg_match('/iPhone|iPad/i', $userAgent) ||
            preg_match('/Safari/i', $userAgent);
    }

    private function getDeviceType($userAgent)
    {
        if (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            return 'ios';
        } elseif (preg_match('/Android/i', $userAgent)) {
            return 'android';
        } elseif (preg_match('/Mobile/i', $userAgent)) {
            return 'mobile';
        } else {
            return 'desktop';
        }
    }

    private function getBrowserType($userAgent)
    {
        if (preg_match('/Chrome/i', $userAgent) && !preg_match('/Edge/i', $userAgent)) {
            return 'chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            return 'firefox';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) {
            return 'safari';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            return 'edge';
        } else {
            return 'other';
        }
    }

    private function getRecommendations($compatibility)
    {
        $recommendations = [];

        if (!$compatibility['installPrompt']) {
            $recommendations[] = 'Install prompt tidak tersedia. Gunakan menu browser untuk install.';
        }

        if ($compatibility['device'] === 'ios') {
            $recommendations[] = 'Untuk iOS: Gunakan Safari dan pilih "Add to Home Screen".';
        }

        if (!$compatibility['backgroundSync']) {
            $recommendations[] = 'Background sync tidak tersedia. Data akan sync saat aplikasi dibuka.';
        }

        return $recommendations;
    }

    private function calculateSummary($stats)
    {
        $summary = [
            'total_initialized' => 0,
            'total_installed' => 0,
            'install_rate' => 0,
            'dismissal_rate' => 0
        ];

        foreach ($stats as $dayStats) {
            $summary['total_initialized'] += $dayStats['initialized'];
            $summary['total_installed'] += $dayStats['installed'];
        }

        if ($summary['total_initialized'] > 0) {
            $summary['install_rate'] = round(($summary['total_installed'] / $summary['total_initialized']) * 100, 2);
        }

        return $summary;
    }

    private function syncCounselingData($data)
    {
        // Implement counseling data sync
        return response()->json(['success' => true, 'synced' => count($data)]);
    }

    private function syncViolationData($data)
    {
        // Implement violation data sync
        return response()->json(['success' => true, 'synced' => count($data)]);
    }

    private function syncProfileData($data)
    {
        // Implement profile data sync
        return response()->json(['success' => true, 'synced' => count($data)]);
    }
}
