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
     * Get summary statistics: total news, comments, users, revenue
     */
    private function getSummaryStats($period)
    {
        $dateFrom = $this->getDateRangeFrom($period);
        
        // Total published news
        $totalNews = Berita::where('status_berita', 'Published')->count();
        $newsChange = Berita::where('status_berita', 'Published')
            ->whereDate('created_at', '>=', $dateFrom)
            ->count();
        
        // Total comments
        $totalComments = Komentar::count();
        $commentsChange = Komentar::whereDate('created_at', '>=', $dateFrom)->count();
        
        // Total registered users
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $usersChange = User::where('role', '!=', 'admin')
            ->whereDate('created_at', '>=', $dateFrom)
            ->count();
        
        // Total revenue
        $totalRevenue = Pendapatan::where('status_pembayaran', 'Paid')
            ->sum('nominal_pendapatan');
        $revenueChange = Pendapatan::where('status_pembayaran', 'Paid')
            ->whereDate('created_at', '>=', $dateFrom)
            ->sum('nominal_pendapatan');
        
        return [
            'totalNews' => $totalNews,
            'totalComments' => $totalComments,
            'totalUsers' => $totalUsers,
            'revenue' => (int)$totalRevenue,
            'newsChange' => ($period === 'today' ? "$newsChange artikel hari ini" : 
                           ($period === 'week' ? "$newsChange artikel minggu ini" : 
                           ($period === 'month' ? "$newsChange artikel bulan ini" : "$newsChange artikel tahun ini"))),
            'commentsChange' => ($period === 'today' ? "$commentsChange komentar hari ini" : 
                               ($period === 'week' ? "$commentsChange komentar minggu ini" : 
                               ($period === 'month' ? "$commentsChange komentar bulan ini" : "$commentsChange komentar tahun ini"))),
            'usersChange' => ($period === 'today' ? "$usersChange user hari ini" : 
                            ($period === 'week' ? "$usersChange user minggu ini" : 
                            ($period === 'month' ? "$usersChange user bulan ini" : "$usersChange user tahun ini"))),
            'revenueChange' => '+Rp ' . number_format($revenueChange / 1000000, 1) . 'M ' . 
                             ($period === 'month' ? 'bulan ini' : ($period === 'today' ? 'hari ini' : 'periode ini'))
        ];
    }

    /**
     * Get top news by views for the period
     */
    private function getTopNews($period)
    {
        $dateFrom = $this->getDateRangeFrom($period);
        
        $topNews = Berita::where('status_berita', 'Published')
            ->whereDate('waktu_publikasi', '>=', $dateFrom)
            ->with(['user:id,username', 'kategori:id,nama_kategori'])
            ->select('id', 'user_id', 'kategori_id', 'judul_berita', 'jumlah_view', 'waktu_publikasi', 'created_at')
            ->orderBy('jumlah_view', 'desc')
            ->limit(8)
            ->get()
            ->map(function($news) {
                return [
                    'id' => $news->id,
                    'title' => $news->judul_berita,
                    'category' => $news->kategori->nama_kategori ?? 'Uncategorized',
                    'views' => $news->jumlah_view ?? 0,
                    'author' => $news->user->username ?? 'Unknown',
                    'published' => Carbon::parse($news->waktu_publikasi)->format('d M Y'),
                    'trend' => $this->getTrend($news->jumlah_view)
                ];
            });
        
        return $topNews->toArray();
    }

    /**
     * Get viral content - articles with high engagement
     */
    private function getViralContent($period)
    {
        $dateFrom = $this->getDateRangeFrom($period);
        
        $viralContent = Berita::where('status_berita', 'Published')
            ->whereDate('waktu_publikasi', '>=', $dateFrom)
            ->with(['user:id,username', 'kategori:id,nama_kategori'])
            ->withCount([
                'komentar',
                'reaksi'
            ])
            ->select('id', 'user_id', 'kategori_id', 'judul_berita', 'created_at')
            ->orderBy('komentar_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function($news) {
                return [
                    'id' => $news->id,
                    'title' => $news->judul_berita,
                    'category' => $news->kategori->nama_kategori ?? 'Uncategorized',
                    'comments' => $news->komentar_count ?? 0,
                    'reactions' => $news->reaksi_count ?? 0,
                    'shares' => rand(500, 5000), // Placeholder - implement shares tracking if needed
                    'author' => $news->user->username ?? 'Unknown'
                ];
            });
        
        return $viralContent->toArray();
    }

    /**
     * Get chart data for traffic trends
     */
    private function getChartData($period)
    {
        if ($period === 'today') {
            return $this->getChartDataToday();
        } elseif ($period === 'week') {
            return $this->getChartDataWeek();
        } elseif ($period === 'month') {
            return $this->getChartDataMonth();
        } else {
            return $this->getChartDataYear();
        }
    }

    private function getChartDataToday()
    {
        $today = Carbon::today();
        $hours = [];
        $views = [];
        $visitors = [];
        $comments = [];
        
        for ($i = 0; $i < 12; $i++) {
            $hour = 6 + ($i * 2);
            $hours[] = sprintf('%02d', $hour);
            
            // SQLite compatible: use strftime instead of HOUR
            $viewsCount = ViewLog::whereDate('created_at', $today)
                ->whereRaw("CAST(strftime('%H', created_at) AS INTEGER) >= ? AND CAST(strftime('%H', created_at) AS INTEGER) < ?", [$hour, $hour + 2])
                ->count();
            $views[] = $viewsCount;
            
            $visitorCount = ViewLog::whereDate('created_at', $today)
                ->whereRaw("CAST(strftime('%H', created_at) AS INTEGER) >= ? AND CAST(strftime('%H', created_at) AS INTEGER) < ?", [$hour, $hour + 2])
                ->distinct('ip_address')
                ->count();
            $visitors[] = $visitorCount;
            
            $commentCount = Komentar::whereDate('created_at', $today)
                ->whereRaw("CAST(strftime('%H', created_at) AS INTEGER) >= ? AND CAST(strftime('%H', created_at) AS INTEGER) < ?", [$hour, $hour + 2])
                ->count();
            $comments[] = $commentCount;
        }
        
        return [
            'labels' => $hours,
            'views' => $views,
            'visitors' => $visitors,
            'comments' => $comments
        ];
    }

    private function getChartDataWeek()
    {
        $labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $views = [];
        $visitors = [];
        $comments = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            $viewsCount = ViewLog::whereDate('created_at', $date)->count();
            $views[] = $viewsCount;
            
            $visitorCount = ViewLog::whereDate('created_at', $date)
                ->distinct('ip_address')
                ->count();
            $visitors[] = $visitorCount;
            
            $commentCount = Komentar::whereDate('created_at', $date)->count();
            $comments[] = $commentCount;
        }
        
        return [
            'labels' => $labels,
            'views' => $views,
            'visitors' => $visitors,
            'comments' => $comments
        ];
    }

    private function getChartDataMonth()
    {
        $labels = ['1', '5', '10', '15', '20', '25', '30'];
        $days = [1, 5, 10, 15, 20, 25, 30];
        $views = [];
        $visitors = [];
        $comments = [];
        
        foreach ($days as $day) {
            $date = Carbon::now()->setDay($day);
            
            $viewsCount = ViewLog::whereDate('created_at', $date)->count();
            $views[] = $viewsCount;
            
            $visitorCount = ViewLog::whereDate('created_at', $date)
                ->distinct('ip_address')
                ->count();
            $visitors[] = $visitorCount;
            
            $commentCount = Komentar::whereDate('created_at', $date)->count();
            $comments[] = $commentCount;
        }
        
        return [
            'labels' => $labels,
            'views' => $views,
            'visitors' => $visitors,
            'comments' => $comments
        ];
    }

    private function getChartDataYear()
    {
        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'];
        $views = [];
        $visitors = [];
        $comments = [];
        
        for ($month = 1; $month <= 7; $month++) {
            $startDate = Carbon::now()->setMonth($month)->startOfMonth();
            $endDate = Carbon::now()->setMonth($month)->endOfMonth();
            
            $viewsCount = ViewLog::whereBetween('created_at', [$startDate, $endDate])->count();
            $views[] = $viewsCount;
            
            $visitorCount = ViewLog::whereBetween('created_at', [$startDate, $endDate])
                ->distinct('ip_address')
                ->count();
            $visitors[] = $visitorCount;
            
            $commentCount = Komentar::whereBetween('created_at', [$startDate, $endDate])->count();
            $comments[] = $commentCount;
        }
        
        return [
            'labels' => $labels,
            'views' => $views,
            'visitors' => $visitors,
            'comments' => $comments
        ];
    }

    /**
     * Get category performance data
     */
    private function getCategoryPerformance($period)
    {
        $dateFrom = $this->getDateRangeFrom($period);
        
        $categories = Kategori::with('berita')
            ->withCount(['berita' => function($q) use ($dateFrom) {
                $q->where('status_berita', 'Published')
                  ->whereDate('created_at', '>=', $dateFrom);
            }])
            ->get();
        
        $maxViews = 0;
        $categoryData = [];
        
        foreach ($categories as $cat) {
            $views = Berita::where('kategori_id', $cat->id)
                ->where('status_berita', 'Published')
                ->whereDate('created_at', '>=', $dateFrom)
                ->sum('jumlah_view');
            
            if ($views > $maxViews) {
                $maxViews = $views;
            }
            
            $categoryData[] = [
                'name' => $cat->nama_kategori,
                'emoji' => '📊', // You can customize emojis per category in database
                'views' => $views,
                'pct' => 0 // Will be calculated next
            ];
        }
        
        // Calculate percentages
        foreach ($categoryData as &$cat) {
            $cat['pct'] = $maxViews > 0 ? round(($cat['views'] / $maxViews) * 100) : 0;
        }
        
        // Sort by views descending
        usort($categoryData, function($a, $b) {
            return $b['views'] - $a['views'];
        });
        
        return array_slice($categoryData, 0, 8); // Top 8 categories
    }

    /**
     * Get heatmap data for best publishing times
     */
    private function getHeatmapData($period)
    {
        $dateFrom = $this->getDateRangeFrom($period);
        
        // Heatmap data based on views per hour per day
        // SQLite strftime '%w' returns 0=Sunday, 1=Monday, ... 6=Saturday
        $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];  // Indonesian: Sun, Mon, Tue, Wed, Thu, Fri, Sat
        $hours = ['06', '09', '12', '15', '18', '21'];
        $intensities = [];
        
        // Iterate through each day (0=Sunday to 6=Saturday in SQLite)
        for ($dayIndex = 0; $dayIndex < 7; $dayIndex++) {
            $dayIntensities = [];
            for ($hourIndex = 0; $hourIndex < 6; $hourIndex++) {
                $hour = intval($hours[$hourIndex]);
                
                // Get actual viewlog data using SQLite-compatible functions
                $views = ViewLog::whereDate('created_at', '>=', $dateFrom)
                    ->whereRaw("CAST(strftime('%w', created_at) AS INTEGER) = ?", [$dayIndex])
                    ->whereRaw("CAST(strftime('%H', created_at) AS INTEGER) = ?", [$hour])
                    ->count();
                
                // Normalize to 0-1 scale
                $intensity = min($views / 1000, 1.0);
                $dayIntensities[] = $intensity;
            }
            $intensities[] = $dayIntensities;
        }
        
        return [
            'days' => $days,
            'hours' => $hours,
            'intensities' => $intensities
        ];
    }

    /**
     * Helper: Get date range start based on period
     */
    private function getDateRangeFrom($period)
    {
        return match ($period) {
            'today' => Carbon::today(),
            'week' => Carbon::now()->subDays(7),
            'month' => Carbon::now()->subDays(30),
            'year' => Carbon::now()->subMonths(12),
            default => Carbon::now()->subDays(7),
        };
    }

    /**
     * Helper: Determine trend direction
     */
    private function getTrend($views)
    {
        // Simple logic - in production, compare with previous period
        if ($views > 30000) return 'up';
        if ($views < 15000) return 'down';
        return 'stable';
    }
}
