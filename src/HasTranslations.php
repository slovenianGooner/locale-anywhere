<?php

namespace Sloveniangooner\LocaleAnywhere;

use Spatie\Translatable\HasTranslations as SpatieTrait;

trait HasTranslations
{
    use SpatieTrait {}

    public function getAttributeValue($key)
    {
        if (! $this->isTranslatableAttribute($key)) {
            return parent::getAttributeValue($key);
        }

        // By default, we use fallback value
        $useFallback = true;

        // Global fallback settings
        if (LocaleAnywhere::$useFallback !== null) {
            $useFallback = LocaleAnywhere::$useFallback;
        }

        // Local model fallback settings
        if (isset($this->useFallback)) {
            $useFallback = $this->useFallback;
        }


        return $this->getTranslation($key, $this->getLocale(), $useFallback);
    }

    protected function getLocale() : string
    {
        return cache()->has("locale") ? cache()->get("locale") : app()->getLocale();
    }
}
