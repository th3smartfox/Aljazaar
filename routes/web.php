<?php

use App\Http\Controllers\Admin\AccessLocationPageController;
use App\Http\Controllers\Admin\AddAddressPageController;
use App\Http\Controllers\Admin\CardDetailsPageController;
use App\Http\Controllers\Admin\CartPageContentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChangeInformationPageController;
use App\Http\Controllers\Admin\CheckoutPageContentController;
use App\Http\Controllers\Admin\DrawerPageController;
use App\Http\Controllers\Admin\HomePageContentController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\NewOrderPageController;
use App\Http\Controllers\Admin\OrderCustomizationPageController;
use App\Http\Controllers\Admin\OtpPageController;
use App\Http\Controllers\Admin\PersonalInformationPageController;
use App\Http\Controllers\Admin\PhoneNumberPageController;
use App\Http\Controllers\Admin\ProfilePageController;
use App\Http\Controllers\Admin\SelectCityPageController;
use App\Http\Controllers\Admin\SplashScreenController;
use App\Http\Controllers\Admin\SuccessfulPageController;
use App\Http\Controllers\Admin\WalletPageController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\UserController;

require __DIR__ . '/auth.php';

Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    Route::get('', [RoutingController::class, 'index'])->name('root');
    Route::get('/profile', [RegisteredUserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [RegisteredUserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/change-password', [RegisteredUserController::class, 'changePassword'])->name('user.change-password');
    Route::get('/home', fn() => view('index'))->name('home');
    // Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    // Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    // Route::get('{any}', [RoutingController::class, 'root'])->name('any');

    // User Management
    Route::group(['middleware' => ['can:user_management']], function () {
        Route::resource('user-management', UserController::class);
        Route::resource('role-management', RoleController::class);
    });


    // Category Management
    Route::resource('categories', CategoryController::class);

    // NEW: Item Management
    Route::resource('items', ItemController::class);


    // --- NEW: Splash Screen CRUD (Dynamic Content) ---
    Route::resource('splash-screens', SplashScreenController::class);
    Route::resource('select-city-pages', SelectCityPageController::class);
    Route::resource('phone-number-pages', PhoneNumberPageController::class);
    Route::resource('otp-pages', OtpPageController::class);
    Route::resource('profile-pages', ProfilePageController::class);
    Route::resource('home-page-contents', HomePageContentController::class);
    Route::resource('new-order-pages', NewOrderPageController::class);
    Route::resource('order-customization-pages', OrderCustomizationPageController::class);
    Route::resource('cart-page-contents', CartPageContentController::class);
    Route::resource('checkout-page-contents', CheckoutPageContentController::class);
    Route::resource('add-address-pages', AddAddressPageController::class);
    Route::resource('access-location-pages', AccessLocationPageController::class);
    Route::resource('card-details-pages', CardDetailsPageController::class);
    Route::resource('successful-pages', SuccessfulPageController::class);
    Route::resource('drawer-pages', DrawerPageController::class);
    Route::resource('wallet-pages', WalletPageController::class);
    Route::resource('change-information-pages', ChangeInformationPageController::class);
    Route::resource('personal-information-pages', PersonalInformationPageController::class);
});
