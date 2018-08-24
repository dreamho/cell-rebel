<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', 'Api\RanksController@ranks');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

    /* Pages */
Route::get('/api/about', 'Api\PagesController@about');

Route::group(['middleware' => ['web']], function () {
    Route::get('/contact', 'Api\PagesController@contact');

    Route::get('/redirect', 'Auth\SocialAuthController@redirect');
    Route::get('/callback', 'Auth\SocialAuthController@callback');

    Route::get('ranks', 'Api\RanksController@ranks');
    Route::get('ranks/{code?}', 'Api\RanksController@ranks');

    Route::get('reviews', 'Api\RanksController@reviews');
    Route::get('reviews/{code?}', 'Api\RanksController@reviews');
    Route::get('reviews/{code?}/{id?}', 'Api\RanksController@reviews');



	Route::get('benchmark', 'Api\PagesController@benchmark');

    Route::get('/{code?}/operator/{name?}', 'Api\RanksController@operator');


    Route::get('/analytics', 'Api\ScoresController@nationalStat');
    Route::get('/analytics/{code?}', 'Api\ScoresController@nationalStat');

    Route::get('/admin', 'Admin\ExcelController@export');
    Route::get('/admin/download/{file?}', 'Admin\ExcelController@download');
    Route::post('/admin', 'Admin\ExcelController@make');
    Route::post('/admin/remove', 'Admin\ExcelController@remove');

    Route::get('/admin/import', 'Admin\ExcelController@import');
    Route::post('/admin/import', 'Admin\ExcelController@upload');
    Route::post('/admin/import/process', 'Admin\ExcelController@process');

    Route::get('/admin/mobile_settings', 'Admin\ExcelController@mobileSettings');
    Route::post('/admin/mobile_settings', 'Admin\ExcelController@saveMobileSettings');

    Route::get('/admin/cedexis/settings', 'Admin\CedexisController@settings');
    Route::get('/admin/cedexis/export', 'Admin\CedexisController@export');
    Route::post('/admin/cedexis/save', 'Admin\CedexisController@save');

    //APIs
    Route::get('/api/getCountries', 'Api\RanksController@getApiCountries');
	Route::get('/api/getTabsTexts', 'Api\RanksController@getTabsTexts');
	Route::get('/api/getConfigs', 'Api\RanksController@getAppConfigs');


    //webviews
    Route::get('/view/ranks', 'Api\RanksController@ranksWebview');
    Route::get('/view/ranks/{code?}', 'Api\RanksController@ranksWebview');

    Route::get('/view/reviews', 'Api\RanksController@reviewsWebview');
    Route::get('/view/reviews/{code?}', 'Api\RanksController@reviewsWebview');
    Route::get('/view/reviews/{code?}/{id?}', 'Api\RanksController@reviewsWebview');

    Route::get('/view/about', 'Api\RanksController@aboutWebview');
    Route::get('/view/contact', 'Api\RanksController@contactWebview');

});

Route::post('/api/reportMobileData', 'Api\RanksController@reportMobileData');
//Route::get('/api/reportMobileDataTest', 'Api\RanksController@reportMobileDataTest');
//Route::get('/api/reportMobileData', 'Api\RanksController@reportMobileData');

Route::group(['middleware' => ['GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:150,1440']], function () {
	Route::get('/stats/getDevice', 'Api\StatsController@getDevice');
});

Route::group(['middleware' => ['GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:15,1440']], function () {
    //now limiting in in repository, keep here just to prevent DDOS
    Route::post('/operator/rate/{id?}', 'Api\RanksController@rateOperator');
    Route::post('/operator/review/{id?}', 'Api\RanksController@reviewOperator');

    //test
    Route::get('/foo/{id?}', function(){
        return 'bar!';
    });
});

Route::group(['middleware' => ['GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:30,1440']], function () {
	Route::post('/api/persistBenchmark', 'Api\RanksController@persistBenchmark');
    Route::get('/api/persistBenchmark', 'Api\RanksController@persistBenchmark');
});

// --- API routes that currenty exist ---
/*Route::get('/api/getCountries', 'Api\RanksController@getApiCountries');
Route::get('/api/getTabsTexts', 'Api\RanksController@getTabsTexts');
Route::get('/api/getConfigs', 'Api\RanksController@getAppConfigs');
Route::post('/api/reportMobileData', 'Api\RanksController@reportMobileData');
//Route::get('/api/reportMobileDataTest', 'Api\RanksController@reportMobileDataTest');
//Route::get('/api/reportMobileData', 'Api\RanksController@reportMobileData');
Route::group(['middleware' => ['GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:30,1440']], function () {
    Route::post('/api/persistBenchmark', 'Api\RanksController@persistBenchmark');
    Route::get('/api/persistBenchmark', 'Api\RanksController@persistBenchmark');
});*/

// --- API Routes to add ---
Route::get('/api/rankingNationalExperience', 'Api\RanksController@getNationalExperience');
Route::get('/api/rankingNationalQuality', 'Api\RanksController@getNationalQuality');
Route::get('/api/rankingNationalRanking', 'Api\RanksController@getNationalRanking');
Route::get('/api/rankingNationalPrice', 'Api\RanksController@getNationalPricing');

/*Route::group(['middleware' => ['GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:30,1440']], function () {
    Route::post('/api/rateOperator/{id}', 'Api\RanksController@rateOperator');
    Route::post('/api/reviewOperator/{id}', 'Api\ReviewsController@regetOperator');
});

Route::get('/api/reviews/{page?}', 'Api\ReviewsController@getReviews');
Route::get('/api/about', 'Api\PagesControllre@getAbout');
Route::get('/api/contact', 'Api\PagesControllre@getContact');
Route::get('/api/benchmark', 'Api\RanksController@runBenchmark');*/