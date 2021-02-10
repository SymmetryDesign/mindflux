<?php

namespace App\Http\Controllers\Web\Back\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Support\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Inertia\Inertia;
use MediaUploader;

class SystemSettingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show system settings page.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('back/admin/settings/system/index', [
            'languages' => Language::available(),
            'locale'    => settings('locale', 'en'),
        ]);
    }

    /**
     * Update system settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Plank\Mediable\Exceptions\MediaUpload\ConfigurationException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileExistsException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileNotFoundException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileNotSupportedException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileSizeException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\ForbiddenException
     * @throws \Plank\Mediable\Exceptions\MediaUrlException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'logo_light' => $request->hasFile('logo_light') ? ['nullable', 'sometimes', 'image'] : [],
            'logo_dark'  => $request->hasFile('logo_dark') ? ['nullable', 'sometimes', 'image'] : [],
            'favicon'    => $request->hasFile('favicon') ? ['nullable', 'sometimes', 'mimes:ico'] : [],
        ]);

        settings([
            'locale' => $request->input('locale'),
        ]);

        Cache::forget(auth()->user()->cacheKey('locale'));

        if ($request->hasFile('logo_light')) {
            $this->handleUpload($request, 'logo_light');
        }

        if ($request->hasFile('logo_dark')) {
            $this->handleUpload($request, 'logo_dark');
        }

        if ($request->hasFile('favicon')) {
            $this->handleUpload($request, 'favicon');
        }

        session()->flash('message', __('app.messages.settings-updated'));

        return back();
    }

    /**
     * Handle uploaded files.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $filename
     * @return void
     * @throws \Plank\Mediable\Exceptions\MediaUpload\ConfigurationException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileExistsException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileNotFoundException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileNotSupportedException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileSizeException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\ForbiddenException
     * @throws \Plank\Mediable\Exceptions\MediaUrlException
     */
    protected function handleUpload($request, $filename)
    {
        $media = MediaUploader::fromSource($request->file($filename))
            ->toDestination('public', 'imgs')
            ->onDuplicateReplace()
            ->useFilename($filename)
            ->beforeSave(function ($media) {
                $media->uuid = Str::uuid();
            })
            ->upload();

        settings([
            "$filename" => $media->getUrl()
        ]);
    }
}
