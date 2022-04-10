<?php

namespace App\Domains\Users\Http\Controllers;

use App\Domains\Aws\Services\AmazonS3Service;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('profile.index', [
            'user' => $user,
        ]);
    }

    public function fileUpload(Request $request)
    {
        $this->validate($request, ['image' => 'required|image']);
        if ($request->hasfile('image')) {
            $file     = $request->file('image');
            $name     = time() . $file->getClientOriginalName();
            $filePath = 'images/' . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            return back()->with('success', 'Image Uploaded successfully');
        }
    }


}
