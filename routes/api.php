<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Util\Getopt;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::namespace('Api')->group(function () {

    Route::get('artisan-command/{password}', 'ArtisanCommandController@index');

    //Route::get('transfer', 'WithdrawalController@transfer_to_bank');


    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');
    Route::get('check/email/{email}', 'AuthController@check_email');
    Route::get('product/{slug}', 'ProductController@get_product');

    Route::get('transaction/{T_ref}', 'TransactionController@get_transaction');


    Route::group(['prefix' => 'password'], function () {
        Route::post('create', 'PasswordResetController@create');
        Route::get('find/{token}', 'PasswordResetController@find');
        Route::post('reset', 'PasswordResetController@reset');
    });

    Route::Post('get-rate', 'PaymentController@get_rate');
    Route::get('get-banks', 'PaymentController@banks');

    // password reset routes    

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::post('user/update', 'AuthController@update');

        Route::post('resendVerificationEmail/{email}', 'AuthController@resendVerificationEmail');
        Route::post('verifyEmail/{token}', 'AuthController@verifyEmail');

        // Route::resource('users', 'UsersController');
        // Route::post('user/avatar', 'UsersController@avatar');
        // Route::get('user/post', 'UsersController@post');
        // Route::post('user/validate', 'UsersController@validate_password');


        Route::post('open-dispute', 'DisputeController@open_dispute');
        Route::post('resolve-dispute', 'DisputeController@resolve_dispute');
        Route::get('transaction-disputes/{transaction_id}', 'DisputeController@getTransactionDisputes');

        Route::get('product/resolve-dispute/{id}', 'ProductController@resolve_dispute');


        Route::resource('product', 'ProductController');

        Route::get('product/accept/{id}', 'ProductController@accept');
        Route::get('product/status/{id}', 'ProductController@status');
        Route::get('product/paid/{id}', 'ProductController@paid');

        Route::get('product/status/delivery/{id}', 'ProductController@delivery');
        Route::get('product/status/delivered/{id}', 'ProductController@delivered');
        Route::get('product/status/recieved/{id}', 'ProductController@recieved');
        Route::get('product/status/canceled/{id}', 'ProductController@canceled');


        Route::post('transaction/accept/{id}', 'TransactionController@accept');
        Route::post('transaction/decline/{id}', 'TransactionController@decline');
        Route::post('transaction/confirm/{id}', 'TransactionController@confirm');
        Route::post('transaction/cancel/{id}', 'TransactionController@cancel');

        Route::resource('payment', 'PaymentController');
        Route::resource('card', 'CardController');
        //Route::post('payment/link', 'PaymentController@getPaymentLink');
        Route::post('make-payment', 'PaymentController@make_payment');
        Route::resource('transaction', 'TransactionController');
        Route::resource('account', 'UserAccountController');

        Route::post('fund', 'CardController@fund');

        Route::resource('user-bank', 'BankController');
        Route::post('verify-account', 'BankController@verify_account_number');

        // Route::resource('withdraw', 'WithdrawalController');
        Route::get('withdraw-requests', 'WithdrawalController@index');
        Route::post('request-withdrawal', 'WithdrawalController@request_withdrawal');
        Route::post('transfer_to_bank', 'WithdrawalController@transfer_to_bank');


        Route::get('refund-requests', 'RefundController@index');
        Route::post('request-refund', 'RefundController@request_Refund');
        Route::post('transfer_to_bank', 'RefundController@transfer_to_bank');


        Route::get('referral-bonus', 'RefererController@index');

        Route::post('request-referral-bonus-withdrawal', 'ReferralWidrawalController@request_withdrawal');
        Route::get('referral-withdraw-requests', 'ReferralWidrawalController@index');
        Route::post('transfer-referral-bonus-to-bank', 'ReferralWidrawalController@transfer_to_bank');
    });
});
Route::get('get-users', 'UserController@index');
Route::get('get-users/{id}', 'UserController@indexx');



Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function () {
    Route::get('users', 'AdminController@users');
    Route::get('users/{startDate}/{endDate}', 'AdminController@userBtwnDate');
    Route::get('users/total', 'AdminController@numbers_of_users');
});
