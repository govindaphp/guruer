<?php
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Controllers\Admin\CmsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TailorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerChatController;
use App\Http\Controllers\MerchentChatController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;

/**********************[ WEB SITE ROUTING START ]****************************/
Route::get('/', [HomeController::class, 'AllGuruer']);
Route::get('/login',[HomeController::class, 'login']);
Route::post('/loginchk', [HomeController::class, 'loginchk'])->name('customerlogin');
Route::get('/register',[HomeController::class, 'register']);

Route::post('/loginchk_ajax', [HomeController::class, 'loginchk_ajax'])->name('customerlogin_ajax');
Route::post('/favorites_users_ajax', [HomeController::class, 'favorites_users_ajax'])->name('customerfavorites_users_ajax');


/****************************[CUSTOMER AUTH START]************************************/

Route::group(['middleware'=>['web','checkUser']],function(){
    Route::any('/customerProfile', [CustomerController::class, 'updateProfile']);
    Route::get('/customerDashboard',[CustomerController::class, 'customerDashboard']);
    Route::get('/customerMessages',[CustomerController::class, 'customer_delete_it']);
    Route::post('/getMerchent',[CustomerChatController::class, 'getMerchent']);
    Route::post('/userMessageSubmit',[CustomerChatController::class, 'userMessageSubmit']);
});

/****************************[GURU AUTH START]************************************/

Route::group(['middleware'=>['vendor']],function(){

    Route::get('/vendorsDasboard',[VendorController::class, 'vendorDashboard']);
    Route::get('/ProfileSetting', [VendorController::class, 'ProfileSetting']);
    Route::any('/updateSubject', [VendorController::class, 'updateSubject']);
    Route::post('/guruSubject', [VendorController::class, 'guruSubject']);
    Route::get('/vendor-wallet', [VendorController::class, 'vendor_wallet']);
    Route::post('/profile_update', [VendorController::class, 'profile_update']);
    Route::get('/vendorProduct',[VendorController::class, 'vendorProduct']);
    Route::post('/productStatus',[VendorController::class, 'productStatus']);
    Route::get('/deleteProduct/{id}',[VendorController::class, 'deleteProduct'])->name('deleteProduct');
    Route::any('/addProduct/{id?}',[VendorController::class, 'addProduct'])->name('addProduct');
    Route::post('/finalPrice',[VendorController::class, 'finalPrice']);

    // vendor msg section
    Route::get('vendorMessages_delete_it',[VendorController::class, 'template']);
    Route::get('vendorMessages',[VendorController::class, 'vendorMessages_delete_it']); //delete it
    Route::post('/getUser',[MerchentChatController::class, 'conversation']);
    Route::post('/merchentMessageSubmit',[MerchentChatController::class, 'merchentMessageSubmit']);
    Route::get('/chatRoomVendor',[VendorController::class, 'chatRoomVendor']);
    Route::post('/vendorMessageSubmit',[VendorController::class, 'vendorMessageSubmit']);

});
Route::post('/getSubcategory',[VendorController::class, 'getSubcategory']);
Route::post('/getSubject',[VendorController::class, 'getSubject']);

/****************************[GURU AUTH END]************************************/

Route::get('/google/redirect', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/google/redirectvend', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogleVendor'])->name('google.redirectvend');
Route::get('/google/callbackvendor', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallbackVendor'])->name('google.callbackvend');




Route::get('/showLinkRequestForm', [HomeController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/sendResetLinkEmail', [HomeController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [HomeController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [HomeController::class, 'resetPassword'])->name('password.update');


Route::any('/logout',[HomeController::class, 'logout']);
Route::post('/signup',[HomeController::class, 'signup'])->name('signup');

Route::get('account/verify/{token}', [HomeController::class, 'verifyAccount']);
Route::get('/zoom_meeting',[HomeController::class, 'zoom_meeting']);


/* Bigblue button code */
Route::get('/meetInClassroom',[HomeController::class, 'meetInClassroom']);
Route::get('/event_join',[HomeController::class, 'event_join']);
Route::get('/chatRoom',[HomeController::class, 'chatRoom']);


/**********************[ WEB SITE ROUTING END ]****************************/






/*****************************[Fabric seller search]****************************************/


Route::post('/AllGuruer',[HomeController::class, 'filterGuruer'])->name('guruFilter');  // put the two
Route::post('/guru-results', [HomeController::class, 'loadResults'])->name('gururesults'); // put the two



Route::post('/ajax-video-results', [HomeController::class, 'loadvideoResults_ajax'])->name('ajaxvideoresults');
Route::post('/ajax-chat-results', [VendorController::class, 'loadchatResults_ajax'])->name('ajaxchatresults');
Route::any('/allwishlist',[HomeController::class, 'allwishlist']);
Route::get('/get-updated-wishlist', [HomeController::class, 'getUpdatedWishlist']);
Route::any('/guruerDetail/{id}', [HomeController::class, 'guruerDetail']);
Route::post('/save-user-review', [HomeController::class, 'store'])->name('save.user.review');






//demo code route

Route::get('/productList', [HomeController::class, 'productList']);





/****************************[CUSTOMER AUTH END]************************************/





//admin login

Route::get('/admin', [AuthController::class, 'index']);
Route::post('/adminlogin', [AuthController::class, 'adminlogin'])->name('adminlogin');
Route::get('/adminLogout', [AuthController::class, 'adminLogout'])->name('adminLogout');

Route::group(['middleware'=>['web','checkAdmin']],function(){

    Route::get('/admin/dashboard', [AuthController::class, 'admindashboard'])->name('admindashboard');
    Route::get('/admin/customer-list', [ManagementController::class, 'customer_list'])->name('admin.customer_list');
    Route::get('/admin/customer-form', [ManagementController::class, 'customerForm'])->name('admin.customer_form');
    Route::post('/admin/customer_formAction', [ManagementController::class, 'customerFormAction'])->name('admin.customerFormAction');
    Route::post('/admin/customer-status', [ManagementController::class, 'customerStatus'])->name('admin.customerStatus');
    Route::get('/admin/delete-user-list/{id}', [ManagementController::class, 'delete_user_list'])->name('admin.delete_user_list');
    Route::get('/admin/customer-edit/{id}', [ManagementController::class, 'customer_edit'])->name('admin.customer_edit');
    Route::post('/admin/useremail', [ManagementController::class, 'checkEmailuser'])->name('admin.checkEmailuser');
    Route::get('/admin/customer-view/{id}', [ManagementController::class, 'customer_view'])->name('admin.customer_view');

    //vip customer
    Route::get('/admin/vip-customer-view/{id}', [ManagementController::class, 'vip_customer_view'])->name('admin.vip_customer_view');
    Route::get('/admin/vip-customer-list', [ManagementController::class, 'vip_customer_list'])->name('admin.vip_customer_list');
    Route::get('/admin/vip-customer-form', [ManagementController::class, 'vipCustomerForm'])->name('admin.vip_customer_form');
    Route::get('/admin/vip-customer-edit/{id}', [ManagementController::class, 'vipCustomeredit'])->name('admin.vip_customer_edit');
    Route::post('/admin/vipcustomer_formAction', [ManagementController::class, 'vipCustomerFormAction'])->name('admin.vipcustomerFormAction');

   //tailor management

   Route::get('/admin/Guruer_list', [ManagementController::class, 'Guruer_list']);
   Route::get('/admin/tailor-form', [ManagementController::class, 'tailorForm'])->name('admin.tailor_form');
   Route::post('/admin/tailorFormAction', [ManagementController::class, 'tailorFormAction'])->name('admin.tailorFormAction');
   Route::get('/admin/delete-vendor-list/{id}', [ManagementController::class, 'delete_vendor_list'])->name('admin.delete_vendor_list');
   Route::post('/admin/vendor-status', [ManagementController::class, 'vendorStatus'])->name('admin.vendorStatus');
   Route::post('/admin/vendor-filter', [ManagementController::class, 'vendorFilter'])->name('admin.vendorFilter');
   Route::get('/admin/guruer-view/{id}', [ManagementController::class, 'guruer_view'])->name('admin.tailor_view');
   Route::get('/admin/guruer-edit/{id}', [ManagementController::class, 'guruer_edit'])->name('admin.tailor_edit');

    //fabric seller management
    Route::get('/admin/fabric-seller-list', [ManagementController::class, 'fabric_seller_list'])->name('admin.fabric_seller_list');
    Route::get('/admin/fabric-seller-form', [ManagementController::class, 'fabric_seller_form'])->name('admin.fabric_seller_form');
    Route::post('/admin/fabricSellerAction', [ManagementController::class, 'fabricSellerAction'])->name('admin.fabricSellerAction');



    //tailor seller management
    Route::get('/admin/tailor-seller-list', [ManagementController::class, 'tailor_seller_list'])->name('admin.tailor_seller_list');
    Route::get('/admin/tailor-seller-form', [ManagementController::class, 'tailor_seller_form'])->name('admin.tailor_seller_form');
    Route::post('/admin/tailorSellerAction', [ManagementController::class, 'tailorSellerAction'])->name('admin.tailorSellerAction');


	/********************[Master Route ]*************************/

    Route::get('/admin/getSize', [MasterController::class, 'getSize'])->name('getSize');
    Route::any('/admin/addSize/{id?}', [MasterController::class, 'addSize'])->name('addSize');
    Route::post('/admin/changesizeStatus', [MasterController::class, 'changesizeStatus'])->name('changesizeStatus');
    Route::get('/admin/deleteSize/{id}', [MasterController::class, 'deleteSize'])->name('deleteSize');

    Route::get('/admin/getColor', [MasterController::class, 'getColor'])->name('getColor');
    Route::any('/admin/addColor/{id?}', [MasterController::class, 'addColor'])->name('addColor');
    Route::post('/admin/changeColorStatus', [MasterController::class, 'changeColorStatus'])->name('changeColorStatus');
    Route::get('/admin/deleteColor/{id}', [MasterController::class, 'deleteColor'])->name('deleteColor');

    Route::get('/admin/getSpeciality', [MasterController::class, 'getSpeciality'])->name('getSpeciality');
    Route::any('/admin/addSpeciality/{id?}', [MasterController::class, 'addSpeciality'])->name('addSpeciality');
    Route::post('/admin/changeSpecialityStatus', [MasterController::class, 'changeSpecialityStatus'])->name('changeSpecialityStatus');
    Route::get('/admin/deleteSpeciality/{id}', [MasterController::class, 'deleteSpeciality'])->name('deleteSpeciality');

	Route::get('/admin/getFebricType', [MasterController::class, 'getFebricType'])->name('getFebricType');
    Route::any('/admin/addFebricType/{id?}', [MasterController::class, 'addFebricType'])->name('addFebricType');
    Route::post('/admin/changeFebricTypeStatus', [MasterController::class, 'changeFebricTypeStatus'])->name('changeFebricTypeStatus');
    Route::get('/admin/deleteFebricType/{id}', [MasterController::class, 'deleteFebricType'])->name('deleteFebricType');

    Route::get('/admin/getPlans', [MasterController::class, 'getPlans'])->name('getPlans');
    Route::any('/admin/addPlan/{id?}', [MasterController::class, 'addPlan'])->name('addPlan');
    Route::post('/admin/changePlanStatus', [MasterController::class, 'changePlanStatus'])->name('changePlanStatus');
    Route::get('/admin/deletePlan/{id}', [MasterController::class, 'deletePlan'])->name('deletePlan');

	Route::get('/admin/getCategory', [MasterController::class, 'getCategory'])->name('getCategory');
    Route::any('/admin/addCategory/{id?}', [MasterController::class, 'addCategory'])->name('addCategory');
    Route::post('/admin/changeCategoryStatus', [MasterController::class, 'changeCategoryStatus'])->name('changeCategoryStatus');
    Route::get('/admin/deleteCategory/{id}', [MasterController::class, 'deleteCategory'])->name('deleteCategory');

    /********************[CMS Route ]*************************/

    Route::any('/admin/privacyPolicy', [CmsController::class, 'privacyPolicy'])->name('privacyPolicy');
    Route::any('/admin/aboutUs', [CmsController::class, 'aboutUs'])->name('aboutUs');
    Route::any('/admin/termsConditions', [CmsController::class, 'termsConditions'])->name('termsConditions');

});







// Vender===============================================================================








//coutnr_detail_route
Route::get('/getcountry', [ManagementController::class, 'getcountry'])->name('show.getcountry');
Route::POST('/getstate ', [ManagementController::class, 'getstate']);
Route::POST('/getcity ', [ManagementController::class, 'getcity']);





