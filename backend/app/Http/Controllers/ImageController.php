<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImageController extends Controller
{
    public function showUserImage(Request $request, Filesystem $filesystem, $filename)
    {
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => Storage::disk('private')->getDriver(),
            'cache' => Storage::disk('cache')->getDriver(),
            'cache_path_prefix' => '.c',
            // 'base_url' => 'img', ???
        ]);
        // dd(Storage::disk('private')->path($request->user()->id . '/account/' . $filename));
        // dd($request->user()->id . '/account/' . $filename);
        return $server->getImageResponse($request->user()->id . '/account/' . $filename, request()->all());
    }

    public function showPhoto(Request $request, $width, $slug)
    {
        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory($request),
            'source' => Storage::disk('archive')->getDriver(),
            'cache' => Storage::disk('cache')->getDriver(),
            'cache_path_prefix' => '.c',
            'watermarks' => Storage::disk('watermarks')->getDriver(),
            'driver' => 'imagick',
        ]);
        $options = [
            'w' => $width
        ];
        if ($width > 240) {
            $options = array_merge($options, [
                'markw' => floor($width / 3.67),
                'mark' => 'watermark.png',
                'markpad' => '15',
            ]);
        }
        $photo = Photo::where('slug', $slug)->first();
        return $server->getImageResponse($photo->filename . '.jpg', $options);
    }
}
