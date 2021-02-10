<?php

namespace App\Http\Controllers\Web\Front;

use App\Http\Controllers\Controller;
use App\Support\Language;
use Illuminate\Support\Facades\Cache;

class LocalizationController extends Controller
{
    /**
     * Send localization objects to the browser window object.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locale = $this->getDefaultLocale();

        $response = "window.messages=" . json_encode(require_once(resource_path("lang/$locale/app.php")));

        return response($response)->header('Content-Type', 'text/javascript');
    }

    /**
     * Determine the default system locale.
     *
     * @return string
     */
    protected function getDefaultLocale()
    {
        if (auth()->guest()) {
            $locale = settings('locale', 'en');
        } else {
            $locale = Cache::rememberForever(auth()->user()->cacheKey('locale'), function () {
                return auth()->user()->preferences()->get('locale', settings('locale', 'en'));
            });
        }

        if (!in_array($locale, $this->getAvailableLocaleKeys())) {
            $locale = 'en';
        }

        return $locale;
    }

    /**
     * Get available system locale keys as located in resources/lang file.
     *
     * @return array
     */
    protected function getAvailableLocaleKeys()
    {
        return collect(Language::available())
            ->map(function ($locale) {
                return $locale['code'];
            })
            ->values()
            ->toArray();
    }
}
