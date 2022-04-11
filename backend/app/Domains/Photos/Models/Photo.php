<?php

namespace App\Domains\Photos\Models;

use App\Domains\Aws\Models\AwsS3Upload;
use App\Support\Traits\SiteScoped;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @property AwsS3Upload $file
 */
class Photo extends Model
{
    use SiteScoped;

    protected $table = 'photos';

    protected $fillable = [
        'site_id',
        'user_id',
        's3_id',
        'is_active',
    ];

    /**
     * todo: this is only for testing
     */
    public static function builder(): Builder
    {
        return DB::table('photos AS p')
            ->selectRaw("
                    p.id                            AS id,
                    asu.s3_url                      AS image_url,
                    asu.meta->>'$.original_name'    AS original_filename
                ")
            ->join('aws_s3_uploads AS asu', 'p.s3_id', '=', 'asu.id')
            ->whereNull('p.deleted_at')
            ->where('asu.status', '=', 'uploaded')
            ->orderBy('p.id', 'desc');
    }

    public function file(): HasOne
    {
        return $this->hasOne(AwsS3Upload::class, 'id', 's3_id');
    }

    public function delete(): ?bool
    {
        $this->file->markForRemoval();
        return parent::delete();
    }

    public function albums(): BelongsToMany
    {
        return $this->belongsToMany(PhotoAlbum::class);
    }

}
