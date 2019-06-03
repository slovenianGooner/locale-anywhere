<?php

namespace Sloveniangooner\LocaleAnywhere;

use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // $locale = cache()->has("locale") ? cache()->get("locale") : app()->getLocale();
    }
}
