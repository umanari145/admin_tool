<?php

namespace App\Providers;

use App\CustomUtil\CustomEncrypter;
use Illuminate\Support\ServiceProvider;
use DB;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CustomEncrypter::class, function () {
            $custom_encrypt_key = env('CUSTOM_ENCRYPT_KEY');
            return new CustomEncrypter($custom_encrypt_key);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(
            function ($query) {
                $sql = $query->sql;
                if (strlen($sql) <= env('SQL_LOG_LIMIT', 1000)) {
                    //プリペアードステイトメントから生SQL
                    foreach ($query->bindings as $binding) {
                        if (is_string($binding)) {
                            $binding = "'{$binding}'";
                        } elseif (is_bool($binding)) {
                            $binding = $binding ? '1' : '0';
                        } elseif (is_int($binding)) {
                            $binding = (string) $binding;
                        } elseif ($binding === null) {
                            $binding = 'NULL';
                        } elseif ($binding instanceof Carbon) {
                            $binding = "'{$binding->toDateTimeString()}'";
                        } elseif ($binding instanceof DateTime) {
                            $binding = "'{$binding->format('Y-m-d H:i:s')}'";
                        }
                        $sql = preg_replace('/\\?/', $binding, $sql, 1);
                    }
                    Log::debug('SQL', ['sql' => $sql, 'time' => "{$query->time} ms"]);
                }
        });
    }
}
