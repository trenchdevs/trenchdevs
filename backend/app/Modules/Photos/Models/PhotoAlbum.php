<?php

namespace App\Modules\Photos\Models;

use App\Modules\Aws\Models\AwsS3Upload;
use App\Modules\Sites\Traits\SiteScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property AwsS3Upload $file
 */
class PhotoAlbum extends Model
{
    use SiteScoped;

    protected $table = 'photo_albums';

    protected $fillable = [
        'site_id',
        'user_id',
        'name',
        'description',
        'is_featured',
        'rank',
    ];

    /**
     * The photos that belong to the album.
     *
     * @return BelongsToMany
     */
    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(Photo::class, 'photo_album_photos', 'photo_album_id', 'photo_id');
    }

}
