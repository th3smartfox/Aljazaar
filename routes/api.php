<?php

use App\Http\Controllers\Api\AccessLocationPageController;
use App\Http\Controllers\Api\AddAddressPageController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\CardDetailsPageController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartPageContentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChangeInformationPageController;
use App\Http\Controllers\Api\CheckoutPageContentController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\DrawerPageController;
use App\Http\Controllers\Api\HomePageContentController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\NewOrderPageController;
use App\Http\Controllers\Api\OrderCustomizationPageController;
use App\Http\Controllers\Api\OtpPageController;
use App\Http\Controllers\Api\PersonalInformationPageController;
use App\Http\Controllers\Api\PhoneNumberPageController;
use App\Http\Controllers\Api\ProfilePageController;
use App\Http\Controllers\Api\SelectCityPageController;
use App\Http\Controllers\Api\SplashScreenController;
use App\Http\Controllers\Api\SuccessfulPageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletPageController;
use App\Http\Controllers\Api\SignupPageController;
use App\Http\Controllers\Api\SigninPageController;
use App\Http\Controllers\Api\ForgotPasswordPageController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/cities', [CityController::class, 'index']);
Route::get('/content/splash-screen', [SplashScreenController::class, 'getSplash']);
Route::get('/content/select-city-page', [SelectCityPageController::class, 'getCityPageContent']);
Route::get('/content/phone-number-page', [PhoneNumberPageController::class, 'getPageContent']);
Route::get('/content/otp-page', [OtpPageController::class, 'getOtpPageContent']);
Route::get('/content/profile-page', [ProfilePageController::class, 'getPageContent']);
Route::get('/content/home-page', [HomePageContentController::class, 'getPageContent']);
Route::get('/content/new-order-page', [NewOrderPageController::class, 'getPageContent']);
Route::get('/content/order-customization-page', [OrderCustomizationPageController::class, 'getPageContent']);
Route::get('/content/cart-page', [CartPageContentController::class, 'getPageContent']);
Route::get('/content/checkout-page', [CheckoutPageContentController::class, 'getPageContent']);
Route::get('/content/add-address-page', [AddAddressPageController::class, 'getPageContent']);
Route::get('/content/access-location-page', [AccessLocationPageController::class, 'getPageContent']);
Route::get('/content/card-details-page', [CardDetailsPageController::class, 'getPageContent']);
Route::get('/content/successful-page', [SuccessfulPageController::class, 'getPageContent']);
Route::get('/content/drawer-page', [DrawerPageController::class, 'getPageContent']);
Route::get('/content/wallet-page', [WalletPageController::class, 'getPageContent']);
Route::get('/content/change-information-page', [ChangeInformationPageController::class, 'getPageContent']);
Route::get('/content/personal-information-page', [PersonalInformationPageController::class, 'getPageContent']);
Route::get('/content/signup-page', [SignupPageController::class, 'getPageContent']);
Route::get('/content/signin-page', [SigninPageController::class, 'getPageContent']);
Route::get('/content/forgot-password-page', [ForgotPasswordPageController::class, 'getPageContent']);

// --- PUBLIC ROUTES (Login/Register) ---
// User controller 
Route::post('/verify-otp', [UserController::class, 'verifyOtp']);
Route::post('/signup-check', [UserController::class, 'signUpCheck']);
Route::post('/login-check', [UserController::class, 'logInCheck']);


// --- NEW: Public Item Routes ---
Route::get('/items', [ItemController::class, 'index']);
Route::get('/items/search', [ItemController::class, 'search']);
Route::get('/items/{item}', [ItemController::class, 'show']);

// --- NEW: Public Category Routes ---
Route::get('/categories/new-order', [CategoryController::class, 'newOrder']);
Route::get('/categories/items/{categoryId}', [CategoryController::class, 'itemsByCategory']);


// --- PROTECTED ROUTES ---
Route::middleware('auth:sanctum')->group(function () {

    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::post('/profile/image', [UserController::class, 'uploadProfileImage']);
    Route::get('/user', [UserController::class, 'getUser']);

    // Logout
    Route::post('/logout', [UserController::class, 'logout']);



    // --- NEW: Cart Module Routes ---
    Route::get('/cart', [CartController::class, 'getCart']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::put('/cart/update', [CartController::class, 'updateCartItem']);
    Route::delete('/cart/remove', [CartController::class, 'removeCartItem']);

    // --- NEW: Checkout Module Routes ---
    Route::get('/checkout/init', [\App\Http\Controllers\Api\CheckoutController::class, 'init']);


    // --- NEW: Address Module Routes ---
    Route::apiResource('addresses', AddressController::class);
    Route::patch('/addresses/{address}/set-default', [AddressController::class, 'setDefault']);

    // --- NEW: Wishlist Module Routes ---
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);

    // --- NEW: Chat Module Routes ---
    Route::get('/chat/messages', [ChatController::class, 'index']);
    Route::post('/chat/send', [ChatController::class, 'store']);

    // --- NEW: Order Module Routes ---
    Route::post('/orders/create', [\App\Http\Controllers\Api\OrderController::class, 'createOrder']);
    Route::get('/orders/active', [\App\Http\Controllers\Api\OrderController::class, 'getActiveOrders']);
    Route::get('/orders/closed', [\App\Http\Controllers\Api\OrderController::class, 'getClosedOrders']);
    Route::get('/orders/{order}', [\App\Http\Controllers\Api\OrderController::class, 'trackOrder']);
    Route::post('/orders/{order}/reorder', [\App\Http\Controllers\Api\OrderController::class, 'reorder']);

    // --- NEW: Payment Module Routes ---
    Route::post('/payments/complete', [\App\Http\Controllers\Api\PaymentController::class, 'completePayment']);
});
