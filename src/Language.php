<?php

namespace Sloveniangooner\LocaleAnywhere;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class Language extends Field
{
    public $component = "locale-anywhere";
    public $locale;
    public $showOnIndex = false;

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
    
        $prefix = optional(auth()->user())->id;
        $this->locale = cache()->has($prefix.".locale") ? cache()->get($prefix.".locale") : app()->getLocale();
        $this->withMeta([
            "locales" => LocaleAnywhere::getLocales(),
            "locale" => $this->locale,
        ]);
    }

    public function fill(NovaRequest $request, $model)
    {
        return;
    }

    public function resolveAttribute($resource, $attribute)
    {
        return [
            "isTranslated" => in_array(
                $this->locale,
                array_keys(
                    $resource->getTranslations(
                        $resource->getTranslatableAttributes()[0]
                    )
                )
            ),
            "value" => data_get($resource, str_replace('->', '.', $attribute))
        ];
    }
}
