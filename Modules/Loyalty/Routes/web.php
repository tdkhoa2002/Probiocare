<?php

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

use Illuminate\Routing\Router;

Route::prefix('loyalty')->middleware('check-auth')->group(function (Router $router) {
    $router->get('/', 'PublicController@getStakingList')->name('fe.loyalty.loyalty.list-packages');
    $router->get('/my', 'PublicController@getMyStaking')->name('fe.loyalty.loyalty.mystaking');
    $router->get('/history', 'PublicController@getMyHistory')->name('fe.loyalty.loyalty.myhistory');
    $router->get('/{packageId}/detail', 'PublicController@getStakingDetail')->name('fe.loyalty.loyalty.loyalty-detail');
    $router->post('/subcribeLoyalty', 'PublicController@subcribeLoyalty')->name('fe.loyalty.loyalty.loyalty-subcribe');
    $router->get('/getPackageInfo/{packageId}', 'PublicApiController@getPackageInfo')->name('api.fe.loyalty.package.info');
    $router->post('/submitStake', 'PublicApiController@submitStake');
    $router->get('/get-list-my-stake', 'PublicApiController@getListMyStake');
    $router->post('/redeem-stake', 'PublicApiController@redeemStake');
});


