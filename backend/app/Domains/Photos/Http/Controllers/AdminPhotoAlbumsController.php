<?php

namespace App\Domains\Photos\Http\Controllers;

use App\Domains\Photos\Models\Photo;
use App\Domains\Photos\Models\PhotoAlbum;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminPhotoAlbumsController extends Controller
{

    public function getIndex(): View
    {
        return view('admin.photos.albums.index', [
            'albums' => PhotoAlbum::query()->simplePaginate(),
        ]);
    }

    public function getUpsert(int $id = null): View
    {

        $album              = new PhotoAlbum;
        $associatedPhotoIds = [];

        if ($id) {
            /** @var PhotoAlbum $album */
            $album              = PhotoAlbum::query()->findOrFail($id);
            $associatedPhotoIds = $album->photos()->selectRaw('id')->get()->pluck('id')->toArray();
        }

        $photosAssigned  = collect();
        $photosAvailable = collect();

        foreach (Photo::builder()->get() as $photo) {

            if (in_array($photo->id, $associatedPhotoIds)) {
                $photosAssigned->push($photo);
            } else {
                $photosAvailable->push($photo);
            }
        }


        return view('admin.photos.albums.upsert', [
            'album'            => $album,
            'photos_available' => $photosAvailable,
            'photos_assigned'  => $photosAssigned,
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function postUpsert(Request $request): RedirectResponse
    {
        $rules = [
            'name'          => 'required|max:100',
            'description'   => 'required|max:200',
            'is_featured'   => 'required|in:1,0',
            'listing_order' => 'required|numeric|max:200',
        ];

        $this->validate($request, $rules);

        $album = new PhotoAlbum;

        if (!empty($id = $request->input('id'))) {
            $album = PhotoAlbum::query()->findOrFail($id);
        }

        $data            = $request->only(array_keys($rules));
        $data['user_id'] = auth()->id();
        $data['site_id'] = site_id();
        $album->fill($data);
        $album->save();

        return redirect()->route('admin.photos.albums');
    }

    /**
     * @throws ValidationException
     */
    public function postAssociate(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'album_id' => 'required|numeric',
            'ids'      => 'required|array',
        ]);

        /** @var PhotoAlbum $album */
        $album = PhotoAlbum::query()->findOrFail($request->input('album_id'));
        $album->photos()->syncWithoutDetaching($request->input('ids'));
        return back();
    }

    /**
     * @throws ValidationException
     */
    public function postDisassociate(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'album_id' => 'required|numeric',
            'ids'      => 'required|array',
        ]);

        /** @var PhotoAlbum $album */
        $album = PhotoAlbum::query()->findOrFail($request->input('album_id'));
        $album->photos()->detach($request->input('ids'));
        return back();
    }

}
