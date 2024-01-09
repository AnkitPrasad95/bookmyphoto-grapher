<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PaymentMethodsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\PayoutController;
use App\Http\Controllers\Admin\CMSController;
use App\Http\Controllers\Admin\MasterServiceController;

use App\Http\Controllers\Provider\ProviderTypeController;
use App\Http\Controllers\Provider\ProviderController;
use App\Http\Controllers\Provider\TimingController;
use App\Http\Controllers\Provider\HandymanController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Service\GalleryImagesController;

use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\FrontUserController;
use App\Http\Controllers\front\ServiceBookController;
use App\Http\Controllers\front\WalletController;
use App\Http\Controllers\Admin\HelpController;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\TestMailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/clear-cache', function() {
   Artisan::call('cache:clear');
   Artisan::call('route:clear');
   Artisan::call('config:clear');
   Artisan::call('view:clear');
   return redirect()->back()->with('success',trans('messages.success'));
});

Route::get('google-autocomplete', [HomeController::class, 'googleAddress']);
Route::post('/store-location', [HomeController::class, 'location_store'])->name('location_store.location');
//Route::post('/store-location', 'LocationController@store')->name('store.location');


Route::get('/', [HomeController::class,'index'])->name('home');
Route::group(['namespace' => 'front' , 'prefix' => 'home'], function () {
   //Route::post('find-service', [HomeController::class,'find_service']);
   Route::get('find-service', [HomeController::class,'find_service']);
   Route::get('find-cities', [HomeController::class,'find_cities']);
   Route::get('terms-condition', [HomeController::class,'tc']);
   Route::get('privacy-policy', [HomeController::class,'policy']);
   Route::get('categories', [HomeController::class,'categories']);
   Route::get('services', [HomeController::class,'services']);
   Route::get('services/{category}', [HomeController::class,'category_services']);
   Route::get('service-details/{service}', [HomeController::class,'service_details']);
   Route::get('providers', [HomeController::class,'providers']);
   Route::get('providers-details/{provider}', [HomeController::class,'provider_details']);
   Route::get('providers-services/{provider}', [HomeController::class,'provider_services']);
   Route::get('providers-rattings/{provider}', [HomeController::class,'provider_rattings']);
   Route::get('search', [HomeController::class,'search']);
   Route::get('instant-booking', [HomeController::class,'instantBooking']);
   Route::post('instant-booking-new', [HomeController::class,'instantBookingNew']);
   Route::get('about-us', [HomeController::class,'aboutus']);
   Route::get('register-user', [UserController::class,'register_user'])->name('register_user');
   Route::post('store-user', [UserController::class,'store_user']);
   Route::get('register-provider', [UserController::class,'register_provider']);
   Route::post('store-provider', [UserController::class,'store_provider']);
   Route::get('test-mail', [TestMailController::class,'sendTestMail']);
   
   Route::get('verify', [UserController::class,'verify_email'])->name('verify');
   Route::get('/resend-otp', [UserController::class,'resend_otp'])->name('resend-otp');
   Route::post('verify/otp', [UserController::class,'verify_otp']);
   
   Route::get('forgot-password', [UserController::class,'forgot_pass']);
   Route::post('send-pass', [UserController::class,'send_pass']);
   Route::post('admin-send-pass', [UserController::class,'admin_send_pass']);
   Route::get('contact-us', [InquiryController::class,'contactus']);
   Route::post('add-inquiry', [InquiryController::class,'add']);
   Route::get('login',[LoginController::class,'index'])->name('login');
   Route::post('checklogin',[LoginController::class,'checklogin']);
});
Route::get('auth/facebook',[LoginController::class,'redirectToFacebook']);
Route::get('auth/facebook/callback',[LoginController::class,'handleFacebookCallback']);
Route::get('auth/google',[LoginController::class,'redirectToGoogle']);
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);
   
Route::group(['middleware'=>'UserMiddleware'],function(){
   Route::get('/home/user/dashboard', [FrontUserController::class,'dashboard'])->name('user_dashboard');
   Route::get('/home/user/reviews', [FrontUserController::class,'reviews']);
   Route::get('/home/user/profile', [FrontUserController::class,'profile'])->name('user_profile');
   Route::post('/home/user/profile/edit', [FrontUserController::class,'edit']);
   Route::get('/home/user/notifications', [FrontUserController::class,'notifications']);
   Route::get('/home/user/clearnotification', [FrontUserController::class,'clearnotification']);
   Route::get('/home/user/change-password', [FrontUserController::class,'changepassform']);
   Route::post('/home/user/changepass', [FrontUserController::class,'changepass']);
   Route::get('/home/help', [HelpController::class,'help_form']);
   Route::post('/home/add-help', [HelpController::class,'add_help']);
   Route::get('/home/user/bookings', [FrontUserController::class,'bookings']);
   Route::get('/home/user/get-bookings', [FrontUserController::class,'get_bookings']);
   Route::get('/home/user/get-bookings-by', [FrontUserController::class,'get_bookings_by']);
   Route::get('/home/user/bookings/{id}', [FrontUserController::class,'booking_details']);
   Route::post('/home/user/bookings/cancel', [ServiceBookController::class,'cancel']);
   Route::get('/home/user/gallery/{id}', [FrontUserController::class,'gallery_details']);
   Route::get('/gallery/download/{file_name}', [FrontUserController::class, 'downloadFile']);
   //Route::get('/home/user/handyman/{id}', [FrontUserController::class,'getHandymanData']);

   Route::post('/home/user/add-rattings', [FrontUserController::class,'addrattings']);

   Route::get('/home/user/wallet', [WalletController::class,'wallet']);
   Route::post('/home/user/wallet/add', [WalletController::class,'wallet_add']);
   Route::post('/home/user/add-address', [FrontUserController::class,'add_address']);
   Route::get('/home/service/continue/{service}', [ServiceBookController::class,'continue_booking']);
   Route::post('/home/service/continue/check-coupon/{service}', [ServiceBookController::class,'check_coupon']);
   Route::post('/home/instant/continue/check-coupon/{photographer}', [ServiceBookController::class,'check_instant_coupon']);
   
   Route::get('/home/remove-coupon/{service}', [ServiceBookController::class,'remove_coupon']);
   Route::get('/home/remove-coupon-instant/{service}', [ServiceBookController::class,'remove_coupon_instant']);
   Route::get('/home/service/continue/checkout/{service}', [ServiceBookController::class,'checkout']);
   Route::post('/home/service/book', [ServiceBookController::class,'book']);
   Route::get('/home/success', [ServiceBookController::class,'success'])->name('booking_success');

   Route::get('/home/stripe_form', [ServiceBookController::class,'stripe_form'])->name('stripe_form');
   Route::post('pay-stripe', [ServiceBookController::class, 'stripe_pay']);
   
   //for instant booking
      Route::get('/home/instant/continue/{photographer}', [ServiceBookController::class,'continue_instant_booking']);
      Route::get('/home/instant/continue/checkout/{photographer}', [ServiceBookController::class,'checkout_instant']);
});

Route::get('/admin',[LoginController::class,'adminlogin'])->name('adminlogin');
Route::get('/admin-forgot-password',[LoginController::class,'admin_forgot_pass'])->name('admin_forgot_pass');
Route::post('/checkadminlogin',[LoginController::class,'checkadminlogin']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('adminlogout', [LoginController::class, 'Adminlogout'])->name('admin.logout');

Route::post('/subscribe',[AdminController::class,'subscribe']);
Route::get('/deleteGalleryImages', [HomeController::class, 'deleteGalleryImages']);
// Route::get('/verification', function () {
//     return view('auth.verification');
// });
// Route::post('systemverification', 'LoginController@systemverification')->name('admin.systemverification');

Route::group(['middleware' =>'AuthMiddleware'],function(){

   Route::get('/dashboard',[AdminController::class,'home'])->name('dashboard');
   Route::post('/profile/edit/{id}',[UserController::class,'editprofile']);
   Route::post('/profile/edit/password/{id}',[UserController::class,'editPassword']);
   Route::post('/payout/update',[PayoutController::class,'update_request']);
   Route::post('/payout/update_cod',[PayoutController::class,'update_cod_request']);
   Route::post('/payout/update_admin_cod',[PayoutController::class,'update_admin_cod_request']);
   Route::get('/bookings',[BookingController::class,'index'])->name('bookings');
   Route::get('/bookings/{booking}',[BookingController::class,'booking_details']);
   Route::get('/payout',[PayoutController::class,'index']);
   Route::get('/cod_payout',[PayoutController::class,'index_cod']);
   
   Route::get('/revenue',[BookingController::class,'revenue'])->name('revenue');

   Route::get('/handymans',[HandymanController::class,'index'])->name('handymans');
   Route::get('/handymans/fetch_handyman',[HandymanController::class,'fetch_handyman'])->name('ajax_handyman');
   Route::get('/handymans/{handyman}',[HandymanController::class,'showhandyman']);

   Route::get('/services',[ServiceController::class,'index'])->name('services');
   Route::get('/services/{service}',[ServiceController::class,'service']);
   Route::post('/services/fetch_chart/{service}',[ServiceController::class,'fetch_chart']);
   Route::get('/services/fetch_service',[ServiceController::class,'fetch_service'])->name('ajax_service');
   Route::get('/gallery',[BookingController::class,'gallery'])->name('galleryList');
   Route::get('/gallery/upload/{booking}',[BookingController::class,'gallery_upload'])->name('gallery');
   Route::get('/gallery/{booking}',[BookingController::class,'gallery_details']);
   
  Route::get('/coupons',[CouponController::class,'index'])->name('coupons');
  Route::get('/coupons/add',[CouponController::class,'add']);
  Route::post('/coupons/store',[CouponController::class,'store']);
  Route::post('/coupons/del',[CouponController::class,'destroy']);
  Route::post('/coupons/edit/status',[CouponController::class,'status']);
  Route::get('/coupons/edit/{id}',[CouponController::class,'show']);
  Route::post('/coupons/edit/{id}',[CouponController::class,'edit']);
  Route::post('/coupons/getServicePhotographer',[CouponController::class,'getServicePhotographer']);
  Route::post('providers/user_availablity',[ProviderController::class,'updateUserAvailablity']); 
  Route::post('services/getServices',[ServiceController::class,'getServices']);

   Route::group(['middleware' =>'AdminMiddleware'],function(){

      Route::get('/log-in-provider/{slug}',[LoginController::class,'log_in_provider']);

      Route::get('/home-settings/home',[SettingController::class,'home_page'])->name('home_page');
      Route::post('/home-settings/home/update',[SettingController::class,'home_page_setting']);
      Route::get('/subscribers',[AdminController::class,'subscribers'])->name('subscribers');
      Route::get('/help',[HelpController::class,'help'])->name('help');
      Route::get('/clearhelp', [HelpController::class,'clearhelp']);
      Route::get('/smtp-configuration', [AdminController::class,'smtp_configuration']);
      Route::post('/env_key_update', 'AdminController@env_key_update')->name('env_key_update.update');
      Route::get('/settings',[SettingController::class,'show'])->name('settings');
      Route::post('/settings/edit',[SettingController::class,'edit']);
      Route::get('/terms-conditions',[CMSController::class,'tc_form'])->name('tc');
      Route::post('/terms-conditions/update',[CMSController::class,'update']);
      Route::get('/privacy-policy',[CMSController::class,'privacy_form'])->name('privacy_policy');
      Route::post('/privacy-policy/update',[CMSController::class,'update_privacy']);
      Route::get('/about',[CMSController::class,'about_form'])->name('about');
      Route::post('/about/update',[CMSController::class,'update_about']);
      Route::get('/providers',[ProviderController::class,'providers'])->name('providers');
      Route::get('/providers/add',[ProviderController::class,'addprovider']);
      Route::post('/providers/store',[ProviderController::class,'storeprovider']);
      Route::post('/providers/edit/status',[ProviderController::class,'providerstatus']);
      Route::post('/providers/del',[ProviderController::class,'destroyprovider']);
      Route::get('/providers/edit/{provider}',[ProviderController::class,'showprovider']);
      Route::post('/providers/edit/{provider}',[ProviderController::class,'editprovider']);
      Route::get('/providers/{provider}',[ProviderController::class,'provider']);
      Route::post('providers/verified_flag',[ProviderController::class,'updateVerifiedFlag']); 
      
       
      Route::get('/provider_types',[ProviderTypeController::class,'index'])->name('provider_types');
      Route::get('/provider_types/add',[ProviderTypeController::class,'add']);
      Route::post('/provider_types/store',[ProviderTypeController::class,'store']);
      Route::post('/provider_types/del',[ProviderTypeController::class,'destroy']);
      Route::post('/provider_types/status',[ProviderTypeController::class,'status']);
      Route::get('/provider_types/edit/{id}',[ProviderTypeController::class,'show']);
      Route::post('/provider_types/edit/{id}',[ProviderTypeController::class,'edit']);

      Route::get('/users',[UserController::class,'users'])->name('users');
      Route::post('/users/edit/status',[UserController::class,'usersstatus']);

      Route::get('/payment-methods',[PaymentMethodsController::class,'index'])->name('payment-methods');
      Route::get('/payment-methods/{id}',[PaymentMethodsController::class,'show']);
      Route::post('/payment-methods/edit/{id}',[PaymentMethodsController::class,'edit']);
      Route::post('/payment-methods/status',[PaymentMethodsController::class,'status']);

      Route::get('/banners',[BannerController::class,'index'])->name('banners');
      Route::get('/banners/add',[BannerController::class,'add']);
      Route::post('/banners/store',[BannerController::class,'store']);
      Route::post('/banners/del',[BannerController::class,'destroy']);
      Route::get('/banners/edit/{id}',[BannerController::class,'show']);
      Route::post('/banners/edit/{id}',[BannerController::class,'edit']);

    //   Route::get('/coupons',[CouponController::class,'index'])->name('coupons');
    //   Route::get('/coupons/add',[CouponController::class,'add']);
    //   Route::post('/coupons/store',[CouponController::class,'store']);
    //   Route::post('/coupons/del',[CouponController::class,'destroy']);
    //   Route::post('/coupons/edit/status',[CouponController::class,'status']);
    //   Route::get('/coupons/edit/{id}',[CouponController::class,'show']);
    //   Route::post('/coupons/edit/{id}',[CouponController::class,'edit']);

      Route::get('/cities',[CityController::class,'index'])->name('cities');
      Route::get('/cities/add',[CityController::class,'add']);
      Route::post('/city/store',[CityController::class,'store']);
      Route::post('/cities/del',[CityController::class,'destroy']);
      Route::post('/cities/edit/status',[CityController::class,'status']);
      Route::get('/cities/edit/{id}',[CityController::class,'show']);
      Route::post('/cities/edit/{id}',[CityController::class,'edit']);

      Route::get('/categories',[CategoryController::class,'categories'])->name('categories');
      Route::get('/categories/add',[CategoryController::class,'add']);
      Route::post('/categories/store',[CategoryController::class,'store']);
      Route::post('/categories/del',[CategoryController::class,'destroy']);
      Route::post('/categories/edit/status',[CategoryController::class,'status']);
      Route::post('/categories/edit/is_featured',[CategoryController::class,'is_featured']);
      Route::get('/categories/edit/{category}',[CategoryController::class,'show']);
      Route::post('/categories/edit/{category}',[CategoryController::class,'edit']);
      
      Route::get('/master-services',[MasterServiceController::class,'master_services'])->name('master-services');
      Route::get('/master-services/add',[MasterServiceController::class,'add']);
      Route::post('/master-services/store',[MasterServiceController::class,'store']);
      Route::any('/master-services/del/{id}',[MasterServiceController::class,'destroy']);
      Route::post('/master-services/edit/status',[MasterServiceController::class,'status']);
      Route::post('/master-services/edit/is_featured',[MasterServiceController::class,'is_featured']);
      Route::get('/master-services/edit/{category}',[MasterServiceController::class,'show']);
      Route::post('/master-services/edit/{category}',[MasterServiceController::class,'edit']);
      
      
   });

   Route::group(['middleware' =>'ProviderMiddleware'],function(){

      Route::get('/go-back', [LoginController::class,'go_back']);

      Route::get('/clearnotification', [UserController::class,'clearnotification']);
      Route::get('/reviews', [ProviderController::class,'reviews']);
      Route::get('/notifications',[UserController::class,'noti'])->name('notifications');
      
      Route::get('/notifications_bell',[UserController::class,'notifications_bell']);
      
      Route::get('/timings',[TimingController::class,'show'])->name('timings');
      Route::get('/profile-settings',[ProviderController::class,'settings']);
      Route::post('/profile-settings/update',[ProviderController::class,'profile_settings_update']);
      Route::post('/profile-settings/add-bank',[ProviderController::class,'add_bank']);
      Route::post('/timings/edit',[TimingController::class,'edit']);
      
      Route::post('/payout-create',[PayoutController::class,'create_request']);

      Route::post('/bookings/accept',[BookingController::class,'accept']);
      Route::post('/bookings/cancel',[BookingController::class,'cancel']);
      Route::post('/bookings/complete',[BookingController::class,'complete']);
      Route::post('/bookings/assign_handyman',[BookingController::class,'assign_handyman']);

      Route::get('/handymans-add',[HandymanController::class,'add']);
      Route::post('/handymans-store',[HandymanController::class,'store']);
      Route::post('/handymans-status',[HandymanController::class,'status']);
      Route::post('/handymans-del',[HandymanController::class,'destroy']);
      Route::get('/handymans/edit/{handyman}',[HandymanController::class,'show']);
      Route::post('/handymans/edit/{handyman}',[HandymanController::class,'edit']);

      Route::get('/services-add',[ServiceController::class,'add']);
      Route::post('/services-store',[ServiceController::class,'store']);
      Route::post('/services/edit/is_featured',[ServiceController::class,'is_featured']);
      Route::post('/services/edit/status',[ServiceController::class,'status']);
      Route::post('/services-del',[ServiceController::class,'destroy']);
      Route::get('/services/edit/{service}',[ServiceController::class,'show']);
      Route::post('/services/edit/{service}',[ServiceController::class,'edit']);
      Route::post('/del/gallery',[GalleryImagesController::class,'destroy']);
      Route::post('/gallery/edit',[GalleryImagesController::class,'edit']);
      Route::post('/gallery/add',[GalleryImagesController::class,'add']);
      Route::post('/gallery/image/add',[GalleryImagesController::class,'add_gallery']);
      Route::post('services/verified_flag',[ServiceController::class,'updateVerifiedFlag']);
      
      
      
      
    //   Route::get('/coupons',[CouponController::class,'index'])->name('coupons');
    //   Route::get('/coupons/add',[CouponController::class,'add']);
    //   Route::post('/coupons/store',[CouponController::class,'store']);
    //   Route::post('/coupons/del',[CouponController::class,'destroy']);
    //   Route::post('/coupons/edit/status',[CouponController::class,'status']);
    //   Route::get('/coupons/edit/{id}',[CouponController::class,'show']);
    //   Route::post('/coupons/edit/{id}',[CouponController::class,'edit']);
    //   Route::post('/coupons/getServicePhotographer',[CouponController::class,'getServicePhotographer']);
      
   
   });

});
