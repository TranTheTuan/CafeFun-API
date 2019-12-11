<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// free restaurant api
Route::get('restaurants', 'API\RestaurantController@index');
Route::get('restaurants/{restaurant}', 'API\RestaurantController@show');
Route::post('restaurants/filter', 'API\RestaurantController@filter');

// free food api
Route::get('restaurants/{restaurant}/foods', 'API\FoodController@index');
Route::get('restaurants/{restaurant}/foods/{id}', 'API\FoodController@show');

// free table api
Route::get('restaurants/{restaurant}/tables', 'API\TableController@index');

Route::middleware('auth:api')->group(function(){
    // food api
    Route::post('restaurants/{restaurant}/foods', 'API\FoodController@store');
    Route::put('restaurants/{restaurant}/foods/{id}', 'API\FoodController@update');
    Route::delete('restaurants/{restaurant}/foods/{id}', 'API\FoodController@delete');

    // table api
    Route::post('restaurants/{restaurant}/tables', 'API\TableController@store');
    Route::put('restaurants/{restaurant}/tables/{id}', 'API\TableController@update');
    Route::delete('restaurants/{restaurant}/tables/{id}', 'API\TableController@delete');

    // rating api
    Route::get('restaurants/{restaurant}/ratings', 'API\RatingController@index');
    Route::get('restaurants/{restaurant}/ratings/{id}', 'API\RatingController@show');
    Route::post('restaurants/{restaurant}/ratings', 'API\RatingController@store');
    Route::delete('restaurants/{restaurant}/ratings/{id}', 'API\RatingController@delete');

    // fovorite
    Route::get('favorites', 'API\FavoriteController@index');
    Route::post('favorites/{restaurant}', 'API\FavoriteController@store');
    Route::delete('favorites/{restaurant}', 'API\FavoriteController@delete');

    // order api
    Route::get('orders', 'API\OrderController@index');
    Route::get('orders/{id}', 'API\OrderController@show');
    Route::post('restaurants/{restaurant}/orders', 'API\OrderController@store');
    Route::put('restaurants/{restaurant}/orders/{id}', 'API\OrderController@update');

    // user api
    Route::post('restaurants/{restaurant}/staff/appoint/{user}', 'API\UserController@appoint');
    Route::get('notifications', 'API\UserController@notifications');
    Route::get('unread_notifications', 'API\UserController@unreadNotifications');
    Route::post('mark_as_read', 'API\UserController@markAsRead');

    Route::post('logout', 'API\AuthController@logout');
});

Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');
