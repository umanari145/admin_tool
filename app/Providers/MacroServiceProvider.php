<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (! Collection::hasMacro('transpose')) {
            Collection::macro('transpose', function () {
                $items = array_map(function (...$items) {
                    return $items;
                }, ...$this->values());
                return new static($items);
            });

            if (! Collection::hasMacro('transposeWithHeadKey')) {
                Collection::macro('transposeWithHeadKey', function () {

                    $heads = collect(array_keys($this->items));
                    $values = collect(array_values($this->items));
                    return $values->transpose()
                        ->transform(function ($value) use ($heads) {
                            return $heads->combine($value);
                        });
                });
            }
        }
    }
}
