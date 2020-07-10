<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{

    function register(RegisterRequest $request)
    {
        User::create([
            'salutation_id' => $request->get('salutation_id') ? $request->get('salutation_id') : 1,
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        //
        // passport expects username to be set
        request()->merge([
            'username' => $request->get('email'),
        ]);
        //
        $token = Request::create(
            'oauth/token',
            'POST'
        );
        return \Route::dispatch($token);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function authenticate(LoginRequest $request)
    {
        //
        // log in user for web routes
        if (Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ])) {
            $user = User::where('email', $request->get('email'))->firstOrFail();
            Auth::login($user);
            //
            // passport expects username to be set
            request()->merge([
                'username' => $request->get('email'),
            ]);
            //
            $proxy = Request::create(
                'oauth/token',
                'POST'
            );
            return Route::dispatch($proxy);
        }
        //
    }

    /**
     * @param Request $request
     * @return mixed
     */
    // protected function refreshToken(Request $request)
    // {
    //     $request->request->add([
    //         'grant_type' => 'refresh_token',
    //         'refresh_token' => $request->refresh_token,
    //         'client_id' => $this->client->id,
    //         'client_secret' => $this->client->secret,
    //         'scope' => ''
    //     ]);

    //     $proxy = Request::create(
    //         'oauth/token',
    //         'POST'
    //     );

    //     return \Route::dispatch($proxy);
    // }
}
