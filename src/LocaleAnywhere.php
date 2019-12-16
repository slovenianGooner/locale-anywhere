<?php

namespace Sloveniangooner\LocaleAnywhere;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class LocaleAnywhere extends Tool
{
  protected static $locales = [];
  public static $useFallback = null;
  public static $customDetailToolbar = false;

  public function __construct(array $data = [])
  {
    extract($data);

    if (isset($locales)) {
      self::$locales = $locales;
    }

    if (isset($useFallback)) {
      self::$useFallback = $useFallback;
    }

    if (isset($customDetailToolbar)) {
      self::$customDetailToolbar = $customDetailToolbar;
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
    $prefix = optional(auth()->user())->id;
    Nova::provideToScript(["customDetailToolbar" => self::$customDetailToolbar, "locale" => cache()->has($prefix . ".locale") ? cache()->get($prefix . ".locale") : app()->getLocale()]);
    Nova::script('locale-anywhere', __DIR__ . '/../dist/js/tool.js');
    Nova::style('locale-anywhere', __DIR__ . '/../dist/css/tool.css');
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
