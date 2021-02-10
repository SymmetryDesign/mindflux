<?php

namespace App\Http\Controllers\Web\Back\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use MediaUploader;

class HeroSettingsController extends Controller
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
     * Update hero settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\ConfigurationException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileExistsException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileNotFoundException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileNotSupportedException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\FileSizeException
     * @throws \Plank\Mediable\Exceptions\MediaUpload\ForbiddenException
     * @throws \Plank\Mediable\Exceptions\MediaUrlException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'hero_heading'    => ['required', 'string'],
            'hero_subheading' => ['required', 'string'],
            'hero_image'      => $request->hasFile('image') ? ['image'] : [],
        ]);

        if ($request->hasFile('hero_image')) {
            $media = MediaUploader::fromSource($request->file('hero_image'))
                ->toDestination('public', 'imgs')
                ->onDuplicateReplace()
                ->useFilename('hero_image')
                ->beforeSave(function ($media) {
                    $media->uuid = Str::uuid();
                })
                ->upload();

            settings([
                "hero.image" => $media->getUrl()
            ]);
        }

        settings([
            'hero.heading'    => $request->input('hero_heading'),
            'hero.subheading' => $request->input('hero_subheading'),
        ]);

        session()->flash('message', __('app.messages.settings-updated'));

        return back();
    }
}
