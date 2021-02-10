<?php

namespace App\Http\Controllers\Web\Back\Admin\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use MediaUploader;

class ProfileController extends Controller
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
     * Show edit profile page.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        return Inertia::render('back/admin/account/profile/edit');
    }

    /**
     * Update user profile.
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
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email,' . auth()->user()->id]
        ]);

        auth()->user()->update([
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if ($request->hasFile('profile_picture')) {
            $media = MediaUploader::fromSource($request->file('profile_picture'))
                ->toDestination('public', 'avatars')
                ->onDuplicateIncrement()
                ->useHashForFilename()
                ->beforeSave(function ($media) {
                    $media->uuid = Str::uuid();
                })
                ->upload();

            auth()->user()->detachMediaTags('avatars');
            auth()->user()->attachMedia($media, 'avatars');
        }

        session()->flash('message', __('app.messages.profile-updated'));

        return back();
    }
}
