<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    private $client;


    function register(RegisterRequest $request)
    {
        User::create([
            'salutation_id' => $request->get('salutation_id') ? $request->get('salutation_id') : 1,
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);

        $request->merge([
            'grant_type'    => 'password',
            'client_id'     => $request->get('client_id'),
            'client_secret' => $request->get('client_secret'),
            'username'      => $request->get('email'),
            'password'      => $request->get('password'),
            'scope'         => '',
        ]);

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
        $request->request->add([
            'grant_type' => 'password',
            'username' => $request->username,
            'password' => $request->password,
            'client_id' => $request->client_id,
            'client_secret' => $request->client_secret,
            'scope' => ''
        ]);
        //
        // log in user for web routes
        if (Auth::attempt([
            'email' => $request->username,
            'password' => $request->password
        ])) {
            $user = User::where('email', $request->username)->firstOrFail();
            Auth::login($user);
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
    protected function refreshToken(Request $request)
    {
        $request->request->add([
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'scope' => ''
        ]);

        $proxy = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($proxy);
    }
}
