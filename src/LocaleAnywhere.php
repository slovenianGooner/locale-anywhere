<?php

namespace Sloveniangooner\LocaleAnywhere;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class LocaleAnywhere extends Tool
{
    protected static $locales = [];
    public static $useFallback = null;

    public function __construct($locales, $useFallback = null)
    {
        self::$locales = $locales;
        if (isset($useFallback)) {
            self::$useFallback = $useFallback;
        }
    }

    public static function getLocales()
    {
        return self::$locales;
    }

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('locale-anywhere', __DIR__.'/../dist/js/tool.js');
        Nova::style('locale-anywhere', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        // return view('locale-anywhere::navigation');
    }
}
