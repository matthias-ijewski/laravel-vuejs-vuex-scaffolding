<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\Responses\SymfonyResponseFactory;
use League\Glide\ServerFactory;

class AccountController extends Controller
{
    public function uploadAvatar(Request $request)
    {
        //
        // file size limit is 1M
        $valid = validator($request->only('file'), [
            'file' => 'max:1024'
        ]);
        //
        if ($valid->fails()) {
            $jsonError = response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }
        if ($request->has('file')) {
            //
            // store avatar
            $file = $request->file('file');
            if ($file->isValid()) {
                //
                // delete previously cached avatar
                $server = ServerFactory::create([
                    'response' => new LaravelResponseFactory(app('request')),
                    'source' => Storage::disk('private')->getDriver(),
                    'cache' => Storage::disk('cache')->getDriver(),
                    'cache_path_prefix' => '.c',
                ]);
                $server->deleteCache($request->user()->id . '/account/' . $request->user()->avatar);
                //
                // store the new avatar to disk
                $avatar = 'avatar.' . $file->getClientOriginalExtension();
                Storage::disk('private')->putFileAs($request->user()->id . '/account', $file, $avatar);
                $request->user()->update([
                    'avatar' => $avatar
                ]);
                //
                return [
                    'url' => Storage::disk('private')->url('/account/avatar.' . $file->getClientOriginalExtension() . '?' . uniqid())
                ];
            }
            //
        }
    }
    public function update(Request $request)
    {

        $valid = validator($request->only('firstname', 'lastname', 'email'), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id
        ]);

        if ($valid->fails()) {
            $jsonError = response()->json($valid->errors()->all(), 400);
            return \Response::json($jsonError);
        }

        $data = request()->only('firstname', 'lastname', 'email');

        $request->user()->update($data);

        return ['user' => new UserResource($request->user())];
    }
}
