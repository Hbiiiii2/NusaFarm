<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\GamificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetaniController;
use App\Http\Controllers\ManajerLapanganController;
use App\Http\Controllers\LogistikController;
use App\Http\Controllers\PenyediaPupukController;
use App\Http\Controllers\PedagangPasarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Investment Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/investments', [InvestmentController::class, 'index'])->name('investments.index');
    Route::get('/investments/create/{farmland}', [InvestmentController::class, 'create'])->name('investments.create');
    Route::post('/investments/{farmland}', [InvestmentController::class, 'store'])->name('investments.store');
    Route::get('/investments/show/{investment}', [InvestmentController::class, 'show'])->name('investments.show');
    Route::get('/investments/portfolio', [InvestmentController::class, 'portfolio'])->name('investments.portfolio');
});

// Wallet Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/topup', [WalletController::class, 'topup'])->name('wallet.topup');
    Route::post('/wallet/process-topup', [WalletController::class, 'processTopup'])->name('wallet.process-topup');
    Route::get('/wallet/withdrawal', [WalletController::class, 'withdrawal'])->name('wallet.withdrawal');
    Route::post('/wallet/process-withdrawal', [WalletController::class, 'processWithdrawal'])->name('wallet.process-withdrawal');
    Route::get('/wallet/transactions', [WalletController::class, 'transactions'])->name('wallet.transactions');
});

// Gamification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/gamification/dashboard', [GamificationController::class, 'dashboard'])->name('gamification.dashboard');
    Route::get('/gamification/missions', [GamificationController::class, 'missions'])->name('gamification.missions');
    Route::get('/gamification/badges', [GamificationController::class, 'badges'])->name('gamification.badges');
    Route::get('/gamification/leaderboard', [GamificationController::class, 'leaderboard'])->name('gamification.leaderboard');
    Route::post('/gamification/complete-mission', [GamificationController::class, 'completeMission'])->name('gamification.complete-mission');
});
Route::post('/gamification/water-plant', function () {
    $user = auth()->user();
    $cooldownMinutes = 5; // Cooldown time in minutes
    if ($user->last_watered_at && $user->last_watered_at->addMinutes($cooldownMinutes)->isFuture()) {
        return back()->with('error', 'Anda harus menunggu sebelum bisa menyiram tanaman lagi.');
    }
    $xpReward = 5;
    $user->addXp($xpReward);
    $user->update(['last_watered_at' => now()]);
    return back()->with('success', "Anda menyiram tanaman dan mendapatkan {$xpReward} XP!");
})->name('gamification.water-plant');

// Projects Routes
Route::get('/projects', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Farmland::with(['landlord', 'readyForInvestmentBy']);

    // Only show farmlands ready for investment
    $query->where('status', 'ready_for_investment');

    // Text search across location, crop type, and landlord name
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('location', 'like', "%$search%")
                ->orWhere('crop_type', 'like', "%$search%")
                ->orWhereHas('landlord', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%");
                });
        });
    }

    // Category (crop type) filter
    $category = $request->category;
    if ($category && $category !== 'all') {
        $query->where('crop_type', $category);
    }

    // Numeric filters
    if ($request->filled('min_investment')) {
        $query->where('minimum_investment_amount', '>=', (int) $request->get('min_investment'));
    }
    if ($request->filled('max_investment')) {
        $query->where('minimum_investment_amount', '<=', (int) $request->get('max_investment'));
    }
    if ($request->filled('size_min')) {
        $query->where('size', '>=', (float) $request->get('size_min'));
    }
    if ($request->filled('size_max')) {
        $query->where('size', '<=', (float) $request->get('size_max'));
    }

    // Sorting
    $sort = $request->get('sort');
    switch ($sort) {
        case 'min_investment_asc':
            $query->orderBy('minimum_investment_amount', 'asc');
            break;
        case 'min_investment_desc':
            $query->orderBy('minimum_investment_amount', 'desc');
            break;
        case 'required_asc':
            $query->orderBy('required_investment_amount', 'asc');
            break;
        case 'required_desc':
            $query->orderBy('required_investment_amount', 'desc');
            break;
        case 'size_asc':
            $query->orderBy('size', 'asc');
            break;
        case 'size_desc':
            $query->orderBy('size', 'desc');
            break;
        case 'period_asc':
            $query->orderBy('investment_period_months', 'asc');
            break;
        case 'period_desc':
            $query->orderBy('investment_period_months', 'desc');
            break;
        default:
            // Keep default ordering (no explicit order)
            break;
    }

    // Count before pagination for UI stats
    $totalFarmlands = (clone $query)->count();

    $farmlands = $query->paginate(12);
    // Preserve filters in pagination links
    $farmlands->appends($request->query());

    return view('projects.index', [
        'farmlands' => $farmlands,
        'search' => $request->search,
        'category' => $category,
        'sort' => $sort,
        'min_investment' => $request->get('min_investment'),
        'max_investment' => $request->get('max_investment'),
        'size_min' => $request->get('size_min'),
        'size_max' => $request->get('size_max'),
        'totalFarmlands' => $totalFarmlands,
    ]);
})->name('projects.index');

Route::get('/projects/{farmland}', function (\App\Models\Farmland $farmland) {
    // Ensure the farmland is ready for investment
    if ($farmland->status !== 'ready_for_investment') {
        abort(404, 'Farmland not available for investment.');
    }
    
    return view('projects.show', compact('farmland'));
})->name('projects.show');

// Notifications Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', function () {
        $notifications = auth()->user()->notifications()->latest()->paginate(20);
        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');

    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);
        return back()->with('success', 'All notifications marked as read.');
    })->name('notifications.mark-all-read');

    Route::patch('/notifications/{notification}/read', function (\App\Models\Notification $notification) {
        // Ensure the notification belongs to the authenticated user
        if ($notification->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $notification->update(['read_at' => now()]);
        return back()->with('success', 'Notification marked as read.');
    })->name('notifications.read');
});

// Landlord Routes
Route::middleware(['auth', 'role:landlord'])->prefix('landlord')->name('landlord.')->group(function () {
    Route::get('/dashboard', [LandlordController::class, 'dashboard'])->name('dashboard');
    Route::get('/farmlands', [LandlordController::class, 'farmlands'])->name('farmlands');
    Route::get('/farmlands/create', [LandlordController::class, 'createFarmland'])->name('farmlands.create');
    Route::post('/farmlands', [LandlordController::class, 'storeFarmland'])->name('farmlands.store');
    Route::get('/farmlands/{farmland}', [LandlordController::class, 'showFarmland'])->name('farmlands.show');
    Route::get('/farmlands/{farmland}/edit', [LandlordController::class, 'editFarmland'])->name('farmlands.edit');
    Route::put('/farmlands/{farmland}', [LandlordController::class, 'updateFarmland'])->name('farmlands.update');
    Route::get('/progress-reports', [LandlordController::class, 'progressReports'])->name('progress-reports');
    Route::get('/collaboration-history', [LandlordController::class, 'collaborationHistory'])->name('collaboration-history');
    Route::get('/documents', [LandlordController::class, 'documents'])->name('documents');
    Route::get('/chat', [LandlordController::class, 'chat'])->name('chat');
    Route::post('/chat/send', [LandlordController::class, 'sendMessage'])->name('chat.send');
});

// Petani Routes
Route::middleware(['auth', 'role:petani'])->prefix('petani')->name('petani.')->group(function () {
    Route::get('/dashboard', [PetaniController::class, 'dashboard'])->name('dashboard');
    Route::get('/daily-reports', [PetaniController::class, 'dailyReports'])->name('daily-reports');
    Route::get('/daily-reports/create', [PetaniController::class, 'createDailyReport'])->name('daily-reports.create');
    Route::post('/daily-reports', [PetaniController::class, 'storeDailyReport'])->name('daily-reports.store');
    Route::get('/supply-requests', [PetaniController::class, 'supplyRequests'])->name('supply-requests');
    Route::get('/supply-requests/create', [PetaniController::class, 'createSupplyRequest'])->name('supply-requests.create');
    Route::post('/supply-requests', [PetaniController::class, 'storeSupplyRequest'])->name('supply-requests.store');
    Route::get('/chat', [PetaniController::class, 'chat'])->name('chat');
    Route::post('/chat/send', [PetaniController::class, 'sendMessage'])->name('chat.send');
});

// Manajer Lapangan Routes
Route::middleware(['auth', 'role:manajer_lapangan'])->prefix('manajer')->name('manajer.')->group(function () {
    Route::get('/dashboard', [ManajerLapanganController::class, 'dashboard'])->name('dashboard');
    Route::get('/farmlands', [ManajerLapanganController::class, 'farmlands'])->name('farmlands');
    Route::get('/farmlands/{farmland}/setup', [ManajerLapanganController::class, 'setupFarmland'])->name('farmlands.setup');
    Route::post('/farmlands/{farmland}/ready-for-investment', [ManajerLapanganController::class, 'makeReadyForInvestment'])->name('farmlands.ready-for-investment');
    Route::get('/reports', [ManajerLapanganController::class, 'reports'])->name('reports');
    Route::get('/reports/{report}', [ManajerLapanganController::class, 'showReport'])->name('reports.show');
    Route::post('/reports/{report}/approve', [ManajerLapanganController::class, 'approveReport'])->name('reports.approve');
    Route::post('/reports/{report}/reject', [ManajerLapanganController::class, 'rejectReport'])->name('reports.reject');
    Route::get('/supply-requests', [ManajerLapanganController::class, 'supplyRequests'])->name('supply-requests');
    Route::post('/supply-requests/{request}/approve', [ManajerLapanganController::class, 'approveSupplyRequest'])->name('supply-requests.approve');
    Route::post('/supply-requests/{request}/reject', [ManajerLapanganController::class, 'rejectSupplyRequest'])->name('supply-requests.reject');
    Route::get('/logistics', [ManajerLapanganController::class, 'logistics'])->name('logistics');
    Route::get('/fertilizer-orders', [ManajerLapanganController::class, 'fertilizerOrders'])->name('fertilizer-orders');
    Route::get('/chat', [ManajerLapanganController::class, 'chat'])->name('chat');
    Route::post('/chat/send', [ManajerLapanganController::class, 'sendMessage'])->name('chat.send');
});

// Logistik Routes
Route::middleware(['auth', 'role:logistik'])->prefix('logistik')->name('logistik.')->group(function () {
    Route::get('/dashboard', [LogistikController::class, 'dashboard'])->name('dashboard');
    Route::get('/deliveries', [LogistikController::class, 'deliveries'])->name('deliveries');
    Route::get('/deliveries/create', [LogistikController::class, 'createDelivery'])->name('deliveries.create');
    Route::post('/deliveries', [LogistikController::class, 'storeDelivery'])->name('deliveries.store');
    Route::post('/deliveries/{logistic}/status', [LogistikController::class, 'updateDeliveryStatus'])->name('deliveries.status');
    Route::get('/chat', [LogistikController::class, 'chat'])->name('chat');
    Route::post('/chat/send', [LogistikController::class, 'sendMessage'])->name('chat.send');
});

// Penyedia Pupuk Routes
Route::middleware(['auth', 'role:penyedia_pupuk'])->prefix('pupuk')->name('pupuk.')->group(function () {
    Route::get('/dashboard', [PenyediaPupukController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [PenyediaPupukController::class, 'orders'])->name('orders');
    Route::get('/orders/create', [PenyediaPupukController::class, 'createOrder'])->name('orders.create');
    Route::post('/orders', [PenyediaPupukController::class, 'storeOrder'])->name('orders.store');
    Route::post('/orders/{order}/status', [PenyediaPupukController::class, 'updateOrderStatus'])->name('orders.status');
    Route::get('/chat', [PenyediaPupukController::class, 'chat'])->name('chat');
    Route::post('/chat/send', [PenyediaPupukController::class, 'sendMessage'])->name('chat.send');
});

// Pedagang Pasar Routes
Route::middleware(['auth', 'role:pedagang_pasar'])->prefix('pedagang')->name('pedagang.')->group(function () {
    Route::get('/dashboard', [PedagangPasarController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [PedagangPasarController::class, 'orders'])->name('orders');
    Route::get('/orders/create', [PedagangPasarController::class, 'createOrder'])->name('orders.create');
    Route::post('/orders', [PedagangPasarController::class, 'storeOrder'])->name('orders.store');
    Route::post('/orders/{order}/confirm', [PedagangPasarController::class, 'confirmReceived'])->name('orders.confirm');
    Route::get('/chat', [PedagangPasarController::class, 'chat'])->name('chat');
    Route::post('/chat/send', [PedagangPasarController::class, 'sendMessage'])->name('chat.send');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::get('/farmlands', [AdminController::class, 'farmlands'])->name('farmlands');
    Route::post('/farmlands/{farmland}/approve', [AdminController::class, 'approveFarmland'])->name('farmlands.approve');
    Route::post('/farmlands/{farmland}/reject', [AdminController::class, 'rejectFarmland'])->name('farmlands.reject');
    Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
    Route::patch('/projects/{project}/status', [AdminController::class, 'updateProjectStatus'])->name('projects.update-status');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/supply-requests', [AdminController::class, 'supplyRequests'])->name('supply-requests');
    Route::get('/chat', [AdminController::class, 'chat'])->name('chat');
    Route::post('/chat/send', [AdminController::class, 'sendMessage'])->name('chat.send');
});

// Chat Routes
Route::middleware(['auth'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::get('/conversation/{user}', [ChatController::class, 'conversation'])->name('conversation');
    Route::post('/send', [ChatController::class, 'sendMessage'])->name('send');
});
