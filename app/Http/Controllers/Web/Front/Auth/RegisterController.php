<?php

namespace App\Http\Controllers\Web\Front\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/app';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'business_name' => ['required', 'string', 'max:255'],
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'accepted'      => settings('terms_and_conditions.published', false) ? ['accepted'] : [],
        ]);
    }

    /**
     * Show register page.
     *
     * @return \Inertia\Response
     */
    public function show()
    {
        return Inertia::render('front/auth/register', [
            'terms_and_conditions_published' => settings('terms_and_conditions.published', false),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $tenant = Tenant::create([
            'name' => $data['business_name']
        ]);

        $user = User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => Hash::make($data['password']),
            'role'         => User::ROLE_TENANT_OWNER,
            'tenant_owner' => true,
            'tenant_id'    => $tenant->id,
        ]);

        $tenant->createAsCustomer();

        return $user;
    }
}
