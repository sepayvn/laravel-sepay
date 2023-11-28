<?php

use SePay\SePay\Http\Controllers\IndexController;

Route::group([
    'prefix' => 'laravel-sepay',
    'as' => 'laravel-sepay.',
    'middleware' => ['web'],
], function () {
    Route::get('/', [IndexController::class, 'index']);
});
