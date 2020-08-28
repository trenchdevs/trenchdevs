<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        /**
         * todo:
         *  1. Upload profile picture
         *  2. Github profile link
         *  3. Facebook profile link
         *  4. Projects (future)
         *  5. Reset Password
         *  6. Users
         */
        return view('profile.index', [
            'user' => $user,
        ]);
    }

    public function fileUpload(Request $request)
    {
        $this->validate($request, ['image' => 'required|image']);
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $name=time().$file->getClientOriginalName();
            $filePath = 'images/' . $name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            return back()->with('success','Image Uploaded successfully');
        }
    }
}
