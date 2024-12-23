<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;


// Admin Routes
use App\Http\Controllers\Admin\{
    AdminUserController,
    AdminAuthController,
    PageController,
    ContactController,
    NotificationController,
    LocationController,
    BranchController,
    BankController,
    GroupsController,
    ItemController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| These routes are loaded by the RouteServiceProvider within a group
| that contains the "web" middleware group. Now create something great!
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Authentication Routes
    Route::controller(AdminAuthController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('login', 'login')->name('login');
        Route::post('login', 'postLogin')->name('login.post');
        Route::get('forget-password', 'showForgetPasswordForm')->name('forget.password.get');
        Route::post('forget-password', 'submitForgetPasswordForm')->name('forget.password.post');
        Route::get('reset-password/{token}', 'showResetPasswordForm')->name('reset.password.get');
        Route::post('reset-password', 'submitResetPasswordForm')->name('reset.password.post');
    });

    // Protected Routes (Admin Middleware)
    Route::middleware(['admin'])->group(function () {
        Route::controller(AdminAuthController::class)->group(function () {
            Route::get('dashboard', 'adminDashboard')->name('dashboard');
            Route::get('change-password', 'changePassword')->name('change.password');
            Route::post('update-password', 'updatePassword')->name('update.password');
            Route::get('logout', 'logout')->name('logout');
            Route::get('profile', 'adminProfile')->name('profile');
            Route::post('profile', 'updateAdminProfile')->name('update.profile');
        });

        // User Management
        Route::prefix('users')->name('users.')->controller(AdminUserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/alluser', 'getallUser')->name('alluser');
            Route::post('/status', 'userStatus')->name('status');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
            Route::get('/{id}', 'show')->name('show');
        });

        // Contact Management
        Route::prefix('contacts')->name('contacts.')->controller(ContactController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/all', 'getallcontact')->name('allcontact');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });

        // Page Management
        Route::prefix('page')->name('page.')->controller(PageController::class)->group(function () {
            Route::get('/create/{key}', 'create')->name('create');
            Route::put('/update/{key}', 'update')->name('update');
        });

        // Notifications
        Route::prefix('notifications')->name('notifications.')->controller(NotificationController::class)->group(function () {
            Route::get('/index', 'index')->name('index');
            Route::get('/clear', 'clear')->name('clear');
            Route::delete('/delete/{id}', 'destroy')->name('destroy');
        });

        // Master Route
        // Resource Management Routes (Variation, Tax, Item, Vendor, Customer)
        foreach (['location','branch','bank','account','area','dealer','mesurment','groups','method','departmenttype','departmentlevel','item'] as $resource) {
            Route::prefix($resource)->name("$resource.")->group(function () use ($resource) {
                $controller = "App\Http\Controllers\Admin\\" . ucfirst($resource) . "Controller";
                Route::get('/', [$controller, 'index'])->name('index');
                Route::get('all', [$controller, 'getall'])->name('getall');
                Route::post('store', [$controller, 'store'])->name('store');
                Route::post('status', [$controller, 'status'])->name('status');
                Route::delete('delete/{id}', [$controller, 'destroy'])->name('destroy');
                Route::get('get/{id}', [$controller, 'get'])->name('get');
                Route::post('update', [$controller, 'update'])->name('update');
            });
        }
    });
});

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    // Add authenticated user routes here
});
