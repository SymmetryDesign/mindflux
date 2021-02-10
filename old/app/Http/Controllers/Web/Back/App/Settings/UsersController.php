<?php

namespace App\Http\Controllers\Web\Back\App\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('tenant.owner');
        $this->middleware('plan.limit')->only('store', 'update', 'destroy');
    }

    /**
     * Get a listing of all team members.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('back/app/settings/users/index', [
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created team member.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => ['required', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required'],
            'role'     => ['required'],
        ]);

        User::create([
            'name'      => $request->input('name'),
            'email'     => $request->input('email'),
            'password'  => bcrypt($request->input('password')),
            'role'      => $request->input('role') === 'admin' ? User::ROLE_TENANT_OWNER : User::ROLE_TENANT_USER,
            'tenant_id' => auth()->user()->tenant->id,
        ]);

        session()->flash('message', __('app.messages.user-created'));

        return back();
    }

    /**
     * Update the specified team member.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'  => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->user, 'uuid')],
            'role'  => ['required'],
        ]);

        $user = User::where('uuid', $request->user)->firstOrFail();

        if ($request->input('password')) {
            $user->update([
                'password' => bcrypt($request->input('password'))
            ]);
        }

        $user->update([
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'role'  => $request->input('role') == 'admin' ? User::ROLE_TENANT_OWNER : User::ROLE_TENANT_USER,
        ]);

        session()->flash('message', __('app.messages.user-updated'));

        return back();
    }
}
