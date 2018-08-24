<?php

Route::group(["middleware" => ["web"]], function () {
    Route::get("/intro", "IntroController@index");

    /* Auth */
    Route::get("/redirect", "Auth\SocialAuthController@redirect");
    Route::get("/callback", "Auth\SocialAuthController@callback");

    /* Pages */
    Route::get("/about", "Api\PagesController@about");
    Route::get("/contact", "Api\PagesController@contact");
    Route::post("/contact", "Api\PagesController@contactPost");

    /* Ranks */
    Route::get("/", "Api\RanksController@ranks");
    Route::get("ranks", "Api\RanksController@ranks");
    Route::get('ranks/all', 'Api\RanksController@ranksAll');
    Route::get("ranks/{code?}", "Api\RanksController@ranks");
    Route::get("/api/rankingNationalExperience", "Api\RanksController@nationalExperience");
    Route::get("/api/rankingNationalQuality", "Api\RanksController@nationalQuality");
    Route::get("/api/rankingNationalRanking", "Api\RanksController@nationalRanking");
    Route::get("/api/rankingNationalPrice", "Api\RanksController@nationalPricing");
    Route::get("tabstexts", "Api\RanksController@tabstexts");

    /* Reviews*/
    Route::get("reviews", "Api\ReviewsController@reviews");
    Route::get("reviews/{code?}", "Api\ReviewsController@reviews");
    Route::get("reviews/{code?}/{id?}", "Api\ReviewsController@reviews");

    /* Rating & reviewing operator */
    Route::group(["middleware" => ["GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:15,1440"]], function () {
        Route::post("/operator/rate/{id?}", "Api\RanksController@rateOperator");
        Route::post("/operator/review/{id?}", "Api\ReviewsController@reviewOperator");
    });

    /* Benchmark - ASK ABOUT THESE ROUTES */
    /*Route::get("benchmark", "Api\BenchmarkController@benchmark");
    Route::post("reportMobileData", "Api\BenchmarkController@reportMobileData");
    Route::get("reportMobileDataTest", "Api\BenchmarkController@reportMobileDataTest");
    Route::group(["middleware" => ["GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:150,1440"]], function () {
        Route::get("tats/getDevice", "Api\StatsController@getDevice"); // ASK ABOUT THIS ROUTE
        Route::post("persistBenchmark", "Api\BenchmarkController@persistBenchmark");
        Route::get("persistBenchmark", "Api\BenchmarkController@persistBenchmark");
    });*/

    /* Operator */
    // Route::get("/{code?}/operator/{name?}", "Api\RanksController@operator");

    Route::get("/analytics", "Api\ScoresController@nationalStat");
    Route::get("/analytics/{code?}", "Api\ScoresController@nationalStat");


    /* Admin */
    Route::get("/admin", "Admin\ExcelController@export");
    Route::get("/admin/download/{file?}", "Admin\ExcelController@download");
    Route::post("/admin", "Admin\ExcelController@make");
    Route::post("/admin/remove", "Admin\ExcelController@remove");

    Route::get("/admin/import", "Admin\ExcelController@import");
    Route::post("/admin/import", "Admin\ExcelController@upload");
    Route::post("/admin/import/process", "Admin\ExcelController@process");

    Route::get("/admin/users", "Admin\UserController@listAdmins");
    Route::post("/admin/users/{id}/status", "Admin\UserController@changeStatus");
    Route::post("/admin/users/{id}", "Admin\UserController@delete");

    /* General */
    Route::get("countries", "Api\PagesController@getApiCountries");
    Route::get("configs", "Api\PagesController@configs");
});
