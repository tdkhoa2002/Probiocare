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

Route::prefix('p2p')->middleware('check-auth')->group(function () {
    Route::get('/', 'PublicController@index')->name('fe.p2p.market.agents');
    Route::get('/orders', 'PublicController@orders')->name('fe.p2p.market.orders');
    Route::get('/center', 'PublicController@center')->name('fe.p2p.market.center');
    Route::get('/order/{adsID}/create', 'PublicController@getCreateOrder')->name('fe.p2p.order.create');
    Route::get('/get-payment-method-avaliable/{adsID}', 'ApiAdsController@getPaymentMethodAvaliable');
    Route::get('/order/{orderId}/detail', 'PublicController@orderDetail')->name('fe.p2p.order.detail');
    Route::post('/createOrder', 'ApiOrderController@createOrder');
    Route::get('/get-my-orders', 'ApiOrderController@getMyOrders');
    Route::get('/get-order-detail/{orderId}', 'ApiOrderController@orderDetail');
    Route::post('/cancel-order/{orderId}', 'ApiOrderController@cancelOrder');
    Route::post('/transfered-order/{orderId}', 'ApiOrderController@transfered');
    Route::post('/payment-received/{orderId}', 'ApiOrderController@paymentReceived');
    Route::prefix('agent')->group(function () {
        Route::get('/ads/create', 'P2PAgentController@getCreateAd')->name('fe.p2p.ads.create');
        Route::get('/ads/{id}/edit', 'P2PAgentController@editAds')->name('fe.p2p.ads.edit');
        Route::post('/apply', 'P2PAgentController@postAgentApply')->name('fe.p2p.agent.post.apply');
        Route::post('/createAds', 'ApiAdsController@createAds')->name('fe.p2p.ads.createAds');
        Route::get('/get-list-my-ads', 'ApiAdsController@getListMyAds')->name('fe.p2p.ads.getListMyAds');
        Route::get('/findAds/{id}', 'ApiAdsController@findAds')->name('fe.p2p.ads.findAds');
        Route::get('/find-order-ads/{id}', 'ApiAdsController@findOrderAds')->name('fe.p2p.ads.findOrderAds');
        Route::post('/update/{id}', 'ApiAdsController@update')->name('fe.p2p.ads.update');
        Route::delete('/deleteAds/{id}', 'ApiAdsController@deleteAds')->name('fe.p2p.ads.deleteAds');
        Route::get('/{agentID}/payment/create', 'P2PAgentController@getCreatePayment')->name('fe.p2p.agent.payment.create');
        Route::get('/{agentID}/profile', 'P2PAgentController@getAgent')->name('fe.p2p.market.byagent');

        Route::get('/get-list-order', 'ApiOrderAgentController@getAgentOrder');
        Route::get('/order/{orderId}/detail', 'P2PAgentController@orderdetail')->name('fe.p2p.agent.order.detail');
        Route::get('/get-order-detail/{orderId}', 'ApiOrderAgentController@orderAgentDetail');
        Route::post('/payment-received/{orderId}', 'ApiOrderAgentController@paymentReceived');
        Route::post('/transfered-order/{orderId}', 'ApiOrderAgentController@transfered');
    });
    Route::post('/push-message', 'ApiChatController@pushMessage');
    Route::get('/get-history', 'ApiChatController@getHistory');
});

Route::post('/pusher/auth', 'ApiChatController@pusherAuth');


Route::prefix('api/p2p')->middleware('check-auth')->group(function () {
    Route::get('/countTotalTrade', 'ApiOrderController@countTotalTrade');
});