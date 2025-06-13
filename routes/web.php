<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;

use App\Http\Controllers\Admin\MatkaController;
use App\Http\Controllers\Admin\GameResultController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PaymentRequestController;
use App\Http\Controllers\Admin\GameRateController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\GlobalSupportController;
use App\Http\Controllers\Admin\SattaController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\BonusController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SattaHomeController;
use App\Http\Controllers\BidHistoryController;
use App\Http\Controllers\FundsController;
use App\Http\Controllers\GetSupportController;

use Illuminate\Support\Facades\Route;
// use Spatie\Permission\Middlewares\RoleMiddleware;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache Cleared Successfully!";
});

Route::get('/', function () {
    return view('home');
});

Route::get('/createrole', [RolePermissionController::class, 'index']);


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:CUSTOMER'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/game-mode/{id}', [HomeController::class, 'game_mode'])->name('game.mode');

    Route::get('/single-digit/{id}', [HomeController::class, 'single_digit'])->name('single.digit');
    Route::post('/single-digit', [HomeController::class, 'single_digit_store'])->name('single.digit.store');

    Route::get('/jodi/{id}', [HomeController::class, 'jodi'])->name('jodi');
    Route::post('/jodi', [HomeController::class, 'jodi_store'])->name('jodi.store');

    Route::get('/single-pana/{id}', [HomeController::class, 'single_pana'])->name('single.pana');
    Route::post('/single-pana', [HomeController::class, 'single_pana_store'])->name('single.pana.store');

    Route::get('/double-pana/{id}', [HomeController::class, 'double_pana'])->name('double.pana');
    Route::post('/double-pana', [HomeController::class, 'double_pana_store'])->name('double.pana.store');

    Route::get('/triple-pana/{id}', [HomeController::class, 'triple_pana'])->name('triple.pana');
    Route::post('/triple-pana', [HomeController::class, 'triple_pana_store'])->name('triple.pana.store');

    Route::get('/odd-even/{id}', [HomeController::class, 'odd_even'])->name('odd.even');
    Route::post('/odd-even', [HomeController::class, 'odd_even_store'])->name('odd.even.store');

    Route::get('/my-bids', [BidHistoryController::class, 'index'])->name('my.bids');
    Route::get('/bid-history', [BidHistoryController::class, 'bid_history'])->name('bid.history');
    Route::post('/bid-history-filter', [BidHistoryController::class, 'bid_history_filter'])->name('bid.history.filter');
    Route::get('/passbook', [BidHistoryController::class, 'passbook'])->name('passbook');
    Route::get('/game-result', [BidHistoryController::class, 'game_result'])->name('game.result');
    Route::post('/get-game-result', [BidHistoryController::class, 'get_game_result'])->name('get.game.result');

    Route::get('/funds', [FundsController::class, 'funds'])->name('funds');
    Route::get('/add-fund', [FundsController::class, 'add_fund'])->name('add.fund');
    Route::get('/add-cash', [FundsController::class, 'add_cash'])->name('add.cash');
    Route::post('/payment-request-store', [FundsController::class, 'payment_request_store'])->name('payment.request.store');
    Route::get('/fund-history', [FundsController::class, 'fund_history'])->name('fund.history');
    Route::get('/bank-detail', [FundsController::class, 'bank_detail'])->name('bank.detail');
    Route::post('/bank-detail', [FundsController::class, 'bank_detail_store'])->name('bank.detail.store');
    Route::get('/game-rate', [FundsController::class, 'game_rate'])->name('game.rate');
    Route::get('/withdraw-fund', [FundsController::class, 'withdraw_fund'])->name('withdraw.fund');
    Route::post('/withdraw-fund-store', [FundsController::class, 'withdraw_fund_store'])->name('withdraw.fund.store');
    Route::get('/withdraw-fund-history', [FundsController::class, 'withdraw_fund_history'])->name('withdraw.fund.history');

    Route::get('/satta-home', [SattaHomeController::class, 'index'])->name('satta.home');
    Route::get('/satta-game-mode/{id}', [SattaHomeController::class, 'game_mode'])->name('satta.game.mode');

    Route::get('/satta-jodi/{id}/{mode_id}', [SattaHomeController::class, 'jodi'])->name('satta.jodi');
    Route::post('/satta-jodi', [SattaHomeController::class, 'satta_jodi_store'])->name('satta.jodi.store');

    Route::get('/satta-andarharuf/{id}/{mode_id}', [SattaHomeController::class, 'andarharuf'])->name('satta.andarharuf');
    Route::get('/satta-baharharuf/{id}/{mode_id}', [SattaHomeController::class, 'baharharuf'])->name('satta.baharharuf');
    Route::get('/satta-crossing/{id}/{mode_id}', [SattaHomeController::class, 'crossing'])->name('satta.crossing');
    Route::get('/satta-cut-crossing/{id}/{mode_id}', [SattaHomeController::class, 'cut_crossing'])->name('satta.cut.crossing');

    Route::get('/satta-bid-history', [BidHistoryController::class, 'satta_bid_history'])->name('satta.bid.history');
    Route::post('/satta-bid-history-filter', [BidHistoryController::class, 'satta_bid_history_filter'])->name('satta.bid.history.filter');
    Route::get('/satta-game-result', [BidHistoryController::class, 'satta_game_result'])->name('satta.game.result');
    Route::post('/satta-get-game-result', [BidHistoryController::class, 'get_satta_game_result'])->name('get.satta.game.result');

    Route::resource('get-support', GetSupportController::class);
});

Route::middleware(['auth', 'verified', 'role:ADMIN|PARTNER'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('createpermissions', [PermissionController::class, 'createpermissions'])->name('createpermissions');

    Route::resource('matka_game', MatkaController::class);
    Route::get('matka_game_bid/{id}', [MatkaController::class, 'show_bid'])->name('matka.game.bid');
    Route::get('matka_game_panel_chart/{id}', [MatkaController::class, 'panel_chart'])->name('matka.game.panel.chart');
    Route::get('matka_game_jodi_chart/{id}', [MatkaController::class, 'jodi_chart'])->name('matka.game.jodi.chart');

    Route::resource('game_result', GameResultController::class);
    Route::post('game_result_by_date', [GameResultController::class, 'getResultByDate']);
    Route::post('game_satta_result_by_date', [GameResultController::class, 'getSattaResultByDate']);

    Route::get('/account-detail', [SettingController::class, 'account_detail'])->name('account.detail');
    Route::post('/account-detail-store', [SettingController::class, 'account_detail_store'])->name('account.detail.store');

    Route::get('/payment-request-list', [PaymentRequestController::class, 'payment_request_list'])->name('payment.request.list');
    Route::post('/payment-status', [PaymentRequestController::class, 'payment_status'])->name('payment.status');

    Route::get('/withdraw-request-list', [PaymentRequestController::class, 'withdraw_request_list'])->name('withdraw.request.list');
    Route::post('/withdraw-status', [PaymentRequestController::class, 'withdraw_status'])->name('withdraw.status');

    Route::resource('game_rate', GameRateController::class);
    Route::resource('user', UserController::class);
    Route::post('/user-manual-payment', [UserController::class, 'user_manual_payment'])->name('user.manual.payment');
    Route::get('/user-history/{id}', [UserController::class, 'user_history'])->name('user.history');

    Route::resource('global_support', GlobalSupportController::class);
    Route::resource('support', SupportController::class);

    Route::resource('satta_game', SattaController::class);
    Route::get('satta_game_bid/{id}', [SattaController::class, 'show_bid'])->name('satta.game.bid');
    Route::get('satta_game_result_chart/{id}', [SattaController::class, 'result_chart'])->name('satta.game.result.chart');

    Route::post('satta_game_result_store', [GameResultController::class, 'satta_game_result_store'])->name('satta.game.result.store');

    Route::resource('notification', NotificationController::class);
    Route::resource('bonus', BonusController::class);

    Route::post('partner/user/transfer', [PartnerController::class, 'user_transfer'])->name('partner.user.transfer');
    Route::resource('partner', PartnerController::class);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
