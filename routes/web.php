<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\Admin\WithdrawalController;

Route::view('/', 'index')->name('index');

/*
|--------------------------------------------------------------------------
| Route yang wajib login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile-donatur', [UserController::class, 'donaturProfile'])->name('donatur.profile');

    // Donasi wajib login
    Route::post('/donation/{campaign}', [DonationController::class, 'store'])->name('donation.store');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::group([
    'middleware' => 'auth',
    'prefix' => 'admin',
    'as' => 'admin.'
], function(){

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/logs', [DashboardController::class, 'activity_logs'])->name('logs');
    Route::post('/logs/delete', [DashboardController::class, 'delete_logs'])->name('logs.delete');

    Route::post('/category/store', [PostController::class, 'category_save'])->name('category.store');

    Route::group(['prefix' => 'article', 'as' => 'article.'], function() {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::view('/new', 'admin.posts.create')->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::post('/{post}/update', [PostController::class, 'update'])->name('update');
        Route::post('/{post}/destroy', [PostController::class, 'destroy'])->name('destroy');
    });
    
    Route::group(['prefix' => 'campaign', 'as' => 'campaign.'], function() {
        Route::get('/', [CampaignController::class, 'index'])->name('index');
        Route::view('/new', 'admin.campaign.create')->name('create');
        Route::post('/store', [CampaignController::class, 'store'])->name('store');
        Route::get('/{campaign}/edit', [CampaignController::class, 'edit'])->name('edit');
        Route::post('/{campaign}/update', [CampaignController::class, 'update'])->name('update');
        Route::post('/{campaign}/destroy', [CampaignController::class, 'destroy'])->name('destroy');
    });

    Route::get('/donation', [DonationController::class, 'index'])->name('donation');

    Route::group(['prefix' => 'withdrawals', 'as' => 'withdrawal.'], function() {
        Route::get('/', [WithdrawalController::class, 'index'])->name('index');
        Route::get('/create', [WithdrawalController::class, 'create'])->name('create');
        Route::post('/store', [WithdrawalController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/download', [ReportController::class, 'download'])->name('download');
    });

    Route::group(['prefix' => 'contact', 'as' => 'contact.'], function() {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/read/{contact}', [ContactController::class, 'show'])->name('show');
        Route::post('/reply/{contact}', [ContactController::class, 'reply'])->name('reply');
        Route::post('/destroy/{contact}', [ContactController::class, 'destroy'])->name('destroy');
        Route::post('/bulk_delete', [ContactController::class, 'bulkDelete'])->name('bulk_delete');
    });
    
    Route::view('/profile', 'admin.profile')->name('profile');
    Route::post('/profile', [DashboardController::class, 'profile_update'])->name('profile');
    Route::post('/profile/upload', [DashboardController::class, 'upload_avatar'])->name('profile.upload');
});

/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
*/
Route::get('/api/donatur', [CampaignController::class, 'donatur'])->name('api.donatur');

/*
|--------------------------------------------------------------------------
| Artikel
|--------------------------------------------------------------------------
*/
Route::get('/artikel/{post:slug}', [PostController::class, 'show'])->name('blog.show');
Route::get('/search', [PostController::class, 'search'])->name('blog.search');
Route::get('/penulis/{author}', [PostController::class, 'author'])->name('blog.author');
Route::get('/kategori/{category:slug}', [PostController::class, 'category'])->name('blog.category');

/*
|--------------------------------------------------------------------------
| Campaign
|--------------------------------------------------------------------------
*/
Route::get('/campaign/{campaign:slug}', [CampaignController::class, 'show'])->name('campaign.show');
Route::get('/success/{donation}', [DonationController::class, 'success'])->name('donation.success');

/*
|--------------------------------------------------------------------------
| Contact Public
|--------------------------------------------------------------------------
*/
Route::view('/contact', 'contact')->name('contact');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('auth')
    ->name('contact.store');

require __DIR__.'/auth.php';