<?php

namespace App\Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Aws\Services\AmazonS3Service;
use App\Modules\Aws\Services\S3ImageRemoverService;
use App\Modules\Photos\Models\Photo;
use ErrorException;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Inertia\Response;

class PhotosController extends Controller
{

    /**
     * @return Response
     * @throws Exception
     */
    public function displayPhotos(): Response
    {
        return $this->inertiaRender('Photos/PhotosList', [
            'data' => Photo::query()->join('aws_s3_uploads AS s3', 's3.id', '=', 'photos.s3_id')
                ->selectRaw("
                    photos.id,
                    photos.site_id,
                    photos.user_id,
                    s3.meta->>'original_name' AS original_name,
                    s3.s3_url,
                    s3.identifier,
                    s3.s3_path,
                    photos.created_at
                ")
                ->where('user_id', '=', Auth::id())
                ->orderBy('photos.id', 'desc')
                ->paginate(20)
        ]);
    }

    /**
     * @param Request $request
     * @param AmazonS3Service $uploader
     * @return RedirectResponse
     * @throws ErrorException
     * @throws ValidationException
     */
    public function upload(Request $request, AmazonS3Service $uploader): RedirectResponse
    {
        $this->validate($request, ['image' => 'required|image|max:' . 1024 * 5 /* 5 MB */]);

        /** @var UploadedFile $file */
        $s3UploadedFile = $uploader->upload('photos::user::upload', $request->file('image'), 'photos/user');
        Photo::query()->create([
            'site_id' => site_id(),
            'user_id' => user_id(),
            's3_id' => $s3UploadedFile->id,
            'is_active' => 1,
        ]);

        Session::flash('message', 'Successfully uploaded photo');
        return redirect(route('dashboard.photos'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $photo = Photo::query()->where('id', '=', $id)->where('user_id', '=', user_id())->firstOrFail();
        $photo->delete();

        dispatch(function () {
            (new S3ImageRemoverService(AmazonS3Service::newInstance()))->deleteImagesMarkedForDeletion(10);
        });

        return redirect(route('dashboard.photos'));
    }

}
