<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\Reaksi;
use App\Models\Pendapatan;
use App\Models\User;
use App\Models\ViewLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalitikBeritaController extends Controller
{
    /**
     * Get all analytics data based on period
     */
    public function getAnaliticsData(Request $request)
    {
        $period = $request->get('period', 'week');

        return response()->json([
            'status' => 'success',
            'data' => [
                'summary' => $this->getSummaryStats($period),
                'topNews' => $this->getTopNews($period),
                'viral' => $this->getViralContent($period),
                'chartData' => $this->getChartData($period),
                'categoryPerformance' => $this->getCategoryPerformance($period),
                'heatmapData' => $this->getHeatmapData($period)
            ]
        ]);
    }

    /**
     * Get summary statistics
     */
    private function getSummaryStats($period)
    {
        $dateFrom = $this->getDateRangeFrom($period);

        // 1. Total Berita Published (Sinkron dengan query manual)
        $totalNews = Berita::where('status_berita', 'Published')->count();
        $newsChange = Berita::where('status_berita', 'Published')
            ->whereDate('waktu_publikasi', '>=', $dateFrom)
            ->count();

        // 2. Total Komentar HANYA pada berita yang statusnya Published
        $totalComments = Komentar::whereHas('berita', function ($q) {
            $q->where('status_berita', 'Published');
        })->count();

        $commentsChange = Komentar::whereHas('berita', function ($q) {
            $q->where('status_berita', 'Published');
        })
            ->whereDate('created_at', '>=', $dateFrom)
            ->count();

        // 3. Total SEMUA User (Admin included agar sesuai dengan SELECT COUNT(id) FROM users)
        $totalUsers = User::count();
        $usersChange = User::whereDate('created_at', '>=', $dateFrom)->count();

        // 4. Total Revenue
        $totalRevenue = Pendapatan::where('status_pembayaran', 'Paid')->sum('nominal_pendapatan');
        $revenueChange = Pendapatan::where('status_pembayaran', 'Paid')
            ->whereDate('waktu_pembayaran', '>=', $dateFrom)
            ->sum('nominal_pendapatan');

        return [
            'totalNews' => $totalNews,
            'totalComments' => $totalComments,
            'totalUsers' => $totalUsers,
            'revenue' => (int)$totalRevenue,
            'newsChange' => ($period === 'today' ? "+$newsChange artikel hari ini" : "+$newsChange artikel periode ini"),
            'commentsChange' => ($period === 'today' ? "+$commentsChange komentar hari ini" : "+$commentsChange komentar periode ini"),
            'usersChange' => ($period === 'today' ? "+$usersChange user baru hari ini" : "+$usersChange user baru periode ini"),
            'revenueChange' => 'Rp ' . number_format($revenueChange, 0, ',', '.') . ' periode ini'
        ];
    }

    /**
     * Get top news by views
     */
    private function getTopNews($period)
    {
        $dateFrom = $this->getDateRangeFrom($period);

        return Berita::where('status_berita', 'Published')
            ->whereDate('waktu_publikasi', '>=', $dateFrom)
            ->with(['user:id,username', 'kategori:id,nama_kategori'])
            ->orderBy('jumlah_view', 'desc')
            ->limit(8)
            ->get()
            ->map(function ($news) {
                return [
                    'id' => $news->id,
                    'title' => $news->judul_berita,
                    'category' => $news->kategori->nama_kategori ?? 'Umum',
                    'views' => $news->jumlah_view ?? 0,
                    'author' => $news->user->username ?? 'Anonim',
                    'published' => Carbon::parse($news->waktu_publikasi)->format('d M Y'),
                    'trend' => $this->getTrend($news->jumlah_view)
                ];
            })->toArray();
    }

    /**
     * Get viral content (high engagement) - Tanpa Data Dummy
     */
    private function getViralContent($period)
    {
        $dateFrom = $this->getDateRangeFrom($period);

        return Berita::where('status_berita', 'Published')
            ->whereDate('waktu_publikasi', '>=', $dateFrom)
            ->with(['user:id,username', 'kategori:id,nama_kategori'])
            ->withCount(['komentar', 'reaksi'])
            ->orderBy('komentar_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($news) {
                return [
                    'id' => $news->id,
                    'title' => $news->judul_berita,
                    'category' => $news->kategori->nama_kategori ?? 'Umum',
                    'comments' => $news->komentar_count ?? 0,
                    'reactions' => $news->reaksi_count ?? 0,
                    'shares' => 0, // Set 0 karena tabel share belum ada
                    'author' => $news->user->username ?? 'Anonim'
                ];
            })->toArray();
    }

    /**
     * Get chart data for traffic trends (DB Agnostic)
     */
    private function getChartData($period)
    {
        return match ($period) {
            'today' => $this->getChartDataToday(),
            'week' => $this->getChartDataWeek(),
            'month' => $this->getChartDataMonth(),
            'year' => $this->getChartDataYear(),
            'all' => $this->getChartDataAll(), // Tambahin ini cuy!
            default => $this->getChartDataWeek(),
        };
    }

    private function getChartDataToday()
    {
        $today = Carbon::today();
        $labels = []; $views = []; $visitors = []; $comments = [];

        // Looping 24 jam penuh
        for ($i = 0; $i < 24; $i++) {
            $labels[] = sprintf('%02d:00', $i); // Hasil: 00:00, 01:00, dll

            $start = $today->copy()->setTime($i, 0, 0);
            $end = $today->copy()->setTime($i, 59, 59);

            $views[] = ViewLog::whereBetween('created_at', [$start, $end])->count();
            $visitors[] = ViewLog::whereBetween('created_at', [$start, $end])->distinct('ip_address')->count();
            $comments[] = Komentar::whereBetween('created_at', [$start, $end])->count();
        }

        return ['labels' => $labels, 'views' => $views, 'visitors' => $visitors, 'comments' => $comments];
    }

    private function getChartDataWeek()
    {
        $labels = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $views = [];
        $visitors = [];
        $comments = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            $views[] = ViewLog::whereDate('created_at', $date)->count();
            $visitors[] = ViewLog::whereDate('created_at', $date)->distinct('ip_address')->count();
            $comments[] = Komentar::whereDate('created_at', $date)->count();
        }

        return ['labels' => $labels, 'views' => $views, 'visitors' => $visitors, 'comments' => $comments];
    }

    private function getChartDataMonth()
    {
        $labels = []; $views = []; $visitors = []; $comments = [];

        // Looping 30 hari ke belakang
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d/m'); // Hasil: 12/04, 13/04, dll

            $views[] = ViewLog::whereDate('created_at', $date)->count();
            $visitors[] = ViewLog::whereDate('created_at', $date)->distinct('ip_address')->count();
            $comments[] = Komentar::whereDate('created_at', $date)->count();
        }

        return ['labels' => $labels, 'views' => $views, 'visitors' => $visitors, 'comments' => $comments];
    }

    private function getChartDataYear()
    {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $views = [];
        $visitors = [];
        $comments = [];

        for ($month = 1; $month <= 12; $month++) {
            $start = Carbon::now()->month($month)->startOfMonth();
            $end = Carbon::now()->month($month)->endOfMonth();

            $views[] = ViewLog::whereBetween('created_at', [$start, $end])->count();
            $visitors[] = ViewLog::whereBetween('created_at', [$start, $end])->distinct('ip_address')->count();
            $comments[] = Komentar::whereBetween('created_at', [$start, $end])->count();
        }

        return ['labels' => $labels, 'views' => $views, 'visitors' => $visitors, 'comments' => $comments];
    }

    private function getChartDataAll()
    {
        $labels = []; $views = []; $visitors = []; $comments = [];

        // CARI TAHUN PALING TUA DARI SEMUA TABEL
        $minView = ViewLog::min('created_at');
        $minKom = Komentar::min('created_at');

        $years = [];
        if ($minView) $years[] = Carbon::parse($minView)->year;
        if ($minKom) $years[] = Carbon::parse($minKom)->year;

        // Ambil tahun terkecil dari gabungan data di atas
        $minYear = empty($years) ? Carbon::now()->year : min($years);
        $currentYear = Carbon::now()->year;

        // Jaga-jaga kalau web lu baru rilis tahun ini
        if ($minYear == $currentYear) {
            $minYear = $currentYear - 1;
        }

        for ($year = $minYear; $year <= $currentYear; $year++) {
            $start = Carbon::create($year)->startOfYear();
            $end = Carbon::create($year)->endOfYear();

            $labels[] = (string)$year;

            $views[] = ViewLog::whereBetween('created_at', [$start, $end])->count();
            $visitors[] = ViewLog::whereBetween('created_at', [$start, $end])->distinct('ip_address')->count();
            $comments[] = Komentar::whereBetween('created_at', [$start, $end])->count();
        }

        return ['labels' => $labels, 'views' => $views, 'visitors' => $visitors, 'comments' => $comments];
    }

    /**
     * Get category performance
     */
    private function getCategoryPerformance($period)
    {
        $dateFrom = $this->getDateRangeFrom($period);

        $categories = Kategori::withSum(['berita as total_views' => function ($q) use ($dateFrom) {
            $q->where('status_berita', 'Published')
                ->whereDate('waktu_publikasi', '>=', $dateFrom);
        }], 'jumlah_view')->get();

        $maxViews = $categories->max('total_views') ?: 1;

        return $categories->map(function ($cat) use ($maxViews) {
            return [
                'name' => $cat->nama_kategori,
                'emoji' => '📊',
                'views' => (int) $cat->total_views,
                'pct' => round(((int) $cat->total_views / $maxViews) * 100)
            ];
        })->sortByDesc('views')->take(8)->values()->toArray();
    }

    /**
     * Get heatmap data - Berdasarkan Waktu Publikasi Berita
     */
    private function getHeatmapData($period)
    {
        $dateFrom = $this->getDateRangeFrom($period);
        $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $hours = ['06', '09', '12', '15', '18', '21'];
        $matrix = array_fill(0, 7, array_fill(0, 6, 0));

        // Ambil data publikasi berita (Bukan ViewLog)
        $beritas = Berita::where('status_berita', 'Published')
            ->whereDate('waktu_publikasi', '>=', $dateFrom)
            ->get(['waktu_publikasi']);

        foreach ($beritas as $b) {
            $dt = Carbon::parse($b->waktu_publikasi);
            $day = $dt->dayOfWeek;
            $h = $dt->hour;

            $hIndex = match (true) {
                $h >= 6 && $h < 9 => 0,
                $h >= 9 && $h < 12 => 1,
                $h >= 12 && $h < 15 => 2,
                $h >= 15 && $h < 18 => 3,
                $h >= 18 && $h < 21 => 4,
                default => 5,
            };
            $matrix[$day][$hIndex]++;
        }

        // Normalisasi warna berdasarkan angka tertinggi di matrix
        $allValues = collect($matrix)->flatten();
        $maxCount = $allValues->max() ?: 1;

        $intensities = [];
        foreach ($matrix as $dayData) {
            $dayIntensities = [];
            foreach ($dayData as $count) {
                $dayIntensities[] = $count / $maxCount;
            }
            $intensities[] = $dayIntensities;
        }

        return [
            'days' => $days,
            'hours' => $hours,
            'intensities' => $intensities
        ];
    }

    private function getDateRangeFrom($period)
    {
        return match ($period) {
            'today' => Carbon::today(),
            'week'  => Carbon::now()->subDays(7),
            'month' => Carbon::now()->subDays(30),
            'year'  => Carbon::now()->subMonths(12),
            'all'   => Carbon::create(2000, 1, 1), // Tambahin ini cuy
            default => Carbon::now()->subDays(7),
        };
    }

    private function getTrend($views)
    {
        if ($views > 1000) return 'up';
        if ($views < 100) return 'down';
        return 'stable';
    }
}
