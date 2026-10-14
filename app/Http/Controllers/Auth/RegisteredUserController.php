<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'names' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:people'],
            'user_name' => ['required', 'string', 'max:15', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        return DB::transaction(function () use ($request) {
            // Obtener el rol por defecto para nuevos usuarios (Customer), o rol no-admin existente
            $defaultRole = \App\Models\Role::where('description', 'Customer')->first()
                ?? \App\Models\Role::find(2)
                ?? \App\Models\Role::where('description', '!=', 'Admin')->first()
                ?? \App\Models\Role::firstOrCreate(['description' => 'Customer'], ['status' => 1]);

            $person = \App\Models\Person::create([
                'names' => $request->names,
                'email' => $request->email,
            ]);

            $user = User::create([
                'user_name' => $request->user_name,
                'password' => Hash::make($request->password),
                'status' => 1,
                'person_id' => $person->id,
                'role_id' => $defaultRole->id,
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        });
    }
}
