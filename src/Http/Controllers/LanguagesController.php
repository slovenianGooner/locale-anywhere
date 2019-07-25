<?php

namespace Sloveniangooner\LocaleAnywhere\Http\Controllers;

use Illuminate\Routing\Controller;
use Sloveniangooner\LocaleAnywhere\LocaleAnywhere;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Controllers\DeletesFields;
use Laravel\Nova\Nova;
use Laravel\Nova\Actions\ActionEvent;
use Laravel\Nova\Actions\Actionable;
use DB;

class LanguagesController extends Controller
{
    use DeletesFields;

    public function languages()
    {
        return LocaleAnywhere::getLocales();
    }

    public function cacheLocale(Request $request)
    {
        $prefix = optional(auth()->user())->id;
        cache()->forever($prefix.".locale", $request->input("locale"));
        return cache()->get($prefix.".locale");
    }

    public function delete(Request $request)
    {
        $locale = cache()->has("locale") ? cache()->get("locale") : app()->getLocale();

        $resourceClass = Nova::resourceForKey($request->get("resourceName"));
        if (!$resourceClass) {
            abort("Missing resource class");
        }

        $modelClass = $resourceClass::$model;
        $resource = $modelClass::find($request->get("resourceId"));
        if (!$resource) {
            abort("Missing resource");
        }

        // If translations count === 1 then forget the model completely
        $translationsCount = count($resource->getTranslations(
            $resource->getTranslatableAttributes()[0]
        ));

        if ($translationsCount > 1 and $resource->forgetAllTranslations($locale)->save()) {
            return response()->json(["status" => true]);
        } elseif ($translationsCount === 1) {
            if (in_array(Actionable::class, class_uses_recursive($resource))) {
                $resource->actions()->delete();
            }

            $resource->delete();

            DB::table('action_events')->insert(
                ActionEvent::forResourceDelete($request->user(), collect([$resource]))
                            ->map->getAttributes()->all()
            );

            return response()->json(["status" => true]);
        }

        abort("Error saving");
    }
}
