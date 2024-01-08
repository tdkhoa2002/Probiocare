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

Route::prefix('staking')->middleware('check-auth')->group(function (Router $router) {
    $router->get('/', 'PublicController@getStakingList')->name('fe.staking.staking.staking-list');
    $router->get('/my', 'PublicController@getMyStaking')->name('fe.staking.staking.mystaking');
    $router->get('/{packageId}/detail', 'PublicController@getStakingDetail')->name('fe.staking.staking.staking-detail');
    $router->get('/getPackageInfo/{packageId}', 'PublicApiController@getPackageInfo')->name('api.fe.staking.package.info');
    $router->post('/submitStake', 'PublicApiController@submitStake');
    $router->get('/get-list-my-stake', 'PublicApiController@getListMyStake');
    $router->post('/redeem-stake', 'PublicApiController@redeemStake');
});


