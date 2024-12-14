<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $apikey=Redis::get("apikey");
        if (!$apikey){
            $resp=Http::retry(3)->post(env('REPORT_API_URL').'/merchant/user/login', [
                'email' => env('REPORT_API_USERNAME'),
                'password' => env('REPORT_API_PASSWORD'),
            ]);
            if ($resp->json()["status"]=="APPROVED"){
                Redis::set("apikey",trim($resp->json()["token"]), 'EX', 60*9);
            }
        }
        Http::macro('financial', function () use ($apikey) {
            return Http::withHeaders([
                'Authorization' => $apikey,
            ])->baseUrl('https://sandbox-reporting.rpdpymnt.com/api/v3');
        });
    }
}
