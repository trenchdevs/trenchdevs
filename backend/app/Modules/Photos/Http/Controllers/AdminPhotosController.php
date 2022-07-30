<?php

namespace App\Modules\Photos\Http\Controllers;


use App\Modules\Aws\Services\AmazonS3Service;
use App\Modules\Photos\Models\Photo;
use App\Http\Controllers\Controller;
use ErrorException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminPhotosController extends Controller
{

    public function index(): View
    {
        return view('admin.photos.index', [
            'photos' => Photo::builder()->get()
        ]);
    }

    /**
     * @throws ErrorException
     * @throws ValidationException
     */
    public function upload(Request $request, AmazonS3Service $uploader): RedirectResponse
    {

        $this->validate($request, [
            'images'   => 'required|array',
            'images.*' => 'required|mimes:jpg,jpeg,png,bmp|max:10000'
        ], [
            'images'            => 'Please upload an image',
            'images.*.required' => 'Please upload an image',
            'images.*.mimes'    => 'Only jpeg,png and bmp images are allowed',
            'images.*.max'      => 'Sorry! Maximum allowed size for an image is 20MB',
        ]);


        /** @var UploadedFile $file */
        foreach ($request->file('images') as $file) {
            $s3UploadedFile = $uploader->upload('admin::photos::index', $file, 'admin/photos', $file->getClientOriginalName());
            Photo::query()->create([
                'site_id'   => site_id(),
                'user_id'   => auth()->id(),
                's3_id'     => $s3UploadedFile->id,
                'is_active' => 1,
            ]);
        }

        return redirect()->route('admin.photos.index');
    }

    public function delete(int $id): RedirectResponse
    {
        DB::transaction(function () use ($id) {
            $photo = Photo::query()->find($id);
            $photo->delete();
        });

        return redirect()->route('admin.photos.index');
    }
}
